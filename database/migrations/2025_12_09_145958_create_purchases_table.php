<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $collection) {
            $collection->id();
            $collection->string("shipping_cost");
            $collection->string("paid");
            $collection->string("paid_date");
            
            $collection->obectId("supplier_id");
            $collection->index("supplier_id");
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
