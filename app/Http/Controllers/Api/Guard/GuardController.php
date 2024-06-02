<?php

namespace App\Http\Controllers\Api\Guard;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Guard\CreateUnitsRequest;
use App\Http\Requests\Api\Guard\StartGuardRequest;
use App\Models\Guard\Guard;
use App\Services\Guard\GuardService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GuardController extends ApiController
{
    private GuardService $guardService;

    public function __construct(GuardService $guardService)
    {
        $this->guardService = $guardService;
    }

    public function startGuard(StartGuardRequest $request): JsonResponse
    {
        $guard = $this->guardService->startGuard($request->validated());

        return response()->json($guard, Response::HTTP_CREATED);
    }

    public function getCurrentGuard(): JsonResponse
    {
        $guard = $this->guardService->getCurrentGuard();

        return response()->json($guard);
    }

    public function createUnits(Guard $guard, CreateUnitsRequest $request): JsonResponse
    {
        $this->guardService->createUnitsForGuard($request->validated(), $guard);

        return response()->json([], Response::HTTP_CREATED);
    }
}