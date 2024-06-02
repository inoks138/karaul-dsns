<?php

namespace App\Http\Requests\Api\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class GetVehiclesRequest extends FormRequest
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
            'firehouse_id' => 'nullable|int|exists:firehouses,id',
            'vehicle_type_id' => 'nullable|array',
            'vehicle_type_id.*' => 'required|int|exists:vehicle_types,id',
            'search' => 'nullable|string',
        ];
    }
}
