<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 购物车表
     */
    public function up()
    {
        Schema::create('member_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->default(0)->comment('会员id');
            $table->integer('book_id')->default(0)->comment('图书id');
            $table->integer('quantity')->default(0)->comment('数量');
            $table->index('member_id', 'idx_member_id');
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
        Schema::dropIfExists('member_cart');
    }
}
