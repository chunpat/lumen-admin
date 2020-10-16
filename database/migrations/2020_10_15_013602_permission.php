<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Permission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->string('title',30);
            $table->string('type',10)->default('view')->comment('view:界面；api:接口');
            $table->string('icon',30)->nullable()->default(null);
            $table->string('path',100)->nullable()->default(null);
            $table->string('paths',30)->nullable()->default(null);
            $table->string('component',30)->nullable()->default(null);
            $table->boolean('is_redirect')->default(true);
            $table->boolean('is_always_show')->default(true);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_no_cache')->default(true);
            $table->boolean('is_affix')->default(false);
            $table->integer('parent_id')->default(0);
            $table->tinyInteger('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission');
    }
}
