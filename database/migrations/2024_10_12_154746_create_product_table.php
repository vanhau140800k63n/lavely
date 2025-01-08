<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->decimal('original_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->unsignedInteger('sold')->default(0);
            $table->float('rate')->default(0);
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('shop_id');
            $table->string('selly_product_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
