<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->increments('id')->commetn('主键,自增');
            $table->string('name')->comment('优惠券名称');
            $table->string('code')->unique()->comment("优惠券名称,唯一");
            $table->string('type')->comment('类型优惠券类型,固定金额和折扣比');
            $table->decimal('value')->comment('折扣值');
            $table->unsignedInteger('total')->comment('优惠券数量');
            $table->unsignedInteger('used')->default(0)->comment("使用次数");
            $table->decimal('min_amount',10,2)->comment('最低使用比例');
            $table->datetime('not_before')->nullable()->comment('在某个时间按段之前不能使用');
            $table->datetime('not_after')->nullable()->comment('在某个时间段之后不能使用');
            $table->boolean('enabled')->comment('优惠券是否生效');
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
        Schema::dropIfExists('coupon_codes');
    }
}
