<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('details_id')->nullable();
            $table->string('order_date')->nullable();
            $table->string('discount')->nullable();
            $table->string('paid')->nullable();
            $table->string('due')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('tax')->nullable();
            $table->string('total')->nullable();
            $table->integer('status')->nullable();
            $table->integer('type')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
