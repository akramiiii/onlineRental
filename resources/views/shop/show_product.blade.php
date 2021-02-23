@extends('layouts.shop')

@section('content')
    <form action="{{ url('cart') }}" method="post" id="add_cart_form">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="product_info">
            <div class="product_image_box">
                @if ($product->offers == 1)
                    <offer-time id="offer_box" second="{{ $product->offers_last_time-time() }}"></offer-time> 
                @endif
                <div>
                    @if (!empty($product->img_url))
                        <div class="default_product_pic">
                            <img src="{{ url('files/products/'.$product->img_url) }}" />
                        </div>
                    @endif
                </div>
            </div>
            <div class="product_data">
                <div class="product_headline">
                    <h6 class="product_title">
                        {{ $product->title }}
                        @if (!empty($product->ename) && $product->ename!='null')
                            <span>{{ $product->ename }}</span>
                        @endif
                    </h6>
                </div>
                <div>
                    <ul class="list-inline product_data_ul">
                        <li>
                            <span>دسته بندی : </span>
                            <a href="{{ url('search/'.$product->getCat->url) }}" class="data-link">
                                <span>{{ $product->getCat->name }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="row">
                        <div class="col-8">
                            <div style="display: inline-flex;width: 100%">
                                <div>
                                    @if($product->offers==1)
                                        <del>{{ number_format($product->price1) }}</del>
                                        <p class="final_product_price">
                                            <span class="rozane">قیمت روزانه : </span>
                                            {{ number_format($product->price2) . ' تومان'}}
                                        </p>
                                    @elseif($product->offers == 0)
                                        <p class="final_product_price">
                                            <span class="rozane">قیمت روزانه : </span>
                                            {{ number_format($product->price1) . ' تومان'}}
                                        </p>
                                    @endif
                                </div>
                                @if ($product->offers==1)
                                    <div class="product_discount" data-title="تخفیف">
                                        <?php
                                            $d = ($product->price2/$product->price1)*100;
                                            $d = 100 - $d;
                                            $d = round($d);
                                        ?>
                                        ٪{{ $d }}
                                    </div>
                                @endif
                            </div>
                            {{--  <roz @if($product->offers==1) price1="{{ $product->price2 }}" @elseif($product->offers == 0) price1="{{ $product->price1 }}" @endif></roz>  --}}
                            <div class="send_btn" id="cart_btn">
                                <span class="line"></span>
                                <span class="title">افزودن به سبد</span>
                                <login-box></login-box>

                            </div>
                        </div>
                        <div class="col-4">
                            @include('include.show_important_item')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('include.horizontal_product_list' , ['title' => 'محصولات مرتبط' , 'products' => $relate_products])

    <div id="tab_div">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a href="#review" class="nav-link active" data-toggle="tab" role="tab" aria-selected="true">
                    <span class="fa fa-camera-retro"></span>
                    <span>بررسی اجمالی</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#product_items" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">
                    <span class="fa fa-list-ul"></span>
                    <span>مشخصات</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#comments" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">
                    <span class="fa fa-comment-o"></span>
                    <span>نظرات کاربران</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="home-tab">

            </div>
            <div class="tab-pane fade" id="product_items" role="tabpanel" aria-labelledby="home-tab">
                @include('include.product_item')
            </div>
            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="home-tab">

            </div>
        </div>
    </div>

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('slick/slick.js') }}"></script>
    <script>
        $('.product_list').slick({
            speed:900,
            slidesToShow:4,
            slidesToScroll:3,
            rtl:true,
            infinite:false
        }); 
        // window.onload=function(){
        //     const pcal = new AMIB.persianCalendar('pcal');
        // }
    </script>
@endsection