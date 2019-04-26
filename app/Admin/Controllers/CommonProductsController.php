<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use App\Models\Category;
use Encore\Admin\Grid;
use Encore\Admin\Form;


abstract class CommonProductsController extends Controller
{
    use HasResourceActions;


    //定义一个抽象方法,返回当前管理的商品类型
    abstract public function getProductType();

    public function index(Content $content)
    {
        return $content
            ->header(Product::$typeMap[$this->getProductType()] . '列表')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return  $content
            ->header("编辑" . Product::$typeMap[$this->getProductType()])
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建' . Product::$typeMap[$this->getProductType()])
            ->body($this->form());
    }
    protected function  grid()
    {
        $grid = new Grid(new Product());
        //筛选出当前类型的商品,默认ID倒叙排序
        $grid->model()->where('type', $this->getProductType())->orderBy('id', 'desc');
        //调用自定义方法
        $this->customGrid($grid);
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }
    //定义一个抽象方法,各个类型的控制器将实现本方法来定义列表应该展示那些字段
    abstract protected function  customGrid(Grid $grid);
    protected function form()
    {
        $from = new Form(new Product());
        //在表单页面中添加一个名为type的隐藏字段,值为当前商品类型
        $from->hidden('type')->value($this->getProductType());
        $from->text('title', '商品类型')->rules('required');
        $from->select('category_id', '类目')->options(function ($id) {
            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->full_name];
            }
        })->ajax('/admin/api/categories?is_directory=0');
        $from->image('image', '封面图片')->rules('required|image');
        $from->editor('description', '商品描述')->rules('required');
        $from->radio('on_sale', '上架')->options(['1' => '是', '0' => '否'])->default('0');


        //调用自定义方法
        $this->customForm($from);
        $from->hasMany('skus', '商品SKU', function (Form\NestedForm $from) {
            $from->text('title', 'SKU名称')->rules('required');
            $from->text('description', 'SKU描述')->rules('required');
            $from->text('price', '单价')->rules('required|numeric|min:0.01');
            $from->text('stock', '剩余库存')->rules('required|integer|min:0');
        });
        $from->saving(function (Form $from) {
            $from->model()->price = collect($from->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });
        return $from;
    }

    //定义一个抽象方法,各个类型的控制器将实现本方法来定义表单应该有那些额外的字段
    abstract protected function customForm(Form $from);
}
