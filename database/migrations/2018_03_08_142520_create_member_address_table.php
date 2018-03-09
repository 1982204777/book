<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 收货地址表
     */
    public function up()
    {
        Schema::create('member_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->default(0)->comment('会员id');
            $table->string('nickname', 20)->default('')->comment('收货人姓名');
            $table->string('mobile', 11)->default('')->comment('收货人电话号码');
            $table->integer('province_id')->default(0)->comment('收货人省id');
            $table->integer('city_id')->default(0)->comment('城市id');
            $table->integer('area_id')->default(0)->comment('区域id');
            $table->string('address', 100)->default('')->comment('详细地址');
            $table->tinyInteger('is_default')->default(1)->comment('是否是默认地址, 1：是 0：不是');
            $table->tinyInteger('status')->default(1)->comment('是否有效，1：是 0：不是');
            $table->index('member_id', 'idx_member_id');
            $table->index('status', 'idx_status');
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
        Schema::dropIfExists('member_address');
    }
}
