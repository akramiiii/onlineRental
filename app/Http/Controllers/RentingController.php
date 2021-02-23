<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Pledge;
use App\Address;
use App\Delivery;
use App\Province;
use App\OrderData;
use App\OrderInfo;
use App\Lib\ZarinPal;
use App\OrderingTime;
use App\Lib\Mellat_Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RentingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function renting(Request $request){
        if(Cart::get_product_count() > 0){
            $user_id = $request->user()->id;
            $pledges = Pledge::get();
            $delivery = Delivery::get();
            $address = Address::with(['getProvince' , 'getCity'])->where('user_id' , $user_id)->orderBy('id' , 'DESC')->get();

            // $orderingTime = new OrderingTime(3);
            // return $orderingTime->getGlobalSendData();
            
            return view('renting.set_data' , compact('address' , 'pledges' , 'delivery'));
        }
        
        else{
            return redirect('/');
        }
    }

    public function payment(Request $request){
        if(Cart::get_product_count() > 0){
            $pledge = $request->input('pledges');
            Session::put('order_pledge' , $pledge);
            $delivery_time = $request->input('delivery');
            Session::put('order_delivery_time', $delivery_time);
            $delivery_date = $request->get('date');
            Session::put('order_delivery_date', $delivery_date);
            $user_id = $request->user()->id;
            $address_id = $request->get('address_id');
            $address = Address::where(['user_id' => $user_id , 'id' => $address_id])->first();
            if($address){
                Session::put('order_address_id' , $address_id);
                $OrderingTime = new OrderingTime($address->city_id);
                $send_order_data = $OrderingTime->getGlobalSendData();
                return view('renting.payment' , compact('send_order_data' , 'delivery_date' , 'pledge' , 'delivery_time'));
            }
            else{
                return redirect('/renting');
            }
        }
        else{
            return redirect('/');
        }
    }

    public function order_payment(Request $request){
        $address_id = Session::get('order_address_id');
        $user_id = $request->user()->id;
        if($address_id){
            $address = Address::where(['user_id' => $user_id , 'id' => $address_id])->first();
            if($address){
                $OrderingTime = new OrderingTime($address->city_id);
                $send_order_data = $OrderingTime->getGlobalSendData();
                $order = new Order($send_order_data);
                $result = $order->add_order($send_order_data);
                if($result['status'] == 'ok'){
                    return Order::Gateway($result);
                }
                else{
                    return redirect()->back();
                }
                // echo 'ok';
            }
            else{
                return redirect('/renting');
            }
        }
        else{
            return redirect('/renting');
        }
    }

    public function verify3(Request $request){
        $RefId=$request->get('RefId');
        $ResCode=$request->get('ResCode');
        $SaleOrderId=$request->get('SaleOrderId');
        $SaleReferenceId=$request->get('SaleReferenceId');
        if($ResCode==0 && $request->has('ResCode'))
        {
            $order=Order::with(['getProductRow.getProduct','getOrderInfo','getAddress','getGiftCart','getUserInfo'])->where(['pay_code1'=>$RefId])->firstOrFail();
            require  '../app/Lib/nusoap.php';
            $mellat_bank=new Mellat_Bank();
            if($mellat_bank->Verify($SaleOrderId,$SaleReferenceId)){
                Cart::empty_cart();
                return Order::changeOrderStatus($order,$SaleReferenceId);
            }
            else{
                Cart::empty_cart();
                $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
                $order_data=$order_data->getData();
                return view('renting.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد ']);
            }
        }
        elseif($request->has('Authority')){
            $Authority=$request->get('Authority');
            $order=Order::with(['getProductRow.getProduct','getOrderInfo','getAddress','getGiftCart','getUserInfo'])
                ->where(['pay_code1'=>$Authority])->firstOrFail();
            $zarinpal=new ZarinPal();
            $refId=$zarinpal->verify($order->price,$Authority);
            Cart::empty_cart();
            if($refId){
                return Order::changeOrderStatus($order,$refId);
            }
            else{
                $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
                $order_data=$order_data->getData();
                return view('renting.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد ']);
            }
        }
        else{
            return  redirect('/');
        }
    }

    public function verify()
    {
        $order_id=116;
        // echo $order_id;
        $order=Order::with(['getProductRow','getOrderInfo','getAddress'])->where(['id'=>$order_id])->firstOrFail();
        // dd($order->pay_status);
        // $order_info=OrderInfo::where(['id'=>$order_id])->firstOrFail();

        $order->pay_status='ok';
        $order->update();

        DB::table('order_info')->where('order_id', $order_id)->update(['send_status'=>1]);
        DB::table('order_products')->where('order_id', $order_id)->update(['send_status'=>1]);
        Session::forget('cart');
        $order_info=OrderInfo::where(['order_id'=>$order_id])->firstOrFail();
        // dd($order_info);
        Cart::empty_cart();

        $order_data=new OrderData($order->getOrderInfo, $order->getProductRow);
        $order_data=$order_data->getData();


        return view('renting.verify', compact('order', 'order_info', 'order_data'));

        // $order_id=71;
        // DB::beginTransaction();
        // try{
        //     $order=Order::with(['getProductRow','getOrderInfo','getAddress'])->where(['id'=>$order_id])->firstOrFail();
        //     $order_info=OrderInfo::where(['id'=>$order_id])->firstOrFail();

        //     $order->pay_status='ok';
        //     $order->update();

        //     $order_data=new OrderData($order->getOrderInfo,$order->getProductRow);
        //     $order_data=$order_data->getData();

        //     DB::table('order_info')->where('order_id',$order_id)->update(['send_status'=>1]);
        //     DB::table('order_products')->where('order_id',$order_id)->update(['send_status'=>1]);

        //     DB::commit();
        //     return view('renting.verify',compact('order','order_info','order_data'));

        // }
        // catch (\Exception $exception){
        //     // return view('renting.verify',['order'=>$order,'error_payment'=>'خطا در ثبت اطلاهات،لطفا برای بررسی خطا پیش آمده با پشتیبانی فروشگاه در ارتباط باشید']);
        // }



    }

    public function getSendData($city_id)
    {
        $OrderingTime=new OrderingTime($city_id);
        return $OrderingTime->getGlobalSendData();
    }
}
