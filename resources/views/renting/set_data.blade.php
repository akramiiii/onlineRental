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
            <li class="inactive">
                <a class="checkout_step">
                    <div class="step_item" step-title="پرداخت"></div>
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
        <div class="page_row">
            <div class="page_content">
                <div class="row headline-checkout">
                    <h6>انتخاب اطلاعات ارسال : </h6>
                </div>
                <div class="renting_data_box mb-0 mt-0">
                    <form action="{{ url('payment') }}" id="add_order" method="post">
                        @csrf
                        <input type="hidden" id="address_id" name="address_id">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="account_title mr-1" style="font-size:14px;">نوع ضمانت</div>
                                    <label class="input_label" id="pledge">
                                        <select name="pledges" class="selectpicker" id="pledge_id">
                                            <option value="">انتخاب ضمانت</option>
                                            @foreach ($pledges as $pledge)
                                                <option name="pledges" id="pledges">{{ $pledge->pledge }}</option>
                                            @endforeach
                                        </select>
                                        <label id="pledges_error_message" class="feedback-hint" @if($errors->has('pledges')) style="display:block" @endif>
                                            @if($errors->has('pledges'))
                                                <span>{{ $errors->first('pledges') }}</span>
                                            @endif
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="account_title mr-1" style="font-size:14px;margin-bottom:9.5px">تاریخ دریافت</div>
                                    <input readonly placeholder="تاریخ دریافت" class="form-control text-center @if($errors->has('date')) validate_error_border @endif" style="width: 300px" type="text" id="input1" name="date" value="{{ old('date') }}"/>
                                    <label id="date_error_message" class="feedback-hint" @if($errors->has('date')) style="display:block" @endif>
                                        @if($errors->has('date'))
                                            <span>{{ $errors->first('date') }}</span>
                                        @endif
                                    </label>
                                    <span id="span1"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="account_title mr-1" style="font-size:14px;">ساعت تحویل</div>
                                    <label class="input_label" id="delivery">
                                        <select name="delivery" class="selectpicker" id="delivery_id">
                                            <option value="">ساعت تحویل</option>
                                            @foreach ($delivery as $deliver)
                                                <option id="delivery">{{ $deliver->delivery }}</option>
                                            @endforeach
                                        </select>
                                        <label id="delivery_error_message" class="feedback-hint" @if($errors->has('delivery')) style="display:block" @endif>
                                            @if($errors->has('delivery'))
                                                <span>{{ $errors->first('delivery') }}</span>
                                            @endif
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>                      
                    </form>
                </div>
                <div class="row headline-checkout">
                    <h6>انتخاب آدرس تحویل سفارش</h6>
                </div>
                <address-list :data="{{ json_encode($address) }}"></address-list>
            </div>
            <div class="page_aside mt-5">
                <div class="order_info mt-4">
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
                            <span>هزینه ارسال : </span>
                            <span class="left" id="total_send_order_price">رایگان</span>
                        </li> 
                    </ul>
                    <div class="checkout_devider"></div>
                    <div class="checkout_content">
                        <p style="color:red">مبلغ قابل پرداخت</p>
                        <p id="final_price">{{ number_format($final_price) }} تومان</p>
                    </div>
                    <a class="continue_order_registration">
                        <div class="send_btn checkout">
                            <span class="line"></span>
                            <span class="title">ادامه ثبت سفارش</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('persianDatepicker/css/persianDatepicker-default.css') }}"/>
@endsection

@section('footer')
    {{--  <script type="text/javascript" src="{{ asset('persianDatepicker/js/jquery-1.10.1.min.js') }}"></script>  --}}
    <script type="text/javascript" src="{{ asset('persianDatepicker/js/persianDatepicker.min.js') }}"></script>
    <script>
        $(function() {
            var p = new persianDate();
            $("#input1, #span1").persianDatepicker({
                startDate: p.now().addDay(1).toString("YYYY/MM/DD"),
                endDate: "1410/1/1",
                prevArrow: '›',
                nextArrow: '‹',
                cellWidth: 43, // by px
                cellHeight: 30, // by px
                fontSize: 16, // by px
            });       
        });
    </script>
@endsection