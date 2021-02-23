<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;
use App\Http\Requests\SliderRequest;
use App\Slider;

class SliderController extends CustomController
{
    protected $model = 'Slider';
    protected $title = 'اسلایدر';
    protected $route_params = 'slider';

    public function index(Request $request)
    {
        $slider = Slider::getData($request->all());
        $trash_slider_count = Slider::onlyTrashed()->count();
        return view('slider.index', compact('slider', 'trash_slider_count', 'request'));
    }

    public function create(){
        return view('slider.create');
    }

    public function store(SliderRequest $request){
        $slider = new Slider($request->all());
        $image_url = upload_file($request , 'pic' , 'slider' , 'desktop');
        $slider->image_url = $image_url;
        $slider->saveOrFail();

        return redirect('admin/slider')->with('message' , 'ثبت اسلایدر با موفقیت انجام شد');
    }

    public function edit($id){
        $slider = Slider::findOrFail($id);
        return view('slider.edit' , compact('slider'));
    }

    public function update($id , SliderRequest $request){
        $slider = Slider::findOrFail($id);
        $image_url = upload_file($request , 'pic' , 'slider' , 'desktop');
        if($image_url != null){
            $slider->image_url = $image_url;
        }
        $slider->update($request->all());

        return redirect('admin/slider')->with('message', 'ویرایش اسلایدر با موفقیت انجام شد');
    }
}
