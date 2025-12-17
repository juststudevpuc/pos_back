<?php

namespace App\Models;

use MongoDB\laravel\Eloquent\Model;

class PurchaseProduct extends Model
{
    //
    protected $connection = "mongodb";
    protected $table = "purchase_products";
    protected $fillable = [
        "qty",
        "retail_price",
        "cost",
        "ref",
        "remark",
        "product_id",
        "purchase_id",
    ];
    public function product(){
        return $this->belongsTo(Product::class, "product_id" , "_id");
    }
     public function purchase(){
        return $this->belongsTo(Purchase::class, "purchase_id" , "_id");
    }
}
