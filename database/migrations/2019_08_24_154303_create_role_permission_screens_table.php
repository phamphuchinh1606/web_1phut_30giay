<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission_screens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->string('screen_id',50);
            $table->integer('permission_id');
            $table->integer('assign_code')->default(1);// 0 : All , 1 : Only assign branch , 2 : only assign user
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
        Schema::dropIfExists('role_permission_screens');
    }
}
