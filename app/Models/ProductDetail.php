<?php

namespace App\Models;

use App\Traits\HashBarcodeTrait;
use MongoDb\Laravel\Eloquent\Model;

class ProductDetail extends Model
{
    use HashBarcodeTrait;
    protected $connection = 'mongodb';
    protected $collection = 'product_details';
    protected $fillable = [
        "color",
        "size",
        "made_in",
        "product_id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "_id");
    }
}
