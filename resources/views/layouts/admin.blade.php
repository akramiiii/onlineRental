<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل مدیریت</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    
    <div class="container-fluid">
        <div class="page_sidebar">
            <?php

                $sideBarMenu=array();
                $sideBarMenu[0]=[
                    'label'=>'محصولات',
                    'icon'=>'fa fa-shopping-cart',
                    'access'=>'products|category',
                    'child'=>[
                        ['url'=>url('admin/product'),'label'=>'مدیریت محصولات','access'=>'products'],
                        ['url'=>url('admin/product/create'),'label'=>'افزودن محصول','access'=>'products','accessValue'=>'product_edit'],
                        ['url'=>url('admin/category'),'label'=>'مدیریت دسته ها','access'=>'category']
                    ]
                ];

                $sideBarMenu[1]=[
                    'label'=>'اسلایدر ها',
                    'icon'=>'fa fa-sliders',
                    'access'=>'sliders',
                    'child'=>[
                        ['url'=>url('admin/slider'),'label'=>'مدیریت اسلایدر ها','access'=>'sliders'],
                        ['url'=>url('admin/slider/create'),'label'=>'افزودن اسلایدر','access'=>'sliders'],
                    ]
                ];

                $sideBarMenu[2]=[
                    'label'=>'مناطق',
                    'icon'=>'fa fa-location-arrow',
                    'access'=>'location',
                    'child'=>[
                        ['url'=>url('admin/province'),'label'=>'مدیریت استان ها','access'=>'location'],
                        ['url'=>url('admin/city'),'label'=>'مدیریت شهر ها','access'=>'location'],
                    ]
                ];

                $sideBarMenu[3]=[
                    'label'=>'ضمانت و ساعت تحویل',
                    'icon'=>'fa fa-clock-o',
                    'access'=>'pledge',
                    'child'=>[
                        ['url'=>url('admin/pledge'),'label'=>'تعیین ضمانت از مشتری','access'=>'pledge'],
                        ['url'=>url('admin/delivery'),'label'=>'تعیین ساعت تحویل کالا','access'=>'pledge'],
                    ]
                ];

                $sideBarMenu[4]=
                [
                    'label'=>'کاربران',
                    'icon'=>'fa fa-users',
                    'access'=>'users',
                    'child'=>[
                        ['url'=>url('admin/users'),'label'=>'مدیریت کاربران','access'=>'users'],
                        ['url'=>url('admin/userRole'),'label'=>'نقش های کاربری','access'=>'users','accessValue'=>'user_access'],
                    ]
                ];

                $sideBarMenu[5]=[
                    'label'=>'سفارشات',
                    'icon'=>'fa fa-list',
                    'access'=>'orders',
                    'child'=>[
                        ['url'=>url('admin/orders'),'label'=>'مدیریت سفارشات','access'=>'orders','accessValue'=>0],
                        ['url'=>url('admin/orders/submission'),'label'=>'مدیریت مرسوله ها','access'=>'orders','accessValue'=>4],
                        ['url'=>url('admin/orders/submission/approved'),'label'=>'مرسوله های تایید شده','access'=>'orders','accessValue'=>5],
                        ['url'=>url('admin/orders/submission/ready'),'label'=>'مرسوله های آماده ارسال','access'=>'orders','accessValue'=>6],
                        ['url'=>url('admin/orders/posting/send'),'label'=>'مرسوله های ارسال شده','access'=>'orders','accessValue'=>7],
                        ['url'=>url('admin/orders/delivered/renting'),'label'=>'مرسوله های تحویل داده شده','access'=>'orders','accessValue'=>8],
                        ['url'=>url('admin/orders/returned/renting'),'label'=>'مرسوله های برگشت داده شده','access'=>'orders','accessValue'=>9],
                    ]
                ];

                // $sideBarMenu[6]=
                // [
                //     'label'=>'پیشنهاد شگفت انگیز',
                //     'icon'=>'fa fa-gift',
                //     'access'=>'incredible-offers',
                //     'url'=>url('admin/incredible-offers')
                // ];

                $sideBarMenu[7]=[
                    'label'=>'تنظیمات',
                    'icon'=>'fa fa-cogs',
                    'access'=>'setting',
                    'child'=>[
                        // ['url'=>url('admin/setting/shop'),'label'=>'فروشگاه','access'=>'setting'],
                        ['url'=>url('admin/setting/send-order-price'),'label'=>'هزینه ارسال سفارشات','access'=>'setting'],
                        ['url'=>url('admin/setting/payment-gateway'),'label'=>'درگاه پرداخت','access'=>'setting'],
                    ]
                ];
            ?>

            <span class="fa fa-times" id="sidebarToggle"></span>
            @php
                $access2 = isset($access) ? $access : null;
                $access = isset($access) ? json_decode($access) : null;
            @endphp
            <ul id="sidebar_menu">
                @foreach($sideBarMenu as $key=>$value)
                    <?php $child=array_key_exists('child',$value); ?>
                    
                    @if(checkParentMenuAccess($access,$value['access']))
                        <li>
                            <a @if(array_key_exists('url',$value)) href="{{ $value['url'] }}" @endif>
                                <span class="{{ $value['icon'] }}"></span>
                                <span class="sidebar_menu_text">{{ $value['label'] }}</span>
                                @if($child)  <span class="fa fa-angle-left"></span> @endif

                            </a>
                            @if($child)
                                <div class="child_menu">
                                    @foreach($value['child'] as $key2=>$value2)
                                        @if (checkAddChildMuenAccess($access,$value2))
                                            <a href="{{ $value2['url'] }}">
                                                {{ $value2['label'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
                <li>
                    <a href="{{ '/' }}">
                        <span href="" class="fa fa-sign-out"></span>
                        <span>خروج</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="page_content">
            <div class="page_header">
                <div>پنل مدیریت</div>
                <div>
                    <form method="post" action="{{ url('/logout') }}" id="logout_form">@csrf</form>
                    <ul style="direction: ltr">
                        <li>
                            <a onclick="logout()">
                                <span class="fa fa-sign-out"></span>
                            </a>
                        </li>
                        @if(has_access_author_admin($access2,'orders') || Auth::user()->role=='admin')
                            <li>
                                <a href="{{ url('admin/orders') }}" target="_blank">
                                    @if(isset($new_order_count) && $new_order_count!=0)
                                        <span class="count_header_span" data-count="{{ $new_order_count }}"></span>
                                    @endif
                                    <span class="fa fa-shopping-cart"></span>
                                </a>
                            </li>
                        @endif
                        {{--  @if(has_access_author_admin($access2,'products','product_edit') || Auth::user()->role=='admin')
                        <li>
                            <a href="{{ url('admin/products') }}" target="_blank">
                                @if(isset($product_awaiting_review) && $product_awaiting_review!=0)
                                    <span class="count_header_span" data-count="{{ replace_number($product_awaiting_review) }}"></span>
                                @endif
                                <span class="fa fa-bell-o"></span>
                            </a>
                        </li>
                        @endif
                        @if(has_access_author_admin($access2,'messages') || Auth::user()->role=='admin')
                        <li>
                            <a href="{{ url('admin/messages') }}" target="_blank">
                                @if(isset($message_count) && $message_count!=0)
                                    <span class="count_header_span" data-count="{{ replace_number($message_count) }}"></span>
                                @endif
                                <span class="fa fa-envelope-o"></span>
                            </a>
                        </li>
                        @endif  --}}
                    </ul>
                </div>
            </div>
            <div class="content_box" id="app">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="message_div">
        <div class="message_box">
            <p id="msg"></p>
            <a class="alert alert-success" onclick="delete_row()">بله</a>
            <a class="alert alert-danger" onclick="hide_box()">خیر</a>
        </div>
    </div>

    <div id="loading_box">
        <div class="loading_div">
            <div class="loading"></div>
            <span>در حال ارسال اطلاعات</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/AdminVue.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('footer')
</body>
</html>