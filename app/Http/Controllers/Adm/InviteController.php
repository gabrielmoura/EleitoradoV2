<?php

namespace App\Http\Controllers\Adm;

use App\Events\System\GeneratedInviteEvent;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InviteController extends Controller
{
    public function index()
    {
        return view('admin.invite.show');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $this->validate($request, [
            'email' => 'required|email',
            'company_id' => 'required|exists:companies,id',
            'role' => 'required|in:manager,employee',
        ]);

        $company = Company::find($request->company_id);

        $url = URL::signedRoute('auth.invite.index', [
            'tenant_id' => $company->tenant_id,
            'company_id' => $company->id,
            'email' => $request->email,
            'role' => $request->role,
        ], now()->addMinutes(30));

        event(new GeneratedInviteEvent($url, $request->email, $request->role, $request->company_id, $company->tenant_id, '30 minutos'));
        flasher()->addSuccess('Convite enviado com sucesso!');

        return redirect()->route('admin.company.index');
    }
}
