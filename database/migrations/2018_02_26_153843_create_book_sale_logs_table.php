<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookSaleLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *商品销售情况
     */
    public function up()
    {
        Schema::create('book_sale_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->default(0)->comment('图书id');
            $table->integer('quantity')->default(0)->comment('售卖数量');
            $table->decimal('price', 10, 2)->default(0.00)->comment('售卖金额');
            $table->integer('member_id')->default(0)->comment('会员id');
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
        Schema::dropIfExists('book_sale_logs');
    }
}
