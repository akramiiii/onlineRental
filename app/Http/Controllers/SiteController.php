<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Item;
use App\User;
use App\Pledge;
use App\Slider;
use App\Product;
use App\Category;
use App\Address;
use App\ItemValue;
use App\OrderingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{

    public function __construct()
    {
        getCatList();
    }

    public function index(){
        $slider = Slider::orderBy('id' , 'DESC')->get();
        $incredible_offers = Product::with('getCat')->with(['itemValue' => function($query){
            $query->whereHas('important_item')->with('important_item');
        }])->where(['offers' => 1])->limit(9)->get();

        $new_product = Product::where('status' , 1)->orderBy('id' , 'DESC')->limit(10)->get();
        $best_renting_product = Product::where('status', 1)->orderBy('order_number', 'DESC')->limit(10)->get();

        return view('shop.index' , compact('slider' , 'incredible_offers' , 'new_product' , 'best_renting_product'));
    }

    public function show_product($product_id , $product_url = null){
        $id = str_replace('dkp-' , '' , $product_id);
        $where = ['id' => $id];
        if($product_url != null){
            $where['product_url'] = $product_url;
        }
        $product = Product::where($where)->with('getCat')->firstOrFail();
        $product_items = Item::getProductItem($product);
        $product_item_count = ItemValue::where('product_id' , $product->id)->count();
        $relate_products = Product::where(['cat_id' => $product->cat_id])->where('id','!=',$product->id)->limit(15)->get();
        return view('shop.show_product' , compact('product' , 'product_items' , 'product_item_count' , 'relate_products'));
    }

    public function confirm(){
        if(Session::has('mobile_number')){
            return view('auth.confirm');
        }
        else{
            return redirect('/');
        }
    }

    public function confirmphone()
    {
        if(Session::has('mobile_number'))
        {
            // $layout=$this->view=='mobile.' ? 'mobile-auth' : 'auth';
            // $margin=$this->view=='mobile.' ? '10' : '25';
            // ,['layout'=>$layout,'margin'=>$margin]
            return view('auth.confirmphone');
        }
        else{
            return redirect('/');
        }
    }

    public function resend(Request $request){
        return User::resend($request);
    }

    public function active_account(Request $request){
        $mobile = $request->get('mobile');
        $active_code = $request->get('active_code');
        $user = User::where(['mobile' => $mobile , 'active_code' => $active_code , 'account_status' => 'InActive'])->first();
        if($user){
            $user->account_status = 'active';
            $user->active_code = null;
            $user->update();
            Auth::guard()->login($user);
            return redirect('/');
        }
        else{
            return redirect()->back()->with('mobile_number' , $mobile)->with('validate_error' , 'کد وارد شده اشتباه می باشد')->withInput();
        }
    }

    public function changeMobileNumber(Request $request)
    {
        return User::changeMobileNumber($request);
    }

    public function add_cart(Request $request){
        // dd($request->all());
        // dd('rozz');
        Cart::add_cart($request->all());
        return redirect('/cart');
    }

    public function show_cart(Request $request){
        // $roz = $request->get('roz');
        // $date = $request->get('date');
        // dd($roz);
        $cart_data = Cart::getCartData();
        return view('shop.cart' , compact('cart_data'));
    }

    public function remove_product(Request $request){
        return Cart::removeProduct($request);
    }

    public function change_product_count(Request $request){
        return Cart::changeProductCount($request);
    }

    public function change_product_roz(Request $request){
        return Cart::changeProductRoz($request);
    }

    public function show_child_cat_list($cat_url){
        $category=Category::with('getChild.getChild')->where('url',$cat_url)->firstOrFail();
        return view('shop.child_cat',['category'=>$category]);
    }

    public function cat_product($cat_url , $cat2_url ,Request $request){
        $category=Category::with(['getChild'=>function($query){
            $query->whereNull('search_url');
        }])->where('url',$cat_url)->firstOrFail();
        $category2 = Category::where('url',$cat2_url)->firstOrFail();
        $category3 = Category::where(['url' => $cat2_url])->select('id' , 'url')->firstOrFail();
        // dd($category3->url);
        $category4 = Category::where(['parent_id' => $category3->id])->get();
        foreach ($category4 as $key => $value) {
            $products[] = Product::with('getCat')->where(['cat_id' => $value->id])->get();
        }

        
        
            // dd($value);

        
        return view('shop.cat_product',compact('category' , 'category2' , 'category3' , 'category4' , 'products'));
    }

    public function get_cat_product($cat_url , $cat2_url , $cat3_url ,Request $request){
        $category=Category::with(['getChild'=>function($query){
            $query->whereNull('search_url');
        }])->where('url',$cat_url)->firstOrFail();
        $category2 = Category::where('url',$cat2_url)->firstOrFail();
        $category3 = Category::where(['url' => $cat2_url])->select('id' , 'url')->firstOrFail();
        // dd($category3->url);
        $category4 = Category::where(['parent_id' => $category3->id])->get();
        // dd($category4);
        // dd($request['referer']);
        return view('shop.products',compact('category' , 'category2' , 'category3' , 'category4' , 'request'));
    }

    public function CartProductData()
    {
        return Cart::getCartData();
    }
}
