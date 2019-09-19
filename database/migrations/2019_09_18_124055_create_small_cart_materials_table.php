<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallCartMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('small_cart_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('small_car_location_id');
            $table->integer('material_id');
            $table->string('material_name')->nullable();
            $table->decimal('qty')->nullable();
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
        Schema::dropIfExists('small_cart_materials');
    }
}
