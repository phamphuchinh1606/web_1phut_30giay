<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_check_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id');
            $table->date('check_in_date');
            $table->integer('order_check_in_type');
            $table->integer('material_id')->nullable();
            $table->string('note')->nullable();
            $table->double('qty');
            $table->double('price');
            $table->double('amount');
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
        Schema::dropIfExists('order_check_ins');
    }
}
