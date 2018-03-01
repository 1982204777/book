<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberFavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 会员收藏表
     */
    public function up()
    {
        Schema::create('member_fav', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->default(0)->comment('会员id');
            $table->integer('book_id')->default(0)->comment('图书');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_fav');
    }
}
