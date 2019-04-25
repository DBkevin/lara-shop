<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrowdfundingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfunding_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('关联商品表外键,级联删除');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('target_amount',10,2)->comment('目标金额');
            $table->decimal("total_amount",10,2)->default(0)->comment('当前金额');
            $table->unsignedInteger('user_count')->default(0)->comment('参数人数');
            $table->dateTime('end_at')->comment('结束时间');
            $table->string('status')->default(\App\Models\CrowdfundingProduct::STATUS_FUNDING)->comment("当前状态,默认值为筹款中");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfunding_products');
    }
}
