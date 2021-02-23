<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Cart{

    public static function add_cart($data){

        // Session::forget('new_cart');
        $id = array_key_exists('id' , $data) ? $data['id'] : 0;
        $cart = Session::get('new_cart' , array());
        $index=-1;
        if(!empty($cart)){
            if(array_key_exists($id , $cart)){
                $count = $cart[$id]['count'] + 1;
                if(self::check($id , $count)){
                    $cart[$id]=['id' => $id , 'count' => $cart[$id]['count']+1 , 'rooz' => 1];
                }
            } else {
                $cart[$id]=['id' => $id , 'count' => 1 , 'rooz' => 1];
            }

        } else {
            $cart[$id]=['id' => $id , 'count' => 1 , 'rooz' => 1];
        }

        session()->put('new_cart' , $cart);
    }

    public static function check($id , $count){
        $product = Product::where(['id' => $id])->first();
        if($product && $product->product_number >= $count && $product->product_number_cart >= $count){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getCartData($type = 'cart'){
        $cart = Session::get('new_cart', array());
        // $products=new Product;
        // $productsId=array();
        $product_id = array();
        $data = array();
        $i = 0;

        foreach($cart as $key => $value){
                // echo $key;
                // echo '<hr>';
                // $productsId[]=$product['id'];
                $product_id[$key] = $key;
                $row = Product::where(['id' => $key])->first();

                if($row){
                    $data[$i] = $row;
                    $i++;

                    $cart_product_number[$key] = $value['count'];
                    $cart_product_roz[$key] = $value['rooz'];
                }
        }

        $products = Product::whereIn('id' , $product_id)->select('id' , 'title' , 'img_url' , 'offers')->get();
        // var_dump($products);

        // $products=Product::whereIn('id',$productsId)->get();
        // return $products;

        $total_price = 0;
        $cart_price = 0;
        $cart_data = array();
        $j=0;

        foreach ($data as $key => $value) {
            $product = getCartProductData($products , $value->id);
            $n = $value->id;
            $product_number = array_key_exists($n, $cart_product_number) ? $cart_product_number[$n] : '0';
            $product_roz2 = array_key_exists($n, $cart_product_roz) ? $cart_product_roz[$n] : '0';

            // var_dump($product->title);
            if($product){
                $cart_data['product'][$j]['product_id']=$product->id;
                $cart_data['product'][$j]['product_title']=$product->title;
                $cart_data['product'][$j]['product_img_url']=$product->img_url;
                $cart_data['product'][$j]['product_offers']=$product->offers;
                $cart_data['product'][$j]['send_day']=$value->send_time;
                if($type == 'cart'){
                    $cart_data['product'][$j]['price1']=number_format($product_roz2 * $product_number * $value->price1);
                    $cart_data['product'][$j]['price2']=number_format($product_roz2 * $product_number * $value->price2);
                }
                else{
                    $cart_data['product'][$j]['price1']= $product_roz2 * $product_number * $value->price1;
                    $cart_data['product'][$j]['price2']= $product_roz2 * $product_number * $value->price2;
                }
                $cart_data['product'][$j]['product_number_cart']=$value->product_number_cart;
                $cart_data['product'][$j]['product_roz']=$value->roz;
                $cart_data['product'][$j]['product_count']=$product_number;
                $cart_data['product'][$j]['product_roz2']=$product_roz2;
                if($product->offers == 1){
                    $total_price += $product_roz2 * $product_number * $value->price1;
                    $cart_price += $product_roz2 * $product_number * $value->price2;
                }
                elseif($product->offers == 0){
                    $total_price += $product_roz2 * $product_number * $value->price1;
                    $cart_price += $product_roz2 * $product_number * $value->price1;
                }
                $j++;
            }

            $discount = number_format($total_price - $cart_price);

            Session::put('total_product_price', $total_price);
            Session::put('final_price', $cart_price);

            $cart_data['total_price'] = number_format($total_price);
            $cart_data['cart_price'] = number_format($cart_price);
            $cart_data['discount'] = $discount > 0 ? $discount : 0;
            $cart_data['product_count'] = $j;
            // $cart_data['product_roz2'] = $j;
        }
        // echo '<pre>';
        // print_r($cart_data);

        return $cart_data;

    }

    public static function removeProduct($request){
        $product_id = $request->get('product_id' , 0);
        $cart = Session::get('new_cart');
        if(array_key_exists($product_id , $cart)){
            unset($cart[$product_id]);
            Session::put('new_cart', $cart);
            if(empty($cart)){
                Session::forget('new_cart');
            }
            else{
                Session::put('new_cart', $cart);
            }
            return self::getCartData();
        }
        else{
            return 'error';
        }
    }

    public static function changeProductCount($request){
        // Session::forget('new_cart');

        $product_id = $request->get('product_id', 0);
        $product_count = $request->get('product_count' , 1);

        settype($product_count , 'integer');
        $cart = Session::get('new_cart');
        if (array_key_exists($product_id, $cart)) {
            if($product_count > 0 && self::check($product_id , $product_count)){
                $cart[$product_id]['count'] = $product_count;
                Session::put('new_cart' , $cart);
                return self::getCartData('cart');
            }
            else{
                return 'error';
            }
        }
        else{
            return 'error';
        }
    }

    public static function get_product_count(){
        $count = 0;
        $cart = Session::get('new_cart' , array());
        foreach ($cart as $key => $value) {
            $count += 1;
        }
        return $count;
    }

    public static function changeProductRoz($request){
        $product_id = $request->get('product_id', 0);
        $product_roz2 = $request->get('product_roz2', 1);

        settype($product_roz2, 'integer');
        $cart = Session::get('new_cart');
        if (array_key_exists($product_id, $cart)) {
            if($product_roz2 > 0){
                $cart[$product_id]['rooz'] = $product_roz2;
                Session::put('new_cart', $cart);
                return self::getCartData('cart');
            }
            else{
                return 'error';
            }
        }
        else{
            return 'error';
        }

    }

    // public static function get_product_roz(){
    //     $roz = 0;
    //     $cart_roz = Session::get('cart_roz' , array());
    //     foreach ($cart_roz as $key => $value) {
    //         $roz += sizeof($value['product_data_roz']);
    //     }
    //     return $roz;
    // }

    public static function empty_cart($user_id=null)
    {
        if(Auth::check() || $user_id)
        {
            $user_id=$user_id ? $user_id : Auth::user()->id;
            Session::forget('new_cart');

            // DB::table('cart')->where(['user_id'=>$user_id])->delete();
        }
    }
}