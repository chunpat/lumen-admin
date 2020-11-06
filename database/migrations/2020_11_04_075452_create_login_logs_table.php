<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_log', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->comment('登录名');
            $table->string('ip',20)->comment('登录ip地址');
            $table->string('location',50)->comment('登录地点');
            $table->string('browser',50)->comment('浏览器');
            $table->string('platform',50)->comment('操作系统');
            $table->tinyInteger('status')->comment('登录状态：0失败1成功');
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
        Schema::dropIfExists('login_log');
    }
}
