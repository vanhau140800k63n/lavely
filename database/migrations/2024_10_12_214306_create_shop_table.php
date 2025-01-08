<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration
{
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('selly_shop_id');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('product_count')->default(0);
            $table->unsignedInteger('sold_count')->default(0);
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop');
    }
}
