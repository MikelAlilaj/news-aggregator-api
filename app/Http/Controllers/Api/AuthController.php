<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->authService->register($validatedData);
        $token = $this->authService->createToken($user);

        return response()->json(['success' => true, 'token' => $token, 'user' => $user], 201);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->authService->login($validatedData);
        $token = $this->authService->createToken($user);

        return response()->json(['success' => true, 'token' => $token, 'user' => $user], 200);
    }
}
