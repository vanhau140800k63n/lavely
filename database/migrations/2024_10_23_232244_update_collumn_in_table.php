<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCollumnInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prod_attr', function (Blueprint $table) {
            $table->string('selly_attr_prod_id')->after('name');
        });

        Schema::table('prod_attr_val', function (Blueprint $table) {
            $table->string('selly_prod_attr_val_id')->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prod_attr', function (Blueprint $table) {
            $table->dropColumn('selly_attr_prod_id');
        });

        Schema::table('prod_attr_val', function (Blueprint $table) {
            $table->dropColumn('selly_prod_attr_val_id');
        });
    }
}
