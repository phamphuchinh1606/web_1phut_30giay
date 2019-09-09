<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id');
            $table->decimal('rent_amount',12,2)->nullable();
            $table->decimal('percent_shipping',12,2)->nullable();
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
        Schema::dropIfExists('setting_apps');
    }
}
