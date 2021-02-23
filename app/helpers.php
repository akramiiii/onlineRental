<?php 

use App\Order;
use App\Lib\Jdf;
use App\Category;
use App\Ghasedak\GhasedakApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;


function get_url($string){
    $url = str_replace('-' , ' ' , $string);
    $url = str_replace('/', ' ', $url);
    $url=preg_replace('/\s/' , '-' , $url);
    return $url;
}

function upload_file($request, $name, $directory, $pix='')
{
    if ($request->hasFile($name)) {
        $file_name=$pix.time().'.'.$request->file($name)->getClientOriginalExtension();
        if ($request->file($name)->move('files/'.$directory, $file_name)) {
            return $file_name;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function replace_number($number)
{
    $number = str_replace("۰" , "0" , $number);
    $number = str_replace("۱" , "1" , $number);
    $number = str_replace("۲" , "2" , $number);
    $number = str_replace("۳" , "3" , $number);
    $number = str_replace("۴" , "4" , $number);
    $number = str_replace("۵" , "5" , $number);
    $number = str_replace("۶" , "6" , $number);
    $number = str_replace("۷" , "7" , $number);
    $number = str_replace("۸" , "8" , $number);
    $number = str_replace("۹" , "9" , $number);
}

function inTrashed($req)
{
    if(array_key_exists('trashed' , $req) && $req['trashed'] == 'true'){
        return true;
    }
    else{
        return false;
    }
}

function create_paginate_url($string , $text){
    if($string == "?"){
        $string = $string.$text;
    }
    else{
        $string = $string.'&'.$text;
    }
    return $string;
}

// function create_crud_route($route_param , $controller , $show=false){
//     if($show){
//         Route::resource($route_param, 'Admin\\'.$controller);
//     }
//     else{
//         Route::resource($route_param, 'Admin\\'.$controller)->except('show');
//     }
//     Route::post($route_param.'/remove_items', 'Admin\\'.$controller.'@remove_items')->name($route_param.'.destroy');
//     Route::post($route_param.'/restore_items', 'Admin\\'.$controller.'@restore_items')->name($route_param.'.restore');
//     Route::post($route_param.'/{'.$route_param.'}', 'Admin\\'.$controller.'@restore')->name($route_param.'.restore');
// }

function create_crud_route($route_param, $controller, $except=['show'], $config=[])
{
    Route::resource($route_param, 'Admin\\'.$controller, $config)->except($except);
    Route::post($route_param.'/remove_items', 'Admin\\'.$controller.'@remove_items')->name($route_param.'.destroy');
    Route::post($route_param.'/restore_items', 'Admin\\'.$controller.'@restore_items')->name($route_param.'.restore');
    Route::post($route_param.'/{id}', 'Admin\\'.$controller.'@restore')->name($route_param.'.restore');
}


function create_fit_pic($pic_url , $pic_name){
    $thum = Image::make($pic_url);
    $thum->resize(350 , 350);
    $thum->save('files/thumbnails/'.$pic_name);
}

function remove_file($file_name , $directory){
    if(!empty($file_name) && file_exists('files/'.$directory.'/'.$file_name)){
        unlink('files/'.$directory.'/'.$file_name);
    }
}

function get_show_category_count($catList)
{
    $n=0;
    foreach ($catList as $key=>$value) {
        if ($value->notShow==0) {
            $n++;
        }
    }
    return $n;
}

function getCatList(){
    $data = cache('catList');
    if($data){
        View::share('catList',$data);
    }
    else{
        $category = Category::with('getChild.getChild')->where('parent_id' , 0)->get();
        $minutes = 30*24*60*60;
        cache()->put('catList' , $category , $minutes);
        View::share('catList',$category);
    }
}

function get_cat_url($cat){
    if(!empty($cat->search_url)){
        return url($cat->url);
    }
    else{
        return url('search/'.$cat->url);
    }
}

function getTimestamp($date , $type){
    $jdf = new Jdf();
    $time = 0;
    $e = explode('/' , $date);
    if(sizeof($e) == 3){
        $y = $e[0];
        $m = $e[1];
        $d = $e[2];
    }
    if($type == 'first'){
        $time = $jdf->jmktime(0 , 0 , 0 , $m , $d , $y);
    }
    else{
        $time = $jdf->jmktime(23, 59, 59, $m, $d, $y);
    }
    return $time;
}

function getCartProductData($products , $product_id){
    foreach ($products as $key => $value) {
        if($value->id == $product_id){
            return $value;
        }
    }
}

function getProductCost($info,$products){
    $amount = $info->send_order_amount;
    $products_id = explode('-' , $info->products_id);
    foreach ($products_id as $key => $value) {
        if(!empty($value)){
            // $p = getProductDataOfList($products , $value);
            // $amount+=$p;
        }
    }
    return $amount;
}

function getProductDataOfList($products , $product_id){
    foreach ($products as $key => $value) {
        if($value->product_id == $product_id){
            $amoun = $value->product_price2 * $value->product_count * $value->product_roz;
        }
    }
}

function set_order_product_status($orderInfo, $status)
{
    $products_id=$orderInfo->products_id;
    $products_id=explode('-', $products_id);
    foreach ($products_id as $key=>$value) {
        if (!empty($value)) {
            DB::table('order_products')->where(['order_id'=>$orderInfo->order_id,'product_id'=>$value])->update(['send_status'=>$status]);
        }
    }
}

function getOrderProductCount($products_id)
{
    $e=explode('-', $products_id);
    return sizeof($e);
}

function getUserPersonalData($additionalInfo, $att1, $attr2=null)
{
    $result='-';
    if ($additionalInfo && !empty($additionalInfo->$att1)) {
        $result=$additionalInfo->$att1;
        if ($attr2) {
            $result.=' '. $additionalInfo->$attr2;
        }
    }
    return $result;
}

function getUserData($key, $additionalInfo)
{
    if (!empty(old($key))) {
        return old($key);
    } else {
        if ($key=='mobile_phone') {
            return Auth::user()->mobile;
        } elseif ($additionalInfo && !empty($additionalInfo->$key)) {
            return $additionalInfo->$key;
        } else {
            return '';
        }
    }
}

function checkEven($n)
{
    if ($n%2==0) {
        return true;
    } else {
        return false;
    }
}

function CheckAccess($AccessList, $key1, $key2)
{
    $result=false;
    if ($AccessList) {
        $access=json_decode($AccessList->access);
        if (is_object($access)) {
            if (property_exists($access, $key1)) {
                if (is_array($access->$key1)) {
                    foreach ($access->$key1 as $k=>$v) {
                        if ($v==$key2) {
                            $result=true;
                        }
                    }
                }
            }
        }
    }
    return $result;
}

function checkUserAccess($access, $route, $AccessList)
{
    $result=false;
    $access=json_decode($access);
    if (is_object($access)) {
        foreach ($access as $key=>$value) {
            if (array_key_exists($key, $AccessList)) {
                $userAccess=$AccessList[$key]['access'];
                foreach ($value as $key2=>$value2) {
                    if (array_key_exists($value2, $userAccess)) {
                        if (array_key_exists('routes', $userAccess[$value2])) {
                            foreach ($userAccess[$value2]['routes'] as $accessRoute) {
                                if ($accessRoute==$route) {
                                    $result=true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $result;
}

function checkParentMenuAccess($accessList, $access)
{
    $result=false;
    if (Auth::user()->role=='admin') {
        $result=true;
    } 
    else {
        $e=explode('|', $access);
        if (sizeof($e)>0 && is_object($accessList)) {
            foreach ($e as $key=>$value) {
                if (!empty($value)) {
                    if (property_exists($accessList, $value)) {
                        $result=true;
                    }
                }
            }
        }
    }
    return $result;
}

function checkAddChildMuenAccess($accessList, $child)
{
    $result=false;
    if (Auth::user()->role=='admin') {
        $result=true;
    } 
    else {
        $property=$child['access'];
        if (is_object($accessList)) {
            if (property_exists($accessList, $property)) {
                if (is_array($accessList->$property)) {
                    if (!array_key_exists('accessValue', $child)) {
                        $result=true;
                    } 
                    else {
                        foreach ($accessList->$property as $key=>$value) {
                            if ($value==$child['accessValue']) {
                                $result=true;
                            }
                        }
                    }
                }
            }
        }
    }
    return $result;
}

// function sendSms(){
//     $api = new \App\Ghasedak\GhasedakApi('dfb63ae6c202d088f1623578b1151d7264964fc1634b7c78076596de6f9a7e37');

//     try {
//         $api->SendSimple("09136866193", "Hello World!", "10008566");
//     } 
//     catch (\Exception $e) {
        
//     }

// }

function set_admin_panel_variables()
{
    $new_order_count=Order::where('order_read', 'no')->count();
    View::share('new_order_count', $new_order_count);
}

function set_author_admin_variables($access)
{
    if (has_access_author_admin($access, 'orders')) {
        $new_order_count=Order::where('order_read', 'no')->count();
        View::share('new_order_count', $new_order_count);
    }
}

function has_access_author_admin($accessList, $property, $accessValue=null)
{
    $result=false;
    try {
        $accessList=json_decode($accessList);
        if (is_object($accessList)) {
            if (property_exists($accessList, $property)) {
                if (is_array($accessList->$property)) {
                    if ($accessValue==null) {
                        $result=true;
                    } else {
                        foreach ($accessList->$property as $key=>$value) {
                            if ($value==$accessValue) {
                                $result=true;
                            }
                        }
                    }
                }
            }
        }
    } 
    catch (\Exception $e) {
    }
    return $result;
}

function check_save_product_to_cart_table($product_data, $cart_table_data, $user_id, $type)
{
    $save=true;
    $row_id=0;
    $product_price=0;
    $product_count=0;
    $product_roz2=0;
    $initial_amount=0;
    $product_status='available';
    $price=($type=="application") ? ($product_data['price2']*$product_data['product_count'])*$product_data['product_roz2'] : $product_data['price2'];
    foreach ($cart_table_data as $key=>$value) {
        if ($value->product_id==$product_data['product_id']) {
            $save=false;
            $product_price=$value->initial_amount;
            $product_count=$value->count;
            $product_roz2=$value->roz;
            $product_status=$value->product_status;
            $row_id=$value->id;
        }
    }
    if ($save) {
        DB::table('cart')->insert([
            'user_id'=>$user_id,
            'product_id'=>$product_data['product_id'],
            'count'=>$product_data['product_count'],
            'roz'=>$product_data['product_roz2'],
            'initial_amount'=>$price,
        ]);
        $initial_amount=$price;
    } else {
        if ($product_data['product_count']!=$product_count) {
            $status=$product_data['product_count']==0 ? 'unavailable' : $product_data['product_count'];

            DB::table('cart')->where(['user_id'=>$user_id,'id'=>$row_id])
                ->update(['product_status'=>$status]);
        } else {
            if ($product_price!=$price) {
                $price=$price/$product_data['product_count'];
                DB::table('cart')->where(['user_id'=>$user_id,'id'=>$row_id])
                    ->update(['final_amount'=>$price]);
            }
        }
        $initial_amount=$product_price;
    }
    return [
        'initial_amount'=>$initial_amount,
        'initial_product_count'=>$product_count
    ];
}

function remove_product_of_cart_table($product_id, $warranty_id, $color_id)
{
    $result=false;
    if (Auth::check()) {
        $user_id=Auth::user()->id;
        $e=explode('_', $warranty_id);
        if (sizeof($e)==2) {
            $row=DB::table('cart')->where([
                'product_id'=>$product_id,
                'product_warranty_id'=>$e[0],
                'warranty_id'=>$e[1],
                'color_id'=>$color_id,
                'user_id'=>$user_id
            ])->first();
            if ($row) {
                DB::table('cart')->where([
                    'product_id'=>$product_id,
                    'product_warranty_id'=>$e[0],
                    'warranty_id'=>$e[1],
                    'color_id'=>$color_id,
                ])->delete();
                Session::forget('cart_final_price');
                Session::forget('discount_value');
                $result=true;
            }
        }


        if ($result) {
            $shippingCartProducts=new \App\ShoppingCartProducts('cart', [], [1,2]);
            return $shippingCartProducts->getCartDataWithSendType();
        } else {
            return  'error';
        }
    } else {
        return 'error';
    }
}



