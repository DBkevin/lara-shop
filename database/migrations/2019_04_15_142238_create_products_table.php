<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->comment("商品ID");
            $table->string('title')->comment('商品标题');
            $table->text('description')->comment("商品描述");
            $table->string('image')->comment('商品封面图');
            $table->boolean('on_sale')->default(true)->comment("手否上架,默认上架");
            $table->float('rating')->default(5)->comment('评价,默认五分');
            $table->unsignedInteger('sold_count')->default(0)->comment("销量,默认0");
            $table->unsignedInteger('review_count')->default(0)->comment('评价数量,默认0');
            $table->decimal('price', 10, 2)->comment('SKU最低价格');
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
        Schema::dropIfExists('products');
    }
}
