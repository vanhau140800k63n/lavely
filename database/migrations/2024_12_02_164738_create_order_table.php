<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('address_detail')->nullable();
            $table->string('commune');
            $table->string('district');
            $table->string('province');
            $table->string('note')->nullable();
            $table->decimal('shipping_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('actual_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
