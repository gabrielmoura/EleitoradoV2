<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = DB::table('companies')->get();

        return view('admin.company.index', compact('companies'));
    }

    public function store(Request $request)
    {

        //        $data = $request->validated();
        $this->validate($request, [
            'name' => 'required',
            'email' => ['required', 'email', 'unique:companies,email'],
            'phone' => ['string', 'nullable'],
            'doc' => ['nullable', 'string'],
            'doc_type' => ['nullable', 'string', 'in:br_cnpj,br_cpf', 'required_with:doc'],
        ]);

        $collection = collect($request->only(['name', 'email', 'phone']));
        if ($request->has('doc') && $request->has('doc_type')) {
            //https://stripe.com/docs/api/customers/create
            $collection->put('tax_id_data', [
                'type' => $request->doc_type,
                'value' => $request->doc,
            ]);
        }
        $collection->put('conf', [
            'utalk_key' => null,
            'telegram_key' => null,
            'send_mail_birthday' => false, //enviar email de aniversario
            'send_whatsapp_birthday' => false, //enviar whatsapp de aniversario
            'send_whatsapp_confirmation' => false, //enviar whatsapp de confirmação de voto
        ]);

        $company = Company::create($collection->toArray());
        if ($request->has('avatar')) {
            $company
                ->addFromMediaLibraryRequest($request->avatar)
                ->toMediaCollection('avatar');
        }
        // https://laravel.com/docs/10.x/billing#creating-customers
        $company->createAsStripeCustomer([
            'preferred_locales' => [str_replace('_', '-', app()->getLocale())],
        ]);
        $company->createTaxId($request->doc_type, $request->doc);

        return redirect()->route('admin.company.index');
    }

    public function create()
    {
        $form = ['method' => 'POST', 'route' => route('admin.company.store')];

        return view('admin.company.form', compact('form'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->only(['name', 'email', 'phone']);

        if ($request->has('avatar')) {
            $company->clearMediaCollection('avatar');
            $company
                ->addFromMediaLibraryRequest($request->avatar)
                ->toMediaCollection('avatar');
        }
        $company->update($data);

        return redirect()->route('admin.company.index');
    }

    public function show(Company $company)
    {
        return view('admin.company.show', compact('company'));
    }

    public function edit(Company $company)
    {
        //        $company = Company::wherePid($pid)->firstOrFail();
        $form = ['method' => 'PATCH', 'route' => route('admin.company.update', ['company' => $company->id])];

        return view('admin.company.form', compact('company', 'form'));
    }

    public function destroy(Company $company)
    {
        $company->deleteOrFail();

        return redirect()->route('admin.company.index');
    }
}
