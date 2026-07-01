<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\EligibilityEngineService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()->latest()->get();

        return ProductResource::collection($products)->additional([
            'message' => 'Products retrieved successfully.',
        ])->response();
    }

    public function store(ProductRequest $request, EligibilityEngineService $eligibilityEngineService): JsonResponse
    {
        $product = Product::query()->create($request->validated());

        $eligibilityEngineService->evaluateAllUsers();

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => new ProductResource($product->fresh()),
        ], 201);
    }

    public function update(ProductRequest $request, int $id, EligibilityEngineService $eligibilityEngineService): JsonResponse
    {
        $product = Product::query()->findOrFail($id);
        $product->update($request->validated());

        $eligibilityEngineService->evaluateAllUsers();

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product->fresh()),
        ]);
    }
}
