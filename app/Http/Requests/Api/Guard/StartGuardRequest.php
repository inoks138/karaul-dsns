<?php

namespace App\Http\Requests\Api\Guard;

use Illuminate\Foundation\Http\FormRequest;

class StartGuardRequest extends FormRequest
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
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'dispatcher_id' => 'required|int|exists:employees,id',
            'prev_guard_comment' => 'nullable|string',
        ];
    }
}
