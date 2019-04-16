<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->comment('关联订单ID,级联删除');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedInteger('product_id')->commend('关联商品id,级联删除');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('product_sku_id')->comment('关联skuID,外键,级联删除');
            $table->foreign('product_sku_id')->references('id')->on('product_skus')->onDelte('cascade');
            $table->unsignedInteger('amount')->coment('数量');
            $table->decimal('price',10,2)->comment('价格');
            $table->unsignedInteger('rating')->nullable()->comment('用户评分');
            $table->text('review')->nullable()->comment('用户评价');
            $table->timestamp('reviewed_at')->nullable()->comment('用户打分时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
