<?php

namespace App\Http\Controllers\Api\Emergency;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Emergency\SyncLiquidationsRequest;
use App\Models\Emergency\Emergency;
use App\Services\Emergency\EmergencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmergencyController extends ApiController
{
    private EmergencyService $emergencyService;

    public function __construct(EmergencyService $emergencyService)
    {
        $this->emergencyService = $emergencyService;
    }

    public function getTypes(): JsonResponse
    {
        $data = $this->emergencyService->getTypes();

        return response()->json($data);
    }

    public function getActiveEmergencies(): JsonResponse
    {
        $data = $this->emergencyService->getActiveEmergencies();

        return response()->json($data);
    }

    public function getEmergency(Emergency $emergency): JsonResponse
    {
        $data = $this->emergencyService->getEmergency($emergency);

        return response()->json($data);
    }

    public function acceptLiquidation(Emergency $emergency): JsonResponse
    {
        $this->emergencyService->acceptLiquidation($emergency);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function declineLiquidation(Emergency $emergency, Request $request): JsonResponse
    {
        $this->emergencyService->declineLiquidation($emergency, $request->all());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function closeLiquidation(Emergency $emergency): JsonResponse
    {
        $this->emergencyService->closeLiquidation($emergency);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function syncLiquidations(Emergency $emergency, SyncLiquidationsRequest $request): JsonResponse
    {
        $data = $this->emergencyService->syncLiquidations($emergency, $request->validated());

        return response()->json($data);
    }

    public function getComments(Emergency $emergency): JsonResponse
    {
        $data = $this->emergencyService->getComments($emergency);

        return response()->json($data);
    }

    public function storeComment(Emergency $emergency, Request $request): JsonResponse
    {
        $data = $this->emergencyService->storeComment($emergency, $request->all());

        return response()->json($data, Response::HTTP_CREATED);
    }
}
