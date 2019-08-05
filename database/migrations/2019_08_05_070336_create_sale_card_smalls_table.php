<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleCardSmallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_card_smalls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('sale_date');
            $table->integer('employee_id');
            $table->double('qty')->nullable();
            $table->double('bonus_amount')->nullable();
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
        Schema::dropIfExists('sale_card_smalls');
    }
}
