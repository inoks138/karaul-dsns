<?php

namespace App\Http\Requests\Api\Guard;

use Illuminate\Foundation\Http\FormRequest;

class CreateUnitsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'units' => 'required|array',
            'units.*.number' => 'required|int',
            'units.*.commander_id' => 'required|int|exists:employees,id',
            'units.*.driver_id' => 'required|int|exists:employees,id',
            'units.*.vehicle_id' => 'required|int|exists:vehicles,id',
            'units.*.firefighters' => 'nullable|array',
            'units.*.firefighters.*' => 'required|int|exists:employees,id',
        ];
    }
}
