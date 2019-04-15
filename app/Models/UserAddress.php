<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    // 允许写入的字段名
    protected $fillable=[
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    // 允许直接跟carbon类方法 如$this->last_used_at->getTimestamp();
    protected $dates=['last_used_at'];
    /**
     * 关联user 表,一对一关联
     *
     * @return void
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
    /**
     * 地址访问器
     *  fullAddress方法返回拼接后的地址
     * @return void
     */
    public function getFullAddressAttribute(){
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
    
}
