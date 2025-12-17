<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    //
    protected $connection = "mongodb";
    protected $table = "orders";
    protected $fillable = [
        "order_no",
        "total_amount",
        "total_paid",
        "remark",
        "payment_method",
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "_id");
    }

}
