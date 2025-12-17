<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Brand extends Model
{
    protected $connection = "mongodb";
    protected $collection = "brands";
    protected $fillable = ["name", "description", "status"];

    public function product()
    {
        return $this->hasMany(Product::class, "brand_id", "_id");
    }
}
