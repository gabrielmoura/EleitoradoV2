<?php

namespace App\Http\Requests\Demand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DemandUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update_demand');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'tenant_id' => ['string', 'max:40'],
            'priority' => ['string'],
            'active' => ['boolean'],
            'demand_type_id' => ['required', 'integer'],
            'solution_date' => ['date'],
            'status' => ['string'],
        ];
    }
}
