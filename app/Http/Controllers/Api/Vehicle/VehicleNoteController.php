<?php

namespace App\Http\Controllers\Api\Vehicle;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Vehicle\GetVehiclesRequest;
use App\Services\Vehicle\VehicleNoteService;
use App\Services\Vehicle\VehicleService;
use Illuminate\Http\JsonResponse;

class VehicleNoteController extends ApiController
{
    private VehicleNoteService $vehicleNoteService;

    public function __construct(VehicleNoteService $vehicleNoteService)
    {
        $this->vehicleNoteService = $vehicleNoteService;
    }
    public function getStates(): JsonResponse
    {
        $states = $this->vehicleNoteService->getStates();

        return response()->json($states);
    }
}
