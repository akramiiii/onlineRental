<?php

namespace App\Http\Controllers\Admin;

use App\Pledge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class PledgeController extends CustomController
{
    protected $model = 'Pledge';
    protected $title = 'ضمانت';
    protected $route_params = 'pledge';

    public function index(Request $request){
        $pledge = Pledge::getData($request->all());
        $trash_pledge_count = Pledge::onlyTrashed()->count();
        return view('pledge.index', compact('pledge', 'trash_pledge_count', 'request'));
    }

    public function create(){
        return view('pledge.create');
    }

    public function store(Request $request){
        $this->validate($request , ['pledge' => 'required'] , [] , ['pledge' => 'نام ضمانت']);
        $pledge = new Pledge($request->all());
        $pledge->saveOrFail();
        return redirect('admin/pledge')->with('message' , 'ثبت ضمانت با موفقیت انجام شد');
    }

    public function edit($id){
        $pledge = Pledge::findOrFail($id);
        return view('pledge.edit' , compact('pledge'));
    }

    public function update($id , Request $request){
        $pledge = Pledge::findOrFail($id);
        $this->validate($request, ['pledge' => 'required'], [], ['name' => 'نام ضمانت']);
        $pledge->update($request->all());
        return redirect('admin/pledge')->with('message', 'ویرایش نام ضمانت با موفقیت انجام شد');
    }
}
