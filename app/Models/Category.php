<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = ['name', 'is_directory', 'level', 'path'];
    protected $casts = [
        'is_directory' => 'boolean',
    ];


    protected static function boot()
    {
        parent::boot();
        //监听category的创建事件,用于初始化path和level字段值
        static::creating(function (Category $category) {
            //如果创建的是一个根类目
            if (is_null($category->parent_id)) {
                //将层级设为0
                $category->level = 0;
                //将path设为-
                $category->path = '-';
            } else {
                //将层级设为父类目的层级+1
                $category->level = $category->parent->level + 1;
                //将path值设为父类目的path追加父类目id以及最后跟上一个'-'分隔符
                $category->path = $category->parent->path . $category->parent_id . '-';
            }
        });
    }


    public function parent()
    {
        return $this->belongsTo(Category::class);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }
    //定一个一个访问器,获取所有祖先类目的ID值
    public function getPathIdsAttribute()
    {
        //trim($str,'-')将字符串两端的-符号去除
        //explode()将字符串以-为分割为素组
        //最后array_filter将数组中的空值移除
        return array_filter(explode('-', trim($this->path, '-')));
    }

    //定义一个访问器,获取所有祖先类目并按层级排序
    public function getAncestorsAttribute(){
        return Category::query()
            //使用上面的访问器获取所有类目的id
            ->whereIn('id',$this->path_ids)
            //按层级排序
            ->orderBy('level')
            ->get();
    }
    //定义一个访问器,获取以-为分割的所有祖先类目名称以及当前类目的名称
    public function getFullNameAttribute(){
        return $this->ancestors//获取所有祖先类目
            ->pluck('name')//取出所有主线类目的name字段作为一个数组
            ->push($this->name)//将当前类目的name字段值价到数组的末尾
            ->implode('-'); //用-符号将数组的值装成一个字符串
    }
}
