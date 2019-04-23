<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsAddCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->unsignedInteger('category_id')->nullable()->after('id')->comment('类目ID,关联类目表,删除所属类目设置为空');
            $table->foreign('category_id')->references('id')->on('categories')->onDelte('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //

            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
