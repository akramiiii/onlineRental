<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سایت اجاره کالا</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/ShopVue.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/shop.js') }}" type="text/javascript"></script>
</head>
<body>
    <div id="app">
        <div class="header">
            <a href="{{ url('') }}">
                <img src="{{ asset('files/images/signboard_for_rent (2).png') }}" class="shop_logo">
            </a>
            <div class="header_row">
                <div class="input-group index_header_search">
                    <input type="text" class="form-control" placeholder="کالای مورد نظر خود را جستجو کنید...">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>

                <div class="header_action">
                    <div class="dropdown">
                        <div class="index_auth_div" role="button" data-toggle="dropdown">
                            <span>
                                @if(Auth::check())
                                    @if(!empty(Auth::user()->name))
                                        {{ Auth::user()->name }}
                                    @else
                                        {{ Auth::user()->mobile }}
                                    @endif
                                @else
                                    ورود / ثبت‌نام
                                @endif
                            </span>
                            <span class="fa fa-angle-down"></span>
                        </div>
                        <div class="dropdown-menu header_auth_box">
                            {{-- <span class="fa fa-dashboard"></span> --}}
                            @if(Auth::check())
                                @if(Auth::user()->role_id>0 || Auth::user()->role=='admin')
                                    <a class="dropdown-item admin" href="{{ url('admin') }}">
                                        پنل مدیریت
                                    </a>
                                @endif
                            @else
                                <a class="btn btn-primary" href="{{ url('login') }}">ورود به سایت</a>
                                <div class="register_link">
                                    <span>کاربر جدید هستید ؟</span>
                                    <a class="link" href="{{ url('register') }}">ثبت نام</a>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item profile" href="{{ url('user/profile') }}"> 
                                پروفایل
                            </a>
                            <a class="dropdown-item order" href="{{ url('user/profile/orders') }}">
                                پیگیری سفارش
                            </a>
                            @if(Auth::check())
                                <form method="post" action="{{ url('logout') }}" id="logout_form">
                                    @csrf
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item logout" >
                                    خروج از حساب کاربری
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="header_driver"></div>

                    <div class="cart_header_box">
                        <div class="btn-cart" data-toggle="dropdown">
                            <span id="cart-product-count" data-counter="{{ App\Cart::get_product_count() }}">سبد خرید</span>
                        </div>

                        @if(App\Cart::get_product_count()>0)
                            <div class="dropdown cart">
                                <div class="dropdown-menu">
                                    <header-cart></header-cart>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('include.categoryList' , ['catList'])

        <div class="container-fluid">
            @yield('content')
        </div>

        <div id="loading_box">
            <div class="loading_div">
                <img src="{{ asset('files/images/shop_icon.jpg') }}">
                <div class="spinner">
                    <div class="b1"></div>
                    <div class="b2"></div>
                    <div class="b3"></div>
                </div>
            </div>
        </div>

        <footer class="c-footer">
            <nav>
                <a href="">
                    <div class="c-footer_feature_item-1">تضمین سلامت محصول</div>
                </a>
                <a href="">
                    <div class="c-footer_feature_item-2">تحویل سریع</div>
                </a>
                <a href="">
                    <div class="c-footer_feature_item-3">پرداخت در محل</div>
                </a>
                <a href="">
                    <div class="c-footer_feature_item-4">ارزان تر زندگی کنید</div>
                </a>
                <a href="">
                    <div class="c-footer_feature_item-5">تجربه بهترین های روز</div>
                </a>
            </nav>

            <div class="row">
                <div class="col-md-3">
                    <h6>راهنمای خرید از {{ env('SHOP_NAME','') }}</h6>
                    <ul>
                        <li>
                            <a href="">نحوه ثبت سفارش</a>
                        </li>
                        <li>
                            <a href="">رویه ارسال سفارش</a>
                        </li>
                        <li>
                            <a href="">شیوه های پرداخت</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>خدمات مشتریان</h6>
                    <ul>
                        <li>
                            <a href="">پاسخ به پرسش‌های متداول</a>
                        </li>
                        <li>
                            <a href="">رویه‌های بازگرداندن کالا</a>
                        </li>
                        <li>
                            <a href="">شرایط استفاده</a>
                        </li>
                        <li>
                            <a href="">حریم خصوصی</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>از تخفیف‌ها و جدیدترین‌های {{ env('SHOP_NAME','') }} باخبر شوید</h6>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="آدرس ایمیل خود را وارد کنید">
                        <button class="btn btn-success">ارسال</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <h6>مجوز های فروشگاه</h6>
                    <div>
                        <img src="{{ url('files/images/enamad.png') }}">
                        <img src="{{ url('files/images/BPMLogo.png') }}">
                    </div>
                </div>
            </div>

            <p>
                استفاده از مطالب فروشگاه اینترنتی {{ env('SHOP_NAME','') }} فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است. کلیه حقوق این سایت متعلق به (فروشگاه {{ env('SHOP_NAME','') }}) می‌باشد.
            </p>
        </footer>
    </div>

    @yield('footer')
    <script src="{{ asset('js/ShopVue.js') }}" type="text/javascript"></script>
</body>
</html>