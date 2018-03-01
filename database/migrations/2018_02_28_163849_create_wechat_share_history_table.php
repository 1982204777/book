<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatShareHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 微信分享记录表
     */
    public function up()
    {
        Schema::create('wechat_share_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->default(0)->comment('会员id');
            $table->string('share_url', 200)->default('')->comment('分享页面url');
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
        Schema::dropIfExists('wechat_share_history');
    }
}
