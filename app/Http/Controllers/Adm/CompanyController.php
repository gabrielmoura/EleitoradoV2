<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = DB::table('companies')->get();

        return view('admin.company.show', compact('companies'));
    }

    public function store(CompanyStoreRequest $request)
    {
        $data = $request->validated();
        Company::create($data);

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

    public function show($pid)
    {
        $company = Company::wherePid($pid)->firstOrFail();

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
