<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasedetails', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->string('price')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('subtotal')->nullable();
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
        Schema::dropIfExists('purchasedetails');
    }
}
