<?php

namespace App\Http\Controllers\Adm;

use App\Actions\Tools\CompanyConfig;
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
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:companies,email'],
            'phone' => ['string', 'nullable'],
            'doc' => ['nullable', 'string'],
            'doc_type' => ['nullable', 'string', 'in:br_cnpj,br_cpf', 'required_with:doc'],
        ]);

        $data = $request->only(['name', 'email', 'phone']);

        if ($request->filled('doc', 'doc_type')) {
            $data['tax_id_data'] = [
                'type' => $request->input('doc_type'),
                'value' => $request->input('doc'),
            ];
        }

        $data['conf'] = CompanyConfig::default();

        $company = Company::create($data);

        if ($request->hasFile('avatar')) {
            $company->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        $company->createAsStripeCustomer([
            'preferred_locales' => [str_replace('_', '-', app()->getLocale())],
        ]);

        if ($request->filled('doc_type', 'doc')) {
            $company->createTaxId($request->input('doc_type'), $request->input('doc'));
        }

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
