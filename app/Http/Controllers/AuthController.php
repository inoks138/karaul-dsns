<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'errors' => [
                    'email' => 'The provided credentials do not match the records.',
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = auth()->user();

        $request->session()->regenerate();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('bearer')->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->regenerateToken();
        $request->user()->tokens()->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getCurrentUserData(): JsonResponse
    {
        $user = auth()->user();

        return response()->json($user);
    }

//    public function register(StoreUserRequest $request): JsonResponse
//    {
//        $user = $this->userService->create($request->validated());
//
//        Auth::login($user);
//
//        $request->session()->regenerate();
//
//        return response()->json($user);
//    }
}