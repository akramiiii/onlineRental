<?php
    use App\Lib\Jdf;
    $jdf=new Jdf();
?>
<table class="table product_list_table">
    <thead>
        <tr>
            <th>#</th>
            <th>شماره سفارش</th>
            <th>تاریخ ثبت سفارش</th>
            <th>مبلغ قابل پرداخت</th>
            <th>عملیات پرداخت</th>
            <th>جزییات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $key=>$value)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $value->order_id }}</td>
                <td>{{ $jdf->jdate('j F Y',$value->created_at)  }}</td>
                <td>{{ number_format($value->price) }} تومان</td>
                <td>
                    @if($value['pay_status']=='awaiting_payemnt')
                        در انتظار پرداخت
                    @elseif($value['pay_status']=='ok')
                        پرداخت شده
                    @elseif($value['pay_status']=='canceled')
                        لغو شده
                    @else
                        خطا در اتصال به درگاه
                    @endif
                </td>
                <td>
                    <a href="{{ url('user/profile/orders/'.$value->id) }}">
                        <span class="fa fa-angle-left"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>