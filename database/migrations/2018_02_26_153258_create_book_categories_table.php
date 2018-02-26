<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 图书分类表
     */
    public function up()
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('')->comment('分类名称');
            $table->tinyInteger('weight')->default(1)->comment('权重,用于排序');
            $table->tinyInteger('status')->default(1)->comment('状态 1：有效 0：无效');
            $table->unique('id', 'idx_name');
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
        Schema::dropIfExists('book_categories');
    }
}
