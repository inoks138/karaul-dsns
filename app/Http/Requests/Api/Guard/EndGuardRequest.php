<?php

namespace App\Http\Requests\Api\Guard;

use Illuminate\Foundation\Http\FormRequest;

class EndGuardRequest extends FormRequest
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
            'end_time' => 'required|date_format:Y-m-d H:i:s',
            'vacation_employees_count' => 'required|int',
            'sick_employees_count' => 'required|int',
            'business_trip_employees_count' => 'required|int',
            'stock_employees_count' => 'required|int',
            'service_inspection' => 'required|string',
            'malfunctions' => 'required|string',

            'internal_services' => 'required|array',
            'internal_services.*.type_id' => 'required|int|exists:guard_internal_service_types,id',
            'internal_services.*.employee_id' => 'required|int|exists:employees,id',
            'internal_services.*.start_time' => 'required|date_format:Y-m-d H:i:s',

            'fire_hose_usages' => 'required|array',
            'fire_hose_usages.*.diameter' => 'required|numeric',
            'fire_hose_usages.*.hose_number' => 'required|string',
            'fire_hose_usages.*.work_time_seconds' => 'required|int',
        ];
    }
}
