<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Autorization extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|min:5']);
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                return $this->createToken(Auth::user());
            }
        } catch (\Exception $e) {
            report($e);
            abort(401, __('error.Unauthorized'));
        }
    }

    private function createToken(User $user): array
    {
        abort_if(! $user->hasPermissionTo('update_person'), 401, __('error.Unauthorized'));

        $ability = $user->permissions()->pluck('name')->toArray();

        $token = $user->createToken('Token Api', $ability, now()->addHours(8));

        return [
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->accessToken->expires_at,
            'user' => $user,
        ];
    }
}
