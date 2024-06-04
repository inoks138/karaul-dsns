<?php

namespace App\Http\Requests\Api\Guard;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleNotesRequest extends FormRequest
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
            'vehicles' => 'required|array',
            'vehicles.*.vehicle_id' => 'required|int|exists:vehicles,id',
            'vehicles.*.state_id' => 'required|int|exists:vehicle_note_states,id',
            'vehicles.*.state_comment' => 'nullable|string',
            'vehicles.*.fuel' => 'required|string',
            'vehicles.*.fire_extinguishing_equipment' => 'required|string',
        ];
    }
}
