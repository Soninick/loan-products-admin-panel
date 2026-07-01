<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\EligibleProductResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\EligibilityEngineService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()->with('role')->latest()->get();

        return UserResource::collection($users)->additional([
            'message' => 'Users retrieved successfully.',
        ])->response();
    }

    public function store(UserRequest $request, EligibilityEngineService $eligibilityEngineService): JsonResponse
    {
        $user = User::query()->create($request->validated());

        $eligibilityEngineService->evaluateUser($user);

        return response()->json([
            'message' => 'User created successfully.',
            'data' => new UserResource($user->fresh()->load('role')),
        ], 201);
    }

    public function eligibleProducts(int $id): JsonResponse
    {
        $user = User::query()->with('eligibleProducts.product')->findOrFail($id);

        return EligibleProductResource::collection($user->eligibleProducts)->additional([
            'message' => 'Eligible products retrieved successfully.',
        ])->response();
    }
}
