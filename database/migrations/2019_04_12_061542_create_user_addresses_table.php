<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('关联User');
            //外键约束关联到users表上,删除的时候才约束(cascade)表示2个都删除
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('province')->comment('省');
            $table->string('city')->comment('城市');
            $table->string('district')->comment('区/县');
            $table->string('address')->comment("街道详细地址");
            $table->unsignedInteger('zip')->comment('无符号4位整数邮编');
            $table->string('contact_name')->comment('联系人姓名');
            $table->string('contact_phone')->comment('联系人电话');
            $table->dateTime('last_used_at')->nullable()->comment('最后登陆时间');
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
        Schema::dropIfExists('user_addresses');
    }
}
