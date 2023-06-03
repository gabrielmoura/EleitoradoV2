<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{


    public function show($pid)
    {
        $company = Company::find($pid);
        return view('dash.company.show', compact('company'));
    }


    public function edit($pid)
    {
        $company = Company::find($pid);
        $form = ['method' => 'PATCH', 'route' => ['dash.company.update', 'company' => $pid]];
        return view('dash.company.form', compact('company', 'form'));
    }

    public function update(CompanyUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        Company::wherePid($pid)->firstOrFail()->update($data);
        return redirect()->route('dash.company.index');
    }


}
