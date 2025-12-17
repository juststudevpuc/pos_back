<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_products', function (Blueprint $collection) {
            $collection->id();
            $collection->string("qty");
            $collection->string("cost");
            $collection->string("retail_price");
            $collection->string("ref");
            $collection->string("remark");
            
            $collection->objectId("product_id");
            $collection->objectId("purchase_id");
            $collection->index("product_id");
            $collection->index("purchase_id");
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_products');
    }
};
