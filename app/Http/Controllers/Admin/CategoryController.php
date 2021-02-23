<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Admin\CustomController;

class CategoryController extends CustomController
{
    protected $model = 'Category';
    protected $title = 'دسته';
    protected $route_params = 'category';

    public function index(Request $request)
    {
        // $category = Category::with('getParent')->orderBy("id" , "DESC")->paginate(10);
        $category = Category::getData($request->all());
        $trash_cat_count = Category::onlyTrashed()->count();
        return view('category.index' , compact('category' , 'trash_cat_count' , 'request'));
    }

    public function create()
    {
        $parent_cat = Category::get_parent();
        return view('category.create' , compact('parent_cat'));
    }

    public function store(CategoryRequest $request)
    {
        $notShow = $request->has('notShow') ? 1 : 0;
        $category = new Category($request->all());
        $category->notShow = $notShow;
        $category->url=get_url($request->get('ename'));
        $img_url = upload_file($request, 'pic' , 'uploads');
        $category->img = $img_url;
        $category->save();
        cache()->forget('catList');

        return redirect("admin/category")->with('message' , 'ثبت دسته با موفقیت انجام شد');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parent_cat = Category::get_parent();
        return view('category.edit' , compact('category' , 'parent_cat'));
    }

    public function update(CategoryRequest $request, $id)
    {
        cache()->forget('catList');
        $data=$request->all();
        $category = Category::findOrFail($id);
        $notShow = $request->has('notShow') ? 1 : 0;
        $category->url=get_url($request->get('ename'));
        $img_url = upload_file($request, 'pic' , 'uploads');
        if($img_url != null){
            $category->img = $img_url;
        }
        $data['notShow'] = $notShow;
        $category->update($data);
        return redirect("admin/category")->with('message' , 'ویرایش دسته با موفقیت انجام شد');
    }
}
