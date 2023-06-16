<?php

namespace App\Http\Controllers\Auth;

use App\Events\System\UserCreatedByInvitationEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CelularComDdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class InviteController extends Controller
{
    public function index(Request $request)
    {
        abort_if(! $request->hasValidSignature(), Response::HTTP_UNAUTHORIZED, 'Este link de convite é inválido.');
        session([
            'tenant_id' => $request->tenant_id,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return view('auth.invite');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->uncompromised()],
            'phone' => ['required', 'string', new CelularComDdd],
        ]);
        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'email' => session('email'),
                'company_id' => session('company_id'),
                'password' => $request->password,
                'phone' => $request->phone,
            ]);
            $user->assignRole(session('role') ?? 'user');
            event(new UserCreatedByInvitationEvent($user));
        }, 5);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso!');
    }
}
