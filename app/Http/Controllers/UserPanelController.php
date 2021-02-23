<?php

namespace App\Http\Controllers;

use App\City;
use App\Order;
use App\Province;
use App\OrderData;
use App\OrderInfo;
use App\AdditionalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdditionalRequest;

class UserPanelController extends Controller
{
    public function __construct()
    {
        getCatList();
    }
    public function orders(Request $request)
    {
        $user_id=$request->user()->id;
        $orders=Order::where('user_id',$user_id)->orderBy('id','DESC')->paginate();
        return view('userPanel.orders',compact('orders'));
    }
    public function show_order($order_id,Request $request){
        $user_id=$request->user()->id;
        $order=Order::with(['getProductRow','getOrderInfo','getAddress'])->where(['id'=>$order_id,'user_id'=>$user_id])->firstOrFail();
        $order_info = OrderInfo::where(['order_id'=>$order_id])->firstOrFail();

        $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id);
        $order_data=$order_data->getData();
        return view('userPanel.show_order',compact('order' , 'order_data' , 'order_info'));
    }
    public function profile()
    {
        $user=Auth::user()->id;
        $orders=null;
        $additionalInfo=null;
        $additionalInfo=AdditionalInfo::where(['user_id'=>$user])->with(['getProvince','getCity'])->first();
        $orders=Order::where(['user_id'=>$user])->orderBy('id','DESC')->limit(10)->get();
        return view('userPanel.profile',['orders'=>$orders,'additionalInfo'=>$additionalInfo]);
    }
    public function additional_info(){
        $user=Auth::user()->id;
        $additionalInfo=AdditionalInfo::where(['user_id'=>$user])->first();
        return view('userPanel.additional_info',['additionalInfo'=>$additionalInfo]);
    }
    public function save_additional_info(AdditionalRequest $request){
        $user_id=$request->user()->id;
        $user=\App\User::findOrFail($user_id);
        return AdditionalInfo::addUserData($user,$request);
    }
    public function address(){
        
        return view('userPanel.address');
    }
}
