@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
           ['title'=>'مدیریت سفارشات','url'=>url('admin/orders')],
           ['title'=>'جزییات سفارش','url'=>url('admin/orders/'.$order->id)],
         ]])
    <div class="panel">

        <div class="header">
            <span>جزییات سفارش  - {{ $order->order_id }}</span>
        </div>

        @php 
            use App\Lib\Jdf;
            use App\Order;$Jdf=new Jdf(); 
            $OrderStatus=Order::OrderStatus(); 
        @endphp
        <table class="table table-bordered order_table_info">

            <tr>
                <td>
                    تحویل گیرنده:
                    <span>{{ $order->getAddress->name }}</span>
                </td>
                <td>
                    شماره تماس تحویل گیرنده:
                    <span>{{ $order->getAddress->mobile }}</span>
                </td>
            </tr>

            <tr>
                <td>
                    آدرس تحویل گیرنده:
                    <span>{{ $order->getAddress->getProvince->name.' - '. $order->getAddress->getCity->name.' - '. $order->getAddress->address }}</span>
                </td>
                <td>
                    تعداد مرسوله:
                    <span>{{ sizeof($order->getOrderInfo) }}</span>
                </td>
            </tr>

            <tr>
                <td>
                    روز دریافت مرسوله:
                    <span>{{ $order_info->delivery_day }}</span>
                </td>
                <td>
                    ساعت دریافت مرسوله:
                    <span>{{ $order_info->delivery_time }}</span>
                </td>
            </tr>

            <tr>
                <td>
                    نوع ضمانت:
                    <span>{{ $order_info->guarantee }}</span>
                </td>
                <td>
                    مبلغ کل :
                    <span>{{ number_format($order->total_price) }} تومان</span>
                </td>
            </tr>

        </table>
        @foreach($order->getOrderInfo as $key=>$value)
            <div class="order_info_div">

                <div class="header">
                    {{ \App\Order::getOrderStatus($value['send_status'],$OrderStatus) }}
                </div>


                <order-step :steps="{{ json_encode($OrderStatus) }}" :send_status="{{ $value['send_status'] }}" :order_id="{{ $value->id }}"></order-step>

                @if($value['send_status']==0 &&  $order->pay_status=='ok') @php $value['send_status']=1 @endphp @endif

                <table class="table table-bordered order_table_info">
                    <tr>
                        <td>
                            کد مرسوله:
                            <span>{{ $value['id']  }}</span>
                        </td>
                        <td>
                            نحوه ارسال:
                            <span>عادی</span>
                        </td>
                    </tr>

                    <tr>  
                        <td>
                            هزینه ارسال:
                            <span>
                                @if($value['send_order_amount']==0)
                                    رایگان
                                @else
                                    {{ number_format($value['send_order_amount']) }} تومان
                                @endif
                            </span>
                        </td>
                        <td>
                            مبلغ این مرسوله:
                            <span>{{ number_format($order->total_price-$value['send_order_amount']) }} تومان</span>
                        </td>
                    </tr>
                </table>

                <table class="table product_list_data">
                    <tr>
                        <th>نام کالا</th>
                        <th>تعداد</th>
                        <th>روز</th>
                        <th>قیمت واحد</th>
                        <th>قیمت کل</th>
                        <th>تخفیف</th>
                        <th>قیمت نهایی</th>
                    </tr>
                    @foreach($order_data['row_data'][$value->id] as $product)
                        <tr>
                            <td class="product__info">
                                <div>
                                    <img src="{{ url('files/thumbnails/'.$product['img_url']) }}" />
                                    <ul>
                                        <li class="title">
                                            {{ $product['title'] }}
                                        </li>
                                    </ul>
                                </div>
                            </td> 
                            <td>
                                {{ $product['product_count'] }}
                            </td>
                            <td>
                                {{ $product['product_roz'] }}
                            </td>
                            <td>
                                {{ number_format($product['product_price1']/$product['product_count']/$product['product_roz']) }} تومان
                            </td>
                            <td>
                                {{ number_format($product['product_price1']) }} تومان
                            </td>
                            <td>
                                <?php
                                    if($product['offers'] == 1){
                                        $discount=(($product['product_price1'])-($product['product_price2']));
                                    }
                                    else{
                                        $discount=0;
                                    }
                                ?>
                                @if ($discount==0)
                                    بدون تخفیف
                                @elseif($discount!=0)
                                    {{ number_format($discount) }} تومان
                                @endif
                            </td>
                            <td>
                                {{ number_format($product['product_price1'] - $discount) }} تومان

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}" />
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>
    <script>
        $("#sidebarToggle").click();
        const swiper=new Swiper('.swiper-container',{
            slidesPerView:5,
            spaceBetween:0,
            navigation:{
                nextEl:'.swiper-button-next',
                prevEl:'.swiper-button-prev'
            }
        });
    </script>
@endsection
