<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->unique()->comment("分期流水号");
            $table->unsignedInteger('user_id')->comment("用户ID,级联删除");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('order_id')->comment('订单ID,级联删除');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->decimal('total_amount')->comment("总金额");
            $table->unsignedInteger('count')->comment("期数");
            $table->float('fee_rate')->comment('手续费率');
            $table->float('fine_rate')->comment('预期费率');
            $table->string('status')->default(\App\Models\Installment::STATUS_PENDING)->comment("还款状态,默认未执行");
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
        Schema::dropIfExists('installments');
    }
}
