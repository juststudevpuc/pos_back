<?php

namespace App\Models;

use MongoDB\laravel\Eloquent\Model;

class Product extends Model
{
    //
    protected $connection = "mongodb";
    protected $table = "products";
    protected $fillable = [
        "name",
        "description",
        "price",
        "qty",
        "discount",
        "status",
        "image",
        "image_url",
        "image_public_id",
        "category_id",
        "brand_id"
    ];
    // protected $appends = ["image_url"];

    // public function getImageUrlAttribute()
    // {
    //     return asset("storage/" . $this->image);
    // }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class, " product_id", "_id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "_id");
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id", "_id");
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, "product_id", "_id");
    }
    public function purchaseProduct()
    {
        return $this->hasMany(PurchaseProduct::class, "product_id", "_id");
    }
}
