<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Employee\GetEmployeesRequest;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\JsonResponse;

class EmployeeController extends ApiController
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getEmployees(GetEmployeesRequest $request): JsonResponse
    {
        $data = $this->employeeService->getEmployees($request->validated());

        return response()->json($data);
    }
}
