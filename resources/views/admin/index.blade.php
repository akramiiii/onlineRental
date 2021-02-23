
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="header">
                    مرسوله ها
                </div>
                <div class="panel_content submission_box">
                    <table class="table">
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step1.svg') }}" style="width: 60px">
                                کل مرسوله ها
                            </td>
                            <td>
                                {{ $submissions }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step1.svg') }}" style="width: 60px">
                                مرسوله های تایید شده
                            </td>
                            <td>
                                {{ $submissions_approved }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step2.svg') }}" style="width: 60px">
                                مرسوله های آماده ارسال
                            </td>
                            <td>
                                {{ $submissions_ready }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step3.svg') }}" style="width: 60px">
                                مرسوله های ارسال شده 
                            </td>
                            <td>
                                {{ $posting_send }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step4.svg') }}" style="width: 60px">
                                مرسوله های تحویل داده شده
                            </td>
                            <td>
                                {{ $delivered }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ url('files/images/step5.svg') }}" style="width: 60px">
                                مرسوله های برگشت داده شده
                            </td>
                            <td>
                                {{ $returned }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel">
                <div class="header">
                    اطلاعات کلی
                </div>
                <div class="panel_content submission_box shop_info">
                    <table class="table">
                        <tr>
                            <td>
                                <a href="{{ url('admin/users') }}" target="_blank">
                                <span class="fa fa-user-o"></span>
                                کاربران سایت
                                </a>
                            </td>
                            <td>
                                <span class="count_span user">{{ $user_count }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ url('admin/orders') }}" target="_blank">
                                <span class="fa fa-list"></span>
                                سفارشات ثبت شده
                                </a>
                            </td>
                            <td>
                                <span class="count_span order">{{ $order_count }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ url('admin/product') }}" target="_blank">
                                    <span class="fa fa-shopping-cart"></span>
                                    محصولات ثبت شده
                                </a>
                            </td>
                            <td>
                                <span class="count_span product">{{ $product_count }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top:30px">
        <div class="panel">
            <div class="header">
                آخرین سفارشات ثبت شده
            </div>
            <div class="panel_content">
                @include('include.orderList',['orders'=>$last_orders,'remove_delete_link'=>true])
            </div>
        </div>
    </div>
@endsection