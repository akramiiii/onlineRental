<?php

namespace App;

use App\Lib\Jdf;
use App\Lib\ZarinPal;
use App\AdditionalInfo;
use App\Lib\Mellat_Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable=[
        'user_id','order_id','address_id','order_read','date','price','total_price','pay_status','pay_code1','pay_code2'
    ];
    public function add_order($order_data)
    {
        $user_id=Auth::user()->id;
        $order_address_id = Session::get('order_address_id');
        $time=time();
        $order_code=substr($time, 1, 5).$user_id.substr($time, 5, 10);
        // echo $order_code;
        $jdf=new Jdf();

        $this->user_id=$user_id;
        $this->address_id=$order_address_id;
        $this->order_read='no';
        $this->pay_status='awaiting_payemnt';
        $this->order_id=$order_code;
        $this->date=$jdf->tr_num($jdf->jdate('Y-n-j'));
        $final_price=Session::get('final_price', 0);
        $final_price=$final_price+$order_data['integer_normal_send_order_amount'];
        $price = $order_data['integer_normal_cart_price'];
        settype($price, 'integer');
        $this->price=$price;
        $this->total_price=$final_price;

        DB::beginTransaction();
        try {
            $this->save();
            $this->add_order_row($order_data);
            DB::commit();
            return [
                'status'=>'ok',
                'order_id'=>$this->id,
                'price'=>$this->price
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status'=>'error',
            ];
        }
    }

    public function add_order_row($order_data)
    {
        $time=time();
        if (array_key_exists('cart_product_data', $order_data)) {
            foreach ($order_data['cart_product_data'] as $key=>$value) {
                DB::table('order_products')->insert([
                    'order_id'=> $this->id,
                    'product_id'=>$value['product_id'],
                    'product_price1'=>$value['price1'],
                    'product_price2'=>$value['price2'],
                    'product_count'=>$value['product_count'],
                    'product_roz'=>$value['product_roz2'],
                    'product_offers'=>$value['product_offers'],
                    'time'=>$time,
                ]);
            }
            $this->add_order_info($order_data);
        }
    }

    public function add_order_info($order_data)
    {
        $jdf=new Jdf();
        $h=$jdf->tr_num($jdf->jdate('H'));
        $h=(24-$h);

        // $send_order_day_number=$order_data['normal_send_day'];
        // settype($send_order_day_number,'integer');
        // $time=$send_order_day_number*24*60*60;
        // $order_send_time=time()+$time+($h*60*60);

        $order_info=new OrderInfo();
        $order_info->order_id=$this->id;
        $order_info->delivery_day=$order_data['delivery_day'];
        $order_info->delivery_time=$order_data['delivery_time'];
        $order_info->guarantee=$order_data['guarantee'];
        $order_info->send_order_amount=$order_data['integer_normal_send_order_amount'];
        $order_info->send_status=0;
        // $order_info->order_send_time=$order_send_time;
        $order_info->products_id=$this->get_products_id($order_data);
        $order_info->save();
    }

    public function get_products_id($order_data)
    {
        $products_id='';
        $j=0;
        foreach ($order_data['cart_product_data'] as $key=>$value) {
            $products_id=$products_id.$value['product_id'];
            if ($j!=(sizeof($order_data['cart_product_data'])-1)) {
                $products_id.='-';
            }
            $j++;
        }
        return $products_id;
    }

    public function getProductRow()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id')->with(['getProduct']);
    }
    public function getOrderInfo()
    {
        return $this->hasMany(OrderInfo::class, 'order_id', 'id');
    }
    public function getAddress()
    {
        return $this->hasOne(Address::class, 'id', 'address_id')->with(['getProvince','getCity'])->withDefault(['name'=>''])->withTrashed();
    }
    public static function OrderStatus()
    {
        $array=array();
        $array[-2]='خطا در اتصال به درگاه';
        $array[-1]='لغو شده';
        $array[0]='در انتظار پرداخت';
        $array[1]='تایید سفارش';
        $array[2]='آماده سازی سفارش';
        $array[3]='ارسال سفارش';
        $array[4]='تحویل مرسوله به مشتری';
        $array[5]='برگشت مرسوله توسط مشتری';
        return $array;
    }
    public static function getOrderStatus($status, $OrderStatus)
    {
        return $OrderStatus[$status];
    }
    public static function getData($request)
    {
        $string='?';
        $orders=self::orderBy('id', 'DESC');
        if (inTrashed($request)) {
            $orders=$orders->onlyTrashed();
            $string=create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('user_id', $request) && !empty($request['user_id'])) {
            $orders=$orders->where('user_id', $request['user_id']);
            $string=create_paginate_url($string, 'user_id='.$request['user_id']);
        }
        if(array_key_exists('order_id',$request) && !empty($request['order_id']))
        {
            $order_id=$request['order_id'];
            $orders=$orders->where('order_id',$order_id);
            $string=create_paginate_url($string,'order_id='.$request['order_id']);
        }
        if(array_key_exists('first_date',$request) && !empty($request['first_date']))
        {
            $first_date=getTimestamp($request['first_date'],'first');
            $orders=$orders->where('created_at','>=',$first_date);
            $string=create_paginate_url($string,'first_date='.$request['first_date']);
        }
        if(array_key_exists('end_date',$request) && !empty($request['end_date']))
        {
            $end_date=getTimestamp($request['end_date'],'end');
            $orders=$orders->where('created_at','<=',$end_date);
            $string=create_paginate_url($string,'end_date='.$request['end_date']);
        }
        $orders=$orders->paginate(10);
        $orders->withPath($string);
        return $orders;
    }
    public function getCreatedAtAttribute($value)
    {
        return strtotime($value);
    }
    public function getUserInfo()
    {
       return $this->hasOne(AdditionalInfo::class,'user_id','user_id')->withDefault(['email'=>'']);
    }
    public static function Gateway($data,$url=null)
    {
        // require  '../app/Lib/nusoap.php';
        // $mellat_bank=new Mellat_Bank();
        // $refId=$mellat_bank->pay($data['price'], $data['order_id'], $url);
        // if($refId){
        //     DB::table('orders')->where('id',$data['order_id'])->update(['pay_code1'=>$refId]);
        //     return view('renting.location',['res'=>$refId]);
        // }
        // else{
        //     DB::table('orders')->where('id',$data['order_id'])->update(['pay_status'=>'error_connect']);
        //     return view('renting.location');
        // }

        $gateway=Setting::get_value('gateway');
        // if($gateway==2){
        //     $zarinpal=new ZarinPal();
        //     $code=$zarinpal->pay($data['price'],$url);
        //     if($code){
        //         DB::table('orders')->where('id',$data['order_id'])->update(['pay_code1'=>$code]);
        //         Header('Location: https://www.zarinpal.com/pg/StartPay/'.$code);
        //     }
        //     else{
        //         DB::table('orders')->where('id',$data['order_id'])->update(['pay_status'=>'error_connect']);
        //         return view('renting.location');
        //     }
        // }
        // else if($gateway==1){
            require  '../app/Lib/nusoap.php';
            $mellat_bank=new Mellat_Bank();
            $refId=$mellat_bank->pay($data['price'],$data['order_id'],$url);
            if($refId){
                DB::table('orders')->where('id',$data['order_id'])->update(['pay_code1'=>$refId]);
                return view('renting.location',['res'=>$refId]);
            }
            else{
                DB::table('orders')->where('id',$data['order_id'])->update(['pay_status'=>'error_connect']);
                return view('renting.location');
            }
        // }
        // else{
        //     return view('renting.location');
        // }
    }

    public static function changeOrderStatus($order,$SaleReferenceId,$forWeb=true){
        DB::beginTransaction();
        try{
            $order->pay_status='ok';
            $order->pay_code2=$SaleReferenceId;
            $order->update();

            $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
            $order_data=$order_data->getData();

            DB::table('order_infos')->where('order_id',$order->id)->update(['send_status'=>1]);
            DB::table('order_products')->where('order_id',$order->id)->update(['send_status'=>1]);

            DB::commit();
            // OrderStatistics::dispatch($order);

            // set_sale($order);
            // if(!empty($order->getUserInfo->email))
            // {
            //     Mail::to($order->getUserInfo->email)->queue(new \App\Mail\Order($order,$order_data));
            // }

            // if($forWeb){
            //     return view('renting.verify',['order'=>$order,'order_data'=>$order_data]);
            // }
            // else{
            //     return view('app.verify',['order'=>$order]);
            // }

        }
        catch (\Exception $exception){
           if($forWeb){
               return view('renting.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'خطا در ثبت اطلاهات،لطفا برای بررسی خطا پیش آمده با پشتیبانی فروشگاه در ارتباط باشید']);
           }
           else{
               return view('app.verify',['error_payment'=>'خطا در ثبت اطلاهات،لطفا برای بررسی خطا پیش آمده با پشتیبانی فروشگاه در ارتباط باشید']);
           }
        }
    }

}
