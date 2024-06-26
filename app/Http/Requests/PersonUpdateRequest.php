<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class PersonUpdateRequest extends FormRequest
{
    use ValidatesMedia;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update_person');
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
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'cellphone' => ['nullable', 'string', 'max:20', 'min:11'],
            'telephone' => ['nullable', 'string', 'max:20', 'min:10'],
            'cpf' => ['nullable', 'string', 'max:30'],
            'rg' => ['nullable', 'string', 'max:30'],
            'dateOfBirth' => ['nullable', 'date'],
            'sex' => ['nullable', 'string', 'max:1'],
            'observation' => ['nullable', 'string'],

            /** Dados Eleitorais */
            'voter_zone' => 'nullable|string|max:255',
            'voter_section' => 'nullable|string|max:255',
            'voter_registration' => 'nullable|string|max:255',
            'skinColor' => 'nullable|string|max:255',
            'maritalStatus' => 'nullable|string|max:255',
            'educationLevel' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'housing' => 'nullable|string|max:255',
            'sexualOrientation' => 'nullable|string|max:255',
            'genderIdentity' => 'nullable|string|max:255',
            'deficiencyType' => 'nullable|string|max:255',

            /** Endereço */
            'street' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'zipcode' => ['nullable', 'string', 'min:8', 'max:9', 'regex:/^[0-9]{5}-?[0-9]{3}$/'],
            'uf' => 'nullable|string|max:2',

            /** Avatar */
            'avatar' => [
                'nullable',
                $this->validateSingleMedia()
                    ->extension(['png', 'jpg', 'jpeg'])
                    ->maxTotalSizeInKb(2048),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            /** Endereço */
            'zipcode' => 'CEP',
            'uf' => 'Estado',
            'street' => 'Rua',
            'number' => 'Número',
            'complement' => 'Complemento',
            'district' => 'Bairro',
            'city' => 'Cidade',
            'state' => 'Estado',
            'country' => 'País',

            'name' => 'Nome',
            'email' => 'E-mail',
            'cellphone' => 'Celular',
            'telephone' => 'Telefone',
            'cpf' => 'CPF',
            'rg' => 'RG',
            'dateOfBirth' => 'Data de Aniversário',
            'sex' => 'Sexo',
            'observation' => 'Observação',

            /** Dados Eleitorais */
            'voter_zone' => 'Zona Eleitoral',
            'voter_section' => 'Seção Eleitoral',
            'voter_registration' => 'Inscrição Eleitoral',
            'skinColor' => 'Cor/Raça',
            'maritalStatus' => 'Estado Civil',
            'educationLevel' => 'Escolaridade',
            'occupation' => 'Ocupação',
            'religion' => 'Religião',
            'housing' => 'Moradia',
            'sexualOrientation' => 'Orientação Sexual',
            'genderIdentity' => 'Identidade de Gênero',
            'deficiencyType' => 'Tipo de Deficiência',
        ];
    }
}
