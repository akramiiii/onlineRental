<?php

namespace App\Http\Controllers\Admin;

use App\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class DeliveryController extends CustomController
{
    protected $model = 'Delivery';
    protected $title = 'ساعت تحویل';
    protected $route_params = 'delivery';

    public function index(Request $request){
        $delivery = Delivery::getData($request->all());
        $trash_delivery_count = Delivery::onlyTrashed()->count();
        return view('delivery.index', compact('delivery', 'trash_delivery_count', 'request'));
    }

    public function create(){
        return view('delivery.create');
    }

    public function store(Request $request){
        $this->validate($request , ['delivery' => 'required'] , [] , ['delivery' => 'ساعت تحویل']);
        $delivery = new Delivery($request->all());
        $delivery->saveOrFail();
        return redirect('admin/delivery')->with('message' , 'ثبت ساعت تحویل با موفقیت انجام شد');
    }

    public function edit($id){
        $delivery = Delivery::findOrFail($id);
        return view('delivery.edit' , compact('delivery'));
    }

    public function update($id , Request $request){
        $delivery = Delivery::findOrFail($id);
        $this->validate($request, ['delivery' => 'required'], [], ['name' => 'ساعت تحویل']);
        $delivery->update($request->all());
        return redirect('admin/delivery')->with('message', 'ویرایش ساعت تحویل با موفقیت انجام شد');
    }
}
