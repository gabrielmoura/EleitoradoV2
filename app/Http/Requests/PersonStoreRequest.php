<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PersonStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create_person');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'cellphone' => ['nullable', 'string', 'max:13'],
            'telephone' => ['nullable', 'string', 'max:12'],
            'cpf' => ['nullable', 'string', new Cpf],
            'rg' => ['nullable', 'string', 'max:30'],
            'birth_date' => ['nullable', 'date'],
            'sex' => ['nullable', 'string', 'max:1'],
            'observation' => ['nullable', 'string'],

            'street' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'zipcode' => ['nullable', 'string', 'max:11'],
            'uf' => 'nullable|string|max:2',

        ];
    }
}
