<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthMemberBindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_member_bind', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('会员id');
            $table->string('client_type', 20)->default('')->comment('客户端来源 qq,wechat,weibo等');
            $table->tinyInteger('type')->default(0)->comment('类型 1：微信');
            $table->string('openid', 80)->default('')->comment('第三方id');
            $table->string('unionid', 100)->default('');
            $table->text('extra')->comment('额外字段');
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
        Schema::dropIfExists('oauth_member_bind');
    }
}
