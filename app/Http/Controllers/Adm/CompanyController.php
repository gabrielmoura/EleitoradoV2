<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyUpdateRequest;
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
            'email' => ['required', 'email'],
            'phone' => ['string', 'nullable'],
            'doc' => ['string'],
            'doc_type' => ['string', 'in:br_cnpj,br_cpf', 'required_with:doc'],
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

        // https://laravel.com/docs/10.x/billing#creating-customers
        $company->createAsStripeCustomer([
            'preferred_locales' => [str_replace('_', '-', app()->getLocale())],
        ]);
        $company->createTaxId($request->doc_type, $request->doc);

        return redirect()->route('admin.company.index');
    }

    public function create()
    {
        $form = ['method' => 'POST', 'route' => ['admin.company.store']];

        return view('admin.company.form', compact('form'));
    }

    public function update(CompanyUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        Company::wherePid($pid)->firstOrFail()->update($data);

        return redirect()->route('admin.company.index');
    }

    public function show(Company $company)
    {
        return view('admin.company.show', compact('company'));
    }

    public function edit($pid)
    {
        $company = Company::wherePid($pid)->firstOrFail();
        $form = ['method' => 'PATCH', 'route' => ['admin.company.update', 'company' => $pid]];

        return view('admin.company.form', compact('company', 'form'));
    }

    public function destroy($pid)
    {
        Company::wherePid($pid)->firstOrFail()->deleteOrFail();

        return redirect()->route('admin.company.index');
    }
}
