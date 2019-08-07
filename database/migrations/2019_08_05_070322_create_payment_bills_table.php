<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id');
            $table->date('bill_date');
            $table->string('note')->nullable();
            $table->double('qty')->nullable();
            $table->double('price')->nullable();
            $table->double('amount')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('payment_bills');
    }
}
