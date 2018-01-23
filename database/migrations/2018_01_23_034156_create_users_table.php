<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('uid')->default(null)->comment('管理员ID');
            $table->string('nickname', 100)->comment('用户名');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('email', 100)->comment('邮箱');
            $table->tinyInteger('sex')->default(0)->comment('性别 1男 2女');
            $table->string('avatar', 64)->comment('头像key');
            $table->string('login_name', 20)->unique()->comment('登录用户名');
            $table->string('login_pwd', 32)->comment('登录密码');
            $table->string('login_salt', 32)->comment('加密随机密钥');
            $table->tinyInteger('status')->default(1)->comment('1有效 0无效');
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
        Schema::dropIfExists('user');
    }
}
