<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTimeKeepingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_time_keepings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('month_date',10)->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->double('total_first_hour')->nullable()->default(0);
            $table->double('total_last_hour')->nullable()->default(0);
            $table->double('total_first_amount')->nullable()->default(0);
            $table->double('total_last_amount')->nullable()->default(0);
            $table->double('total_amount')->nullable()->default(0);
            $table->double('diligence_amount')->nullable()->default(0);
            $table->double('allowance_amount')->nullable()->default(0);
            $table->double('bonus_amount')->nullable()->default(0);
            $table->double('extra_allowance_amount')->nullable()->default(0);
            $table->double('salary_amount')->nullable()->default(0);
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
        Schema::dropIfExists('employee_time_keepings');
    }
}
