<?php

namespace App\Http\Controllers\Api\Workplace;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Guard\CreateUnitsRequest;
use App\Http\Requests\Api\Guard\CreateVehicleNotesRequest;
use App\Http\Requests\Api\Guard\EndGuardRequest;
use App\Http\Requests\Api\Guard\StartGuardRequest;
use App\Models\Guard\Guard;
use App\Services\Guard\GuardService;
use App\Services\Workplace\WorkplaceService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WorkplaceController extends ApiController
{
    private WorkplaceService $workplaceService;

    public function __construct(WorkplaceService $workplaceService)
    {
        $this->workplaceService = $workplaceService;
    }

    public function getFirehouses(): JsonResponse
    {
        $data = $this->workplaceService->getFirehouses();

        return response()->json($data);
    }


}
