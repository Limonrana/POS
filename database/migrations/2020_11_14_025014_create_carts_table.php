<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('qty')->nullable();
            $table->string('price')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('freight_cost')->nullable();
            $table->string('subtotal')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
