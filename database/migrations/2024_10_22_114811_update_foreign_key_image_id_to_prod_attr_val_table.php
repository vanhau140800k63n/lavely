<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyImageIdToProdAttrValTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prod_attr_val', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('image')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prod_attr_val', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
        });
    }
}
