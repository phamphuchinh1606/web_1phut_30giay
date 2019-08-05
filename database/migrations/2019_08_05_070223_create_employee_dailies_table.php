<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_dailies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_daily');
            $table->integer('employee_id');
            $table->double('first_hours')->nullable();
            $table->double('last_hours')->nullable();
            $table->double('price_first_hour')->nullable();
            $table->double('price_last_hour')->nullable();
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
        Schema::dropIfExists('employee_dailies');
    }
}
