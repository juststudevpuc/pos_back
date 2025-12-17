<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    // search
    public function search(Request $request)
    {
        $query = $request->query("q");
        $category = Category::where("name", "like", "%" . $query . "%")->get();

        return response()->json([
            "Query" => $query,
            "data" => $category
        ], 200);
    }

    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = Category::query()->get();

        // return response()->json([
        //     'data' => $category->load("product"),
        //     'message' => 'Category List',
        // ], 200);
        return $this->successApiResponse($category->load("product"), "Get category successfully", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        // $validate = $request->validate([
        //     'name' => 'required|string|min:3|max:255',
        //     'description' => 'required|string|min:3|max:255',
        //     'status' => 'required|boolean',
        // ]);
        $category = Category::create($request->validated());
        return response()->json([
            'data' => $category->load("product"),
            'message' => 'Category Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category Not Found',
            ], 404);
        }
        return response()->json([
            'data' => $category->load("product"),
            'message' => 'Category Details',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category Not Found',
            ], 404);
        }

        // $validate = $request->validate([
        //     'name' => 'required|string|min:3|max:255',
        //     'description' => 'required|string|min:3|max:255',
        //     'status' => 'required|boolean',
        // ]);

        $category->update($request->validated());
        return response()->json([
            'data' => $category->load("product"),
            'message' => 'Category Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category Not Found',
            ], 404);
        }
        $category->delete();

        return response()->json([
            'message' => 'Category Deleted Successfully',
            'data' => $category->load("product"),
        ], 200);
    }
}
