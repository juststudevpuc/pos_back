<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDetail;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productDetails = ProductDetail::all();

        return response()->json([
            'data' => $productDetails->load("product"),
            'message' => 'Product details retrieved successfully',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $input =[
            "color" => $request->input('color'),
            "size" => $request->input('size'),
            "made_in" => $request->input('made_in'),
            "product_id" => $request->input('product_id'),

        ];
        $productDetails = new ProductDetail();
        $productDetails->fill($input);
        $productDetails->save();
        return response()->json([
            'data' => $productDetails->load("product"),
            'message' => 'Product details created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $productDetails = ProductDetail::find($id);
        if (!$productDetails) {
            return response()->json([
                'message' => 'Product details not found',
            ], 404);
        }
        return response()->json([
            'data' => $productDetails->load("product"),
            'message' => 'Product details retrieved successfully',
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $productDetails = ProductDetail::find($id);
        if (!$productDetails) {
            return response()->json([
                'message' => 'Product details not found',
            ], 404);
        }
        $input =[
            "color" => $request->input('color'),
            "size" => $request->input('size'),
            "made_in" => $request->input('made_in'),
            "product_id" => $request->input('product_id'),
        ];
        $productDetails->fill($input);
        $productDetails->save();
        return response()->json([
            'data' => $productDetails->load("product"),
            'message' => 'Product details updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $productDetails = ProductDetail::find($id);
        if (!$productDetails) {
            return response()->json([
                'message' => 'Product details not found',
            ], 404);
        }
        $productDetails->delete();
        return response()->json([
            'data' => $productDetails->load("product"),
            'message' => 'Product details deleted successfully',
        ], 200);
    }
}
