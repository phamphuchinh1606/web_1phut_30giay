<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('menu_id');
            $table->string('menu_name')->nullable();
            $table->string('menu_url')->nullable();
            $table->string('parent_menu_id')->nullable();
            $table->integer('is_show')->default(1);
            $table->integer('menu_type')->default(1);
            $table->integer('sort_num')->nullable();
            $table->timestamps();

            $table->primary('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
