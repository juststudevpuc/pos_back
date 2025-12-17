<?php

namespace App\Models;

use MongoDB\laravel\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $connection = "mongodb";
    protected $table = "suppliers";
    protected $fillable = [
        "name",
        "email",
        "address",
        "tel",
        "website",
    ];

    public function purchase()
    {
        return $this->hasMany(Purchase::class, "supplier_id");
    }
}
