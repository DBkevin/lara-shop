<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    //允许写入的字段
    protected $fillable = ['title', 'description', 'price', 'stock'];
    /**
     * 关联product表
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
