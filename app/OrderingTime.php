<?php

namespace App;

use App\Cart;
use App\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderingTime{
    protected $city_id;
    protected $send_time = 0;
    protected $send_price = 0;
    protected $min_order_price = 0;
    protected $cart_product_data = array();
    protected $cart_price=0;

    public function __construct($city_id)
    {
        $this->city_id = $city_id;
    }

    public function getGlobalSendData(){
        $city = City::find($this->city_id);
        if($city && !empty($city->send_time) && !empty($city->send_price) && !empty($city->min_order_price)){
            $send_time = $city->send_time;
            $send_price = $city->send_price;
            $min_order_price = $city->min_order_price;
            settype($send_time , 'integer');
            settype($send_price , 'integer');
            settype($min_order_price , 'integer');
            $this->send_time = $send_time;
            $this->send_price = $send_price;
            $this->min_order_price = $min_order_price;
            return $this->getCartData();
        }
        else{
            $setting = new Setting();
            $values = $setting->get_data(['send_time' , 'send_price' , 'min_order_price']);
            $send_time = $values['send_time'];
            $send_price = $values['send_price'];
            $min_order_price = $values['min_order_price'];
            settype($send_time, 'integer');
            settype($send_price, 'integer');
            settype($min_order_price, 'integer');
            $this->send_time = $send_time;
            $this->send_price = $send_price;
            $this->min_order_price = $min_order_price;
            return $this->getCartData();
        }
    }

    public function getCartData(){
        $getCartData = Cart::getCartData('renting');
        foreach ($getCartData['product'] as $product) {

            $k = $product['product_id'];
            $this->cart_product_data[$k] = $product;
            if($product['product_offers'] == 0){
                $this->cart_price = $this->cart_price + $product['price1']; 
            }
            else if($product['product_offers'] == 1){
                $this->cart_price = $this->cart_price + $product['price2'];
            }
        }
        // dd($this->cart_product_data);
        $array = array();
        if($this->cart_price < $this->min_order_price){
            $array['normal_send_order_amount'] = number_format($this->send_price).' تومان';
            $array['integer_normal_send_order_amount'] = $this->send_price;
            $normal_cart_price = $this->cart_price + $this->send_price;
            $array['normal_cart_price'] = number_format($normal_cart_price).' تومان';
            $array['integer_normal_cart_price'] = $normal_cart_price.' تومان';
        }
        else{
            $array['normal_send_order_amount'] = 'رایگان';
            $array['integer_normal_send_order_amount'] = 0;
            $array['normal_cart_price'] = number_format($this->cart_price).' تومان';
            $array['integer_normal_cart_price'] = $this->cart_price.' تومان';
        }
        $guarantee = Session::get('order_pledge');
        $delivery_day = session::get('order_delivery_date');
        $delivery_time = session::get('order_delivery_time');

        $array['guarantee'] = $guarantee;
        $array['delivery_day'] = $delivery_day;
        $array['delivery_time'] = $delivery_time;

        $array['cart_product_data'] = $this->cart_product_data;
        // dd($array);
        return $array;
    }
}