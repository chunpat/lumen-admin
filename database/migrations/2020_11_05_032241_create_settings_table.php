<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('用户id')->default(0);
            $table->string('key',30)->comment('关键字名')->unique();
            $table->string('title',30)->comment('关键字标题');
            $table->string('type',20)->comment('类型');
            $table->string('value',255)->comment('值');
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
        Schema::dropIfExists('setting');
    }
}
