<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdAttrValTable extends Migration
{
    public function up()
    {
        Schema::create('prod_attr_val', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prod_attr_id');
            $table->string('value');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();
            $table->foreign('prod_attr_id')->references('id')->on('prod_attr')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prod_attr_val');
    }
}
