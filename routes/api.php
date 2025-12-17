<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductDetailController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SupplierController;

Route::get("user", function () {
    $user = [
        [
            "input" => "Peter Parker",
            "age" =>    28,
            "gender" => "male",
            "major" => "Computer Science",
            "disabled" => false,
        ],
        [
            "name" => "Mary Jane",
            "age" =>    26,
            "gender" => "female",
            "major" => "Business Administration",
            "disabled" => false,
        ]
    ];
    return $user;
});
// post
Route::post("/user", function (Request $request) {
    $input = [
        "name" => $request->input("name"),
        "age" => $request->input("age"),
        "gender" => $request->input("gender"),
        "major" => $request->input("major"),
        "disabled" => $request->input("disabled"),
    ];
    return [
        "message" => "User created successfully",
        "user" => $input,
    ];
});
// put
Route::put("/user{id}", function (Request $request, String $id) {
    $input = [
        "id" => $id,
        "name" => $request->input("name"),
        "age" => $request->input("age"),
        "gender" => $request->input("gender"),
        "major" => $request->input("major"),
        "disabled" => $request->input("disabled"),
    ];
    return [
        "message" => "User created successfully",
        "user" => $input,
    ];
});

// delete
Route::delete("/user{id}", function (String $id) {
    return [
        "message" => "User with id $id deleted successfully",
    ];
});
// Route::get('/test-insert', function () {
//     \App\Models\Brand::create([
//         'name' => 'Atlas Confirmed',
//         'description' => 'Inserted from Laravel',
//         'status' => true,
//     ]);

//     return 'Inserted into MongoDB Atlas';
// });

Route::prefix("products")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/search", [ProductController::class, "search"]);
    Route::get("/", [ProductController::class, "index"]);
    Route::get("/{id}", [ProductController::class, "show"]);
    Route::post("/", [ProductController::class, "store"]);
    Route::put("/{id}", [ProductController::class, "update"]);
    Route::delete("/{id}", [ProductController::class, "destroy"]);
});

// -------------------------------------
// product-details
// -------------------------------------
Route::prefix("productDetail")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/", [ProductDetailController::class, "index"]);
    Route::get("/{id}", [ProductDetailController::class, "show"]);
    Route::post("/", [ProductDetailController::class, "store"]);
    Route::put("/{id}", [ProductDetailController::class, "update"]);
    Route::delete("/{id}", [ProductDetailController::class, "destroy"]);
});
// -------------------------------------
// categories
// -------------------------------------
Route::prefix("category")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/search", [CategoryController::class, "search"]);
    Route::get("/", [CategoryController::class, "index"]);
    Route::get("/{id}", [CategoryController::class, "show"]);
    Route::post("/", [CategoryController::class, "store"]);
    Route::put("/{id}", [CategoryController::class, "update"]);
    Route::delete("/{id}", [CategoryController::class, "destroy"]);
});
// -------------------------------------
// brands
// -------------------------------------
Route::prefix("brand")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/search", [BrandController::class, "search"]);
    Route::get("/", [BrandController::class, "index"]);
    Route::get("/{id}", [BrandController::class, "show"]);
    Route::post("/", [BrandController::class, "store"]);
    Route::put("/{id}", [BrandController::class, "update"]);
    Route::delete("/{id}", [BrandController::class, "destroy"]);
});
// -------------------------------------
// order
// -------------------------------------
Route::prefix("order")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/", [OrderController::class, "index"]);
    Route::get("/getsale", [OrderController::class, "getSale"]);
    Route::get("/{id}", [OrderController::class, "show"]);
    Route::post("/", [OrderController::class, "store"]);
    Route::put("/{id}", [OrderController::class, "update"]);
    Route::delete("/{id}", [OrderController::class, "destroy"]);
});
// -------------------------------------
// supplier
// -------------------------------------
Route::prefix("supplier")->middleware(["checkAdmin", "auth:sanctum"])->group(function () {
    Route::get("/", [SupplierController::class, "index"]);
    Route::get("/search", [SupplierController::class, "search"]);
    Route::get("/{id}", [SupplierController::class, "show"]);
    Route::post("/bulk", [SupplierController::class, "storeBulk"]);
    Route::post("/", [SupplierController::class, "store"]);
    Route::put("/{id}", [SupplierController::class, "update"]);
    Route::delete("/{id}", [SupplierController::class, "destroy"]);
});
// -------------------------------------
// purchase
// -------------------------------------
Route::prefix("purchase")->middleware("auth:sanctum")->group(function () {
    Route::get("/summaryPurchase", [PurchaseController::class, "summaryPurchase"]);
    Route::get("/", [PurchaseController::class, "index"]);
    Route::get("/{id}", [PurchaseController::class, "show"]);
    Route::post("/", [PurchaseController::class, "store"]);
    Route::put("/{id}", [PurchaseController::class, "update"]);
    Route::delete("/{id}", [PurchaseController::class, "destroy"]);
});
// ----------------------------
// auth
// -------------------
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::prefix("auth")->middleware("auth:sanctum")->group(function () {
    Route::delete("/logout", [AuthController::class, "logout"]);
    Route::get("/me", [AuthController::class, "me"]);
});
