<?php

namespace App\Http\Controllers\Admin;

use App\city;
use App\Province;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class CityController extends CustomController
{
    protected $model = 'city';
    protected $title = 'استان';
    protected $route_params = 'city';

    public function index(Request $request){
        $city = City::getData($request->all());
        $trash_city_count = City::onlyTrashed()->count();
        return view('city.index', compact('city', 'trash_city_count', 'request'));
    }

    public function create(){
        $province = Province::get()->pluck('name' , 'id')->toArray();
        return view('city.create' , compact('province'));
    }

    public function store(CityRequest $request){
        $city = new City($request->all());
        $city->saveOrFail();
        return redirect('admin/city')->with('message' , 'ثبت شهر با موفقیت انجام شد');
    }

    public function edit($id){
        $province = Province::get()->pluck('name', 'id')->toArray();
        $city = city::findOrFail($id);
        return view('city.edit' , compact('city' , 'province'));
    }

    public function update($id , CityRequest $request){
        $city = City::findOrFail($id);
        $city->update($request->all());
        return redirect('admin/city')->with('message', 'ویرایش شهر با موفقیت انجام شد');
    }
}
