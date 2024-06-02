<?php

namespace App\Http\Controllers\Api\Vehicle;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Vehicle\GetVehiclesRequest;
use App\Services\Vehicle\VehicleService;
use Illuminate\Http\JsonResponse;

class VehicleController extends ApiController
{
    private VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function getVehicles(GetVehiclesRequest $request): JsonResponse
    {
        $data = $this->vehicleService->getVehicles($request->validated());

        return response()->json($data);
    }
}
