<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->string('theme_color',50)->default('#1890FF');
            $table->tinyInteger('open_tags_view')->default(1);
            $table->tinyInteger('fixed_header')->default(0);
            $table->tinyInteger('sidebar_logo')->default(0);
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
        Schema::dropIfExists('user_setting');
    }
}
