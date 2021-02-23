@extends('layouts.order')
@section('content')
    <div class="order_header">
        <img src="{{ asset('files/images/signboard_for_rent (2).png') }}" class="shop_icon">
        <ul class="checkout_steps">
            <li>
                <a class="checkout_step">
                    <div class="step_item active_item" step-title="اطلاعات ارسال"></div>
                </a>
            </li>
            <li class="active">
                <a class="checkout_step">
                    <div class="step_item active_item" step-title="پرداخت"></div>
                </a>
            </li>
            <li class="inactive">
                <a class="checkout_step">
                    <div class="step_item" step-title="اتمام سفارش و ارسال"></div>
                </a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <div class="row headline-checkout">
            <h6>انتخاب شیوه پرداخت</h6>
        </div>
        <div class="page_row">
            <div class="page_content">

                <div class="renting_data_box payment_box" style="margin-top:0px">
                    <span class="radio_check active_radio_check"></span>
                    <span class="label">پرداخت اینترنتی (آنلاین با تمامی کارت های بانکی)</span>
                </div>

                <h6>خلاصه سفارش</h6>

                <div class="renting_data_box" style="padding-right:15px;padding-left: 15px">

                    <div class="renting_data_box" style="padding: 0px">
                        <div class="header_box">
                            <div>
                                مرسوله
                                <span>({{ number_format(\App\Cart::get_product_count()) }} کالا)</span>
                            </div>
                            <div>
                                نحوه ارسال
                                <span>عادی</span>
                            </div>
                            <div>
                                <?php
                                    $send_order_data['delivery_day']=$delivery_date;
                                ?>
                                تاریخ دریافت
                                <span>{{ $send_order_data['delivery_day'] }}</span>
                            </div>
                            <div>
                                <?php
                                    $send_order_data['delivery_time']=$delivery_time;
                                ?>
                                ساعت تحویل 
                                <span>{{ $send_order_data['delivery_time'] }}</span>
                            </div>
                            <div>
                                <?php
                                    $send_order_data['guarantee']=$pledge;
                                ?>
                                ضمانت
                                <span>{{ $send_order_data['guarantee'] }}</span>
                            </div>
                            <div>
                                هزینه ارسال
                                <span>{{ $send_order_data['normal_send_order_amount'] }} </span>
                            </div>
                        </div>
                        <div class="ordering_product_list swiper-container">
                            <div class="swiper-wrapper swiper_product_box">
                                @foreach($send_order_data['cart_product_data'] as $product)
                                    <div class="product_info_box swiper-slide">
                                        <img src="{{ url('files/thumbnails/'.$product['product_img_url']) }}">
                                        <p class="product_title">{{ $product['product_title'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                            {{--  <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>  --}}

                            <div class="swiper-pagination"></div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="page_aside">
                <div class="order_info mt-0">
                    <?php
                        $total_product_price = Session::get('total_product_price' , 0);
                        $final_price = Session::get('final_price' , 0);
                        $discount = $total_product_price - $final_price;
                    ?>
                    <ul>
                        <li>
                            <span>مبلغ کل : </span>
                            <span>({{ \App\Cart::get_product_count() }}) کالا</span>
                            <span class="left">{{ number_format($total_product_price) }} تومان</span>
                        </li>

                        @if ($discount > 0)
                            <li class="cart_discount_li">
                                <span>سود شما از این سفارش : </span>
                                <span class="left">{{ number_format($discount) }} تومان</span>
                            </li>
                        @endif

                        <li>
                            <span>هزینه ارسال</span>
                            <span class="left" id="total_send_order_price">
                                <?= $send_order_data['normal_send_order_amount'] ?>
                            </span>
                        </li>
                    </ul>
                    <div class="checkout_devider"></div>
                    <div class="checkout_content">
                        <p style="color:red">مبلغ قابل پرداخت : </p>
                        
                        <p id="final_price">{{ number_format($total_product_price-$discount+$send_order_data['integer_normal_send_order_amount']) }} تومان</p>
                    </div>
                    <a href="{{ url('order/payment') }}">
                        <div class="send_btn checkout">
                            <span class="line"></span>
                            <span class="title">پرداخت و ثبت نهایی سفارش</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}" />
@endsection
@section('footer')

    <script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>
    <script>
        
        const swiper=new Swiper('.swiper-container',{
            slidesPerView:5,
            spaceBetween:0,
            navigation:{
                nextEl:'.swiper-button-next',
                prevEl:'.swiper-button-prev'
            },
            // pagination:{
            //     el:'.swiper-pagination',
            //     clickable:true
            // }
        });
    </script>
@endsection