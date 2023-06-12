<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update_user');
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'role' => 'string|exists:roles,name',
            'email' => 'string|email|max:255|unique:users,email,'.$this->route('user').',id',
        ];
    }
}
