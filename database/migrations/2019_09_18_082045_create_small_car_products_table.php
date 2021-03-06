<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallCarProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('small_car_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('small_car_location_id');
            $table->integer('product_id')->nullable();
            $table->decimal('qty_no_vegetables');
            $table->decimal('qty_have_vegetables');
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
        Schema::dropIfExists('small_car_products');
    }
}
