<?php
namespace App\Http\ViewComposers;

use App\Services\CategoryService;
use Illuminate\View\View;

class CategoryTreeComposer
{

    protected $categoryService;

    //使用依赖注入,自动注入CategoryService类
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    //渲染指定的模板时,Laravel会调用compose 方法
    public function compose(View $view)
    {
        //使用with方法注入变量
        $view->with('categoryTree', $this->categoryService->getCategoryTree());
    }
}
