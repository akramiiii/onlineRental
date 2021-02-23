<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Cart;
use App\User;
use App\OrderingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', 'SiteController@index');

Route::prefix('admin')->middleware(['auth' , 'admin'])->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin');
    Route::get('/panel', 'Admin\AdminController@author_panel')->name('author_panel');
    Route::get('/403', 'Admin\AdminController@error403')->name('error403');

    create_crud_route('category' , 'CategoryController');
    create_crud_route('product' , 'ProductController' , true);
    create_crud_route('slider' , 'SliderController');
    create_crud_route('province' , 'ProvinceController');
    create_crud_route('city', 'CityController');
    create_crud_route('pledge', 'PledgeController');
    create_crud_route('delivery', 'DeliveryController');
    create_crud_route('product/review', 'ReviewController');
    // Route::get('product/review/primary', 'Admin\ReviewController@primary');
    // Route::post('product/review/primary', 'Admin\ReviewController@add_primary_content');

    create_crud_route('userRole', 'UserRoleController');
    Route::get('userRole/access/{role_id}', 'Admin\UserRoleController@access');
    Route::post('userRole/access/{role_id}', 'Admin\UserRoleController@add_access');
    create_crud_route('users', 'UsersController', true);

    Route::get('orders/submission', 'Admin\OrdersController@submission');
    create_crud_route('orders', 'OrdersController' , ['create','store','edit','update']);
    // Route::get('orders', 'Admin\OrdersController@index');
    Route::get('orders/submission/approved', 'Admin\OrdersController@submission_approved');
    Route::get('orders/submission/ready', 'Admin\OrdersController@submission_ready');
    Route::get('orders/posting/send', 'Admin\OrdersController@posting_send');
    Route::get('orders/delivered/renting', 'Admin\OrdersController@delivered_renting');
    Route::get('orders/returned/renting', 'Admin\OrdersController@returned_renting');
    Route::get('orders/submission/{submission_id}', 'Admin\OrdersController@submission_info');
    Route::get('orders/{order_id}', 'Admin\OrdersController@show');
    Route::post('order/change_status', 'Admin\OrdersController@change_status');

    Route::get('product/gallery/{id}', 'Admin\ProductController@gallery');
    Route::post('product/gallery_upload/{id}', 'Admin\ProductController@gallery_upload');
    Route::delete('product/gallery/{id}', 'Admin\ProductController@removeImageGallery');
    Route::post('product/change_images_status/{id}', 'Admin\ProductController@change_images_status');
    Route::get('product/{id}/item', 'Admin\ProductController@item');
    Route::post('product/{id}/item', 'Admin\ProductController@add_item');

    Route::get('category/{id}/item' , 'Admin\ItemController@item');
    Route::post('category/{id}/item', 'Admin\ItemController@add_item');
    Route::delete('category/item/{id}' , 'Admin\ItemController@destroy');

    Route::get('incredible-offers' , 'Admin\AdminController@incredible_offers');
    Route::get('ajax/getProduct' , 'Admin\AdminController@getProduct');
    Route::post('add_incredible_offers/{product_id}' , 'Admin\AdminController@add_incredible_offers');
    Route::post('remove_incredible_offers/{product_id}' , 'Admin\AdminController@remove_incredible_offers');

    Route::match(['get' , 'post'] , 'setting/send-order-price' , 'Admin\SettingController@send_order_price');
    Route::match(['get' , 'post'], 'setting/payment-gateway', 'Admin\SettingController@payment_gateway');

});

// Route::get(config('shop-info.login_url'), 'Admin\AdminController@admin_login_form')->middleware('guest');

Route::get('admin_login', 'Admin\AdminController@admin_login_form')->middleware('guest');

Route::post('cart' , 'SiteController@add_cart');
Route::get('cart', 'SiteController@show_cart');
Route::get('renting' , 'RentingController@renting');
Route::get('renting/getSendData/{city_id}' , 'RentingController@getSendData');
Route::post('payment' , 'RentingController@payment');
Route::match(['get' , 'post'], 'order/verify', 'RentingController@verify');
Route::get('order/verify' , 'RentingController@verify');
// Route::get('order/verify2' , 'RentingController@verify2');
Route::get('order/payment' , 'RentingController@order_payment');

Route::get('product/{product_id}/{product_url}' , 'SiteController@show_product');
Route::get('product/{product_id}' , 'SiteController@show_product');
Route::get('/confirm', 'SiteController@confirm')->middleware('guest');
Route::get('/confirmphone', 'SiteController@confirmphone')->middleware('auth');
Route::post('changeMobileNumber', 'SiteController@changeMobileNumber')->middleware('auth');

Route::post('active_account', 'SiteController@active_account')->middleware('guest')->name('active_account');
Route::get('categories/{cat_url}', 'SiteController@show_child_cat_list');
Route::get('subcategory/{cat_url}/{cat2_url}', 'SiteController@cat_product');
Route::get('subcategory/{cat_url}/{cat2_url}/{cat3_url}', 'SiteController@get_cat_product');


//ajax
Route::post('ajax/resend' , 'SiteController@resend');
Route::post('site/cart/remove_product' , 'SiteController@remove_product');
Route::post('site/cart/change_product_count' , 'SiteController@change_product_count');
Route::post('site/cart/change_product_roz' , 'SiteController@change_product_roz');
Route::get('site/CartProductData','SiteController@CartProductData');

// Route::post('/cart', [Cart::class, 'show_cart']);


Auth::routes();
Route::get('password/confirm' , 'Auth\ForgotPasswordController@confirm')->middleware('guest');
Route::post('password/confirm', 'Auth\ForgotPasswordController@check_confirm_code')->middleware('guest');
Route::prefix('user')->middleware(['auth'])->group(function(){
    Route::get('profile', 'UserPanelController@profile');
    Route::get('getAddreass','UserController@getAddreass');
    Route::get('profile/address', 'UserPanelController@address');
    Route::post('/addAddress', 'UserController@addAddress');
    Route::delete('/removeAddress/{address_id}', 'UserController@removeAddress');
    Route::get('profile/orders', 'UserPanelController@orders');
    Route::get('profile/orders/{order_id}', 'UserPanelController@show_order');
    Route::get('profile/additional-info', 'UserPanelController@additional_info');
    Route::post('profile/additional-info', 'UserPanelController@save_additional_info');
    Route::get('profile/address', 'UserPanelController@address');

});

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function (Request $request) {
    // sendSms();
    // $user = User::find(30);
    // $user->notify(new \App\Notifications\SendSms($user->mobile, 'ارسال پیامک'));

    $OrderingTime=new OrderingTime(1);
    $OrderingTime->getGlobalSendData();



});
