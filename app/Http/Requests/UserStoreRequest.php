<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create_user');
    }

    public function rules(): array
    {
        // users roles
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            //            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ];
    }
}
