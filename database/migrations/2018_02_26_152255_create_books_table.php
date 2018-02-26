<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 图书表
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default(0)->comment('所属分类id');
            $table->string('name', 100)->default('')->comment('图书名称');
            $table->decimal('price', 10, 2)->default(0.00)->comment('售卖金额');
            $table->string('main_img', 100)->default('')->comment('主图');
            $table->string('summary', 2000)->default('')->comment('描述');
            $table->integer('stock')->default(0)->comment('库存量');
            $table->string('tags', 200)->default('')->comment('tag关键字，以逗号隔开');
            $table->tinyInteger('status')->default(1)->comment('状态 1：有效 0：无效');
            $table->integer('month_count')->default(0)->comment('月销售总量');
            $table->integer('total_count')->default(0)->comment('总销售量');
            $table->integer('view_count')->default(0)->comment('总浏览量');
            $table->integer('comment_count')->default(0)->comment('总评论量');
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
        Schema::dropIfExists('books');
    }
}
