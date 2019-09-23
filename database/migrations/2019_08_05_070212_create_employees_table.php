<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('identity_card')->nullable();
            $table->double('price_first_hour')->nullable();
            $table->double('price_last_hour')->nullable();
            $table->integer('employee_sale_card_small')->default(0);
            $table->string('employee_login_id')->nullable();
            $table->integer('default_branch_id')->nullable();
            $table->string('password')->nullable();
            $table->integer('delete_flg')->default(0);
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
