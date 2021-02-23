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
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    @yield('footer')
</body>
</html>