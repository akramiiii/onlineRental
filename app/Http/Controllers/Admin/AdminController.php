<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Order;
use App\Offers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    public function index()
    {
        $submissions = DB::table('order_info')->count();
        $submissions_approved = DB::table('order_info')->where('send_status' , 1)->count();
        $submissions_ready = DB::table('order_info')->where('send_status', 2)->count();
        $posting_send = DB::table('order_info')->where('send_status', 3)->count();
        $delivered = DB::table('order_info')->where('send_status', 4)->count();
        $returned = DB::table('order_info')->where('send_status', 5)->count();
        $user_count = User::count();
        $order_count = Order::count();
        $product_count = Product::count();
        $last_orders = Order::orderBy('id' , 'DESC')->limit(5)->get();

        return view('admin.index' , compact('submissions' , 'submissions_approved' , 'submissions_ready' , 'posting_send' , 'delivered' , 'returned' , 'user_count' , 'order_count' , 'product_count' , 'last_orders'));
    }

    public function incredible_offers(){
        return view('admin.incredible_offers');
    }

    public function getProduct(Request $request){
        $search_text = $request->get('search_text' , '');

        $product = Product::orderBy('offers' , 'DESC')->paginate(10);

        // if (array_key_exists('string', $request) && !empty($request['string'])) {
        //     $category = $category->where('name', 'like', '%' . $request['string'] . '%');
        //     $category = $category->orWhere('ename', 'like', '%' . $request['string'] . '%');
        //     $string = create_paginate_url($string, 'string='.$request['string']);
        // }


        // if(empty(trim($search_text))){
        //     $product = $product;
        // }
        // else{
        //     define('search_text' , $search_text);
        //     $product->whereHas(function(Builder $query){
        //         $query->where('title' , 'like' , '%' . search_text . '%');
        //     });
        // }
        return $product;
    }

    public function add_incredible_offers($id , Request $request){
        $product = Product::find($id);
        if($product){
            $offers = new Offers();
            $res = $offers->add($request , $product);

            return $res;
        }
        else{
            return 'error';
        }
    }

    public function remove_incredible_offers($id , Request $request){
        $product = Product::find($id);
        if($product){
            $offers = new Offers();
            $res = $offers->remove($product);

            return $res;
        }
        else{
            return 'error';
        }
    }

    public function admin_login_form()
    {
        return view('admin.admin_login_form');
    }

    public function error403()
    {
        return view('admin.403');
    }
    
    public function author_panel()
    {
        return view('admin.author_panel');
    }
}
