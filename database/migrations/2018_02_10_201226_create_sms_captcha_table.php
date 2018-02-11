<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCaptchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_captcha', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 20)->default('');
            $table->string('captcha', 10)->default('');
            $table->string('ip', 20)->default('');
            $table->dateTime('expires_at');
            $table->tinyInteger('status');
            $table->dateTime('created_at');
            $table->index('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_captcha');
    }
}
