<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallLocationOfDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('small_car_location_of_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('small_car_location_id');
            $table->integer('type_day')->default(1);
            $table->integer('week_no')->nullable();
            $table->date('date_off')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('small_location_of_days');
    }
}
