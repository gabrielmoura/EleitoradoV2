<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Autorization extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|min:5']);
        try {
            $auth = auth();
            if ($auth->attempt($request->only('email', 'password'))) {
                $user = $auth->user();

                if (! $user->hasPermissionTo('use_api')) {
                    return response(null, 401);
                }
                if ($user->hasRole('admin')) {
                    $ability = ['admin', 'clients', 'lawyer', 'employer', 'companies', 'edit-company', 'analytics', 'users'];
                } else {
                    $ability = ['analytics'];
                }

                $token = $auth->user()->createToken('Token Api', $ability);

                return ['token' => $token->plainTextToken];
            } else {
                return response()->json(['error' => __('error.Unauthorized')], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
