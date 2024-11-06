<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPreferencesRequest;
use App\Services\UserPreferenceService;

class UserPreferenceController extends Controller
{
    protected $userPreferenceService;

    public function __construct(UserPreferenceService $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    public function update(UpdateUserPreferencesRequest $request)
    {
        $validatedData = $request->validated();
        $this->userPreferenceService->updatePreferences($validatedData);

        return response()->json([
            'success' => true,
            'data' => $validatedData, 
        ], 200);
    }


    public function index()
    {
        $data = $this->userPreferenceService->getUserPreferences();

        return response()->json([
            'success' => true,
            'data' => $data, 
        ], 200);
    }
}
