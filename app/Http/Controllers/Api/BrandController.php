<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    use ApiResponseTrait;

    public function search(Request $req)
    {
        $query = $req->query("q");
        $brand = Brand::where("name", "like", "%" . $query . "%")->get();
        return response()->json([
            "Query" => $query,
            "data" => $brand,
            "message" => "Get brand successfully."
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::query()->get();

        // return response()->json([
        //     "data" => $brand->load("product"),
        //     "message" => "Get brand successfully."
        // ], 200);

        return $this->successApiResponse($brand->load("product"), "Get brand successfully", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name" => "required|string|min:3|max:255",
            "description" => "required|string|min:3|max:255",
            "status" => "required|boolean",
        ]);

        $brand = Brand::create($validate);

        return response()->json([
            "data" => $brand->load("product"),
            "message" => "Created brand successfully."
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                "message" => "Cetegory is not found."
            ], 404);
        }

        return response()->json([
            "data" => $brand->load("product"),
            "message" => "Get one brand successfully."
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                "message" => "Cetegory is not found."
            ], 404);
        }

        $validate = $request->validate([
            "name" => "required|string|min:3|max:255",
            "description" => "required|string|min:3|max:255",
            "status" => "required|boolean",
        ]);

        $brand->update($validate);

        return response()->json([
            "data" => $brand->load("product"),
            "message" => "Updated brand successfully."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                "message" => "Cetegory is not found."
            ], 404);
        }

        $brand->delete();

        return response()->json([
            "data" => $brand->load("product"),
            "message" => "Deleted brand successfully."
        ], 200);
    }
}
