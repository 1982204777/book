<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *商品库存变更表
     */

    public function up()
    {
        Schema::create('book_stock_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->default(0)->comment('图书');
            $table->integer('unit')->default(0)->comment('变更数量');
            $table->integer('total_stock')->default(0)->comment('变更之后总量');
            $table->string('note', 100)->default('')->comment('备注字段');
            $table->index('book_id', 'idx_book_id');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_stock_logs');
    }
}
