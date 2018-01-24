<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('品牌名称');
            $table->string('description', 2000)->comment('品牌描述');
            $table->string('address', 200)->comment('公司地址');
            $table->string('mobile', 11)->comment('联系电话');
            $table->string('logo', 200)->comment('logo图片');
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
        Schema::dropIfExists('brand_setting');
    }
}
