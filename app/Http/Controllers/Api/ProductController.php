<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cloudinary\Cloudinary as CloudinaryAlias;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // search
    public function search(Request $request)
    {
        $query = $request->query("q");
        $products = Product::where("name", "like", "%" . $query . "%")->get();
        return response()->json([
            "Query" => $query,
            "data" => $products,
            "message" => "Search product successfully"
        ]);
    }
    //get
    public function index()
    {
        $product = Product::all();

        return [
            "data" => $product->load(["category", "brand"]),
            "message" => "Products retrieved successfully"
        ];
    }
    // show = get by id => get
    public function show(String $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return [
                "message" => "Product not found"
            ];
        }
        return [
            "data" =>  $product->load(["category", "brand"]),
            "message" => "Product retrieved successfully"
        ];
    }
    // store = create => post
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name" => "required|string|max:255|min:3",
            "description" => "required|string|max:255|min:3",
            "price" => "required|integer|min:0",
            "qty" => "required|integer|min:0",
            "discount" => "required|integer|min:0",
            'status' => 'required|boolean',
            "category_id" => "required|string|exists:categories,_id",
            "brand_id" => "required|string|exists:brands,_id",
            "image" => "nullable|file|max:2048"
        ]);
        // if ($request->hasFile("image")) {
        //     $validate["image"] = $request->file("image")->store("products", "public");
        // }

        // upload img with cloudinary
        if ($request->hasFile("image")) {
            $upload = Cloudinary::uploadApi()->upload(
                $validate["image"]->getRealPath(),
                ["folder" => config("cloudinary.upload_preset", "img_pos")]
            );
            $validate["image_url"] = $upload["secure_url"];
            $validate["image_public_id"] = $upload["public_id"];
        }

        $product = new Product();

        $product->fill($validate);
        $product->save();
        return [
            "data" =>  $product->load(["category", "brand"]),
            "message" => "Product created successfully"
        ];
    }
    // update => put
    public function update(Request $request, String $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return [
                "message" => "Product not found"
            ];
        }
        $validate = $request->validate([
            "name" => "required|string|max:255|min:3",
            "description" => "required|string|max:255|min:3",
            "price" => "required|integer|min:0",
            "qty" => "required|integer|min:0",
            "discount" => "required|integer|min:0",
            'status' => 'required|boolean',
            "category_id" => "required|string|exists:categories,_id",
            "brand_id" => "required|string|exists:brands,_id",
            "image" => "nullable|file|max:2048"

        ]);
        // for local
        // $validate["status"] === "1" ? $validate["status"] =    true : $validate["status"] = false;

        // if ($request->hasFile("image")) {
        //     // delete old image
        //     if ($product->image && Storage::disk("public")->exists($product->image)) {
        //         Storage::disk("public")->delete($product->image);
        //     };

        //     // create new image
        //     $validate["image"] = $request->file("image")->store("products", "public");
        // }
        // upload img with cloudinary
        if ($request->hasFile("image")) {
            // delete old img

            if (!empty($product->image_public_id)) {
                Cloudinary::uploadApi()->destroy($product->image_public_id);
            }
            // upload new img
            $upload = Cloudinary::uploadApi()->upload(
                $validate["image"]->getRealPath(),
                ["folder" => config("cloudinary.upload_preset", "img_pos")]
            );
            $validate["image_url"] = $upload["secure_url"];
            $validate["image_public_id"] = $upload["public_id"];
        }

        $product->fill($validate);
        $product->save();
        return [
            "data" =>  $product->load(["category", "brand"]),
            "message" => "Product updated successfully"
        ];
    }
    // delete
    public function destroy(String $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return [
                "message" => "Product not found"
            ];
        }

        // delete image
        // if ($product->image && Storage::disk("public")->exists($product->image)) {
        //     Storage::disk("public")->delete($product->image);
        // };

        if (!empty($product->image_public_id)) {
            Cloudinary::uploadApi()->destroy($product->image_public_id);
        }

        $product->delete();
        return [
            "message" => "Product deleted successfully. ",
            "data" => $product->load(["category", "brand"]),
        ];
    }
}
