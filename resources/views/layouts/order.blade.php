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
        @yield('content')
    </div>

    <div id="loading_box">
        <div class="loading_div">
            <img src="{{ asset('files/images/signboard_for_rent (2).png') }}" alt="">
            <div class="spinner">
                <div class="b1"></div>
                <div class="b2"></div>
                <div class="b3"></div>
            </div>
        </div>
    </div>

    @yield('footer')
    <script src="{{ asset('js/ShopVue.js') }}" type="text/javascript"></script>
</body>
</html>