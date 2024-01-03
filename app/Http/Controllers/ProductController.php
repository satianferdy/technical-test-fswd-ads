<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get latest products
        $products = Product::latest()->get();

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Fetch all products',
            'data' => ProductResource::collection($products),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        // try to create product
        try {
            $product = Product::create($request->validated());

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProductResource($product),
            ], 201);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Product details
        $product = Product::find($id);

        // if product not found
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // return response ProductResource
        return response()->json([
            'success' => true,
            'message' => 'Product details',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, $id)
    {
        // try to update product
        try {
            $product = Product::find($id);

            // if product not found
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $product->update($request->validated());

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product),
            ]);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'success' => false,
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // detail
        $product = Product::find($product->id);

        // if product not found
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // try to delete product
        try {
            $product->delete();

            // return success message
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'success' => false,
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }
    }
}
