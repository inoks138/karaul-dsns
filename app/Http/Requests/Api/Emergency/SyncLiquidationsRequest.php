<?php

namespace App\Http\Requests\Api\Emergency;

use Illuminate\Foundation\Http\FormRequest;

class SyncLiquidationsRequest extends FormRequest
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
            'liquidations' => 'required|array',
            'liquidations.*.id' => 'nullable|int|exists:emergency_liquidations,id',
            'liquidations.*.unit_id' => 'required|int|exists:units,id',
            'liquidations.*.vehicle_id' => 'required|int|exists:vehicles,id',
            'liquidations.*.departured_at' => 'nullable|date|date_format:Y-m-d H:i:s',
            'liquidations.*.arrived_at' => 'nullable|date|date_format:Y-m-d H:i:s',
            'liquidations.*.first_barrel_delivered_at' => 'nullable|date|date_format:Y-m-d H:i:s',
            'liquidations.*.localized_at' => 'nullable|date|date_format:Y-m-d H:i:s',
            'liquidations.*.liquidated_at' => 'nullable|date|date_format:Y-m-d H:i:s',
            'liquidations.*.returned_at' => 'nullable|date|date_format:Y-m-d H:i:s',
        ];
    }
}
