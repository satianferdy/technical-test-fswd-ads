<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductAssetsRequest;
use App\Models\ProductAssets;
use Illuminate\Http\Request;
use App\Http\Resources\ProductAssetsResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductAssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product assets
        $productAssets = ProductAssets::all();

        // return a collection of product assets
        return ProductAssetsResource::collection($productAssets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductAssetsRequest $request)
    {
        // try to create product assets
        try {

            $imageName = Str::random(10) . '.' . $request->image->getClientOriginalExtension();

            // create product assets
            $productAssets = ProductAssets::create([
                'product_id' => $request->product_id,
                'image' => $imageName,
            ]);

            // save image to storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Product assets created successfully',
                'data' => new ProductAssetsResource($productAssets),
            ], 201);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductAssetsRequest $request, $id)
    {
        // try to update product assets
        try {
            // find product assets
            $productAssets = ProductAssets::find($id);
            // if product assets not found
            if (!$productAssets) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product assets not found'
                ], 404);
            }

            $productAssets->product_id = $request->product_id;

            // if image is uploaded
            if ($request->image) {
                // public storage
                $storage = Storage::disk('public');

                // delete old image
                if ($storage->exists($productAssets->image)) {
                    $storage->delete($productAssets->image);
                }

                // generate new image name
                $imageName = Str::random(10) . '.' . $request->image->getClientOriginalExtension();
                $productAssets->image = $imageName;

                // save new image
                $storage->put($imageName, file_get_contents($request->image));
            }

            // update product assets
            $productAssets->save();

            // return response success
            return response()->json([
                'success' => true,
                'message' => 'Product assets updated successfully',
                'data' => new ProductAssetsResource($productAssets),
            ]);

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
    public function destroy($id)
    {
        // detail
        $productAssets = ProductAssets::find($id);

        // if product assets not found
        if (!$productAssets) {
            return response()->json([
                'success' => false,
                'message' => 'Product assets not found'
            ], 404);
        }

        // public storage
        $storage = Storage::disk('public');

        // delete image
        if ($storage->exists($productAssets->image)) {
            $storage->delete($productAssets->image);
        }

        // try to delete product assets
        try {
            $productAssets->delete();

            // return success message
            return response()->json([
                'success' => true,
                'message' => 'Product assets deleted successfully'
            ]);
        } catch (\Exception $e) {
            // return error message
            return response()->json([
                'message' => "Something went wrong. Please try again later."
            ], 500);
        }
    }
}
