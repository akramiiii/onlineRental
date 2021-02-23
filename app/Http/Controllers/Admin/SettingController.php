<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    public function send_order_price(SettingRequest $request){
        $setting = new Setting();
        if($request->isMethod('post')){
            $data=$setting->set_data($request->all());
        }
        else{
            $data = $setting->get_data(['send_time' , 'send_price' , 'min_order_price']);
        }
        return view('setting.send_order_price' , compact('data'));
    }

    public function payment_gateway(Request $request){
        $setting = new Setting();
        if ($request->isMethod('post')) {
            $data=$setting->set_data($request->all());
        } else {
            $data = $setting->get_data(['TerminalId' , 'Username' , 'Password' , 'MerchantID' , 'gateway']);
        }
        return view('setting.payment_gateway', compact('data'));

    }
}
