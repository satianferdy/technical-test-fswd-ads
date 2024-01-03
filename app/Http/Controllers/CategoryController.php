<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // all categories
        $categories = Category::all();

        // return response CeteogryResource
        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Fetch all categories',
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // try to create category
        try {
            $category = Category::create($request->validated());

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
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
        // Category details
        $category = Category::find($id);

        // if category not found
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        // return response CategoryResource
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        // try to update category
        try {
            $category = Category::find($id);

            // if category not found
            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], 404);
            }

            $category->update($request->validated());

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($category),
            ], 200);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Detail
        $category = Category::find($category->id);

        // if category not found
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        //delete category
        $category->delete();

        // return response success
        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
