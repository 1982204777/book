<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname', 100)->comment('会员名');
            $table->string('mobile', 20)->unique()->comment('会员手机号');
            $table->tinyInteger('sex')->default(0)->comment('性别 1男 2女');
            $table->string('avatar', 64)->comment('头像key');
            $table->string('salt', 32)->comment('加密随机密钥');
            $table->string('reg_ip', 100)->comment('登录IP');
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
        Schema::dropIfExists('members');
    }
}
