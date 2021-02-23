<?php

namespace App\Http\Controllers\Admin;

use App\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class ProvinceController extends CustomController
{
    protected $model = 'Province';
    protected $title = 'استان';
    protected $route_params = 'province';

    public function index(Request $request){
        $province = Province::getData($request->all());
        $trash_province_count = Province::onlyTrashed()->count();
        return view('province.index', compact('province', 'trash_province_count', 'request'));
    }

    public function create(){
        return view('province.create');
    }

    public function store(Request $request){
        $this->validate($request , ['name' => 'required'] , [] , ['name' => 'نام استان']);
        $province = new Province($request->all());
        $province->saveOrFail();
        return redirect('admin/province')->with('message' , 'ثبت نام استان با موفقیت انجام شد');
    }

    public function edit($id){
        $province = Province::findOrFail($id);
        return view('province.edit' , compact('province'));
    }

    public function update($id , Request $request){
        $province = Province::findOrFail($id);
        $this->validate($request, ['name' => 'required'], [], ['name' => 'نام استان']);
        $province->update($request->all());
        return redirect('admin/province')->with('message', 'ویرایش نام استان با موفقیت انجام شد');
    }
}
