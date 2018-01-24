<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppAccessLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_access_log', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('uid')->default(0)->comment('uid');
            $table->string('referer_url', 255)->default('')->comment('当前访问的refer');
            $table->string('target_url', 255)->default('')->comment('访问的url');
            $table->text('query_params')->comment('get和post参数');
            $table->string('ua', 255)->default('')->comment('user_agent');
            $table->string('ip', 32)->default('')->comment('ip地址');
            $table->string('note', 1000)->default('')->comment('json格式备注字段');
            $table->index('uid');
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
        Schema::dropIfExists('app_access_log');
    }
}
