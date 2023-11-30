<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Vite;

class CompanyController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $avatar = Vite::asset('resources/images/company-logo.png');
        if ($company->hasMedia('avatar')) {
            $avatar = $company->getFirstMedia('avatar')->getUrl('cover');
        }

        return view('dash.company.show', compact('company', 'avatar'));
    }

    public function edit($pid)
    {
        // Definir Configurações da Empresa
        $company = auth()->user()->company;
        $form = ['method' => 'PATCH', 'route' => ['dash.company.update', 'company' => $pid]];

        return view('dash.company.form', compact('company', 'form'));
    }

    public function update(CompanyUpdateRequest $request, $pid)
    {
        $data = $request->validated();
        Company::where('pid', $pid)->firstOrFail()->update($data);

        return redirect()->route('dash.company.index');
    }
}
