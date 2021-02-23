<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderData;
use App\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class OrdersController extends CustomController
{
    protected  $model='Order';
    protected  $title='سفارشات';
    protected $route_params='orders';

    public function index(Request $request)
    {
        $orders=Order::getData($request->all());
        $trash_orders_count=Order::onlyTrashed()->count();
        return view('orders.index',['orders'=>$orders,'trash_orders_count'=>$trash_orders_count,'req'=>$request
        ]);
    }
    public function show($order_id)
    {
        $order=Order::with(['getProductRow','getOrderInfo','getAddress'])->where(['id'=>$order_id])->firstOrFail();
        $order_info = OrderInfo::where(['order_id'=>$order_id])->firstOrFail();

        if( $order->order_read=='no'){
            $order->order_read='ok';
            $order->update();
        }
        $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id);
        $order_data=$order_data->getData();
        return view('orders.show',['order'=>$order,'order_data'=>$order_data , 'order_info'=>$order_info]);
    }
    public function change_status(Request $request)
    {
        $order_id=$request->get('order_id');
        $status=$request->get('status');
        $orderInfo=OrderInfo::where('id',$order_id)->first();
        if($orderInfo){
            DB::beginTransaction();
            $orderInfo->send_status=$status;
            try{
                $orderInfo->update();
                set_order_product_status($orderInfo,$status);
                DB::commit();
                return 'ok';
            }
            catch (\Exception $exception){
                DB::rollBack();
                return 'error';
            }
        }
        else{
            return 'error';
        }
    }
    public function submission(Request $request)
    {
        // dd('hi');
        $submission=OrderInfo::getData($request->all(),0,'DESC');
        return view('orders.submission',[
            'label'=>'مدیریت مرسوله ها',
            'label_url'=>'submission',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function submission_info($id){
        $submission_info=OrderInfo::with('getOrder.getAddress')->has('getOrder')->where('id',$id)->firstOrFail();
        $order_data=new OrderData($submission_info->getOrder->getOrderInfo,$submission_info->getOrder->getProductRow,$submission_info->getOrder->user_id);
        $order_data=$order_data->getData($id);
        return view('orders.submission_info',['submission_info'=>$submission_info,'order_data'=>$order_data]);
    }
    public function submission_approved(Request $request){
        $submission=OrderInfo::getData($request->all(),1);
        return view('orders.submission',[
            'label'=>'مرسوله های تایید شده' ,
            'label_url'=>'submission/approved',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function submission_ready(Request $request){
        $submission=OrderInfo::getData($request->all(),2);
        return view('orders.submission',[
            'label'=>'مرسوله های آماده ارسال' ,
            'label_url'=>'submission/ready',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function posting_send(Request $request){
        $submission=OrderInfo::getData($request->all(),3);
        return view('orders.submission',[
            'label'=>'مرسوله های ارسال شده' ,
            'label_url'=>'posting/send',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function delivered_renting(Request $request){
        $submission=OrderInfo::getData($request->all(),4);
        return view('orders.submission',[
            'label'=>'مرسوله های تحویل داده شده' ,
            'label_url'=>'delivered/renting',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function returned_renting(Request $request){
        $submission=OrderInfo::getData($request->all(),5);
        return view('orders.submission',[
            'label'=>'مرسوله های برگشت داده شده' ,
            'label_url'=>'returned/renting',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
}
