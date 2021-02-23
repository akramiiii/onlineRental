<?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>
<?php use App\Lib\Jdf;$jdf=new Jdf(); ?>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        @if(!isset($remove_delete_link)) <th>#</th> @endif
        <th>ردیف</th>
        <th>شماره سفارش</th>
        <th>زمان ثبت</th>
        <th>مبلغ سفارش</th>
        <th>وضعیت سفارش</th>
        <th>عمیات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $key=>$value)
        @php $i++; @endphp
        <tr>
            @if(!isset($remove_delete_link))
                <td>
                    <input type="checkbox" name="category_id[]" class="check_box" value="{{ $value->id }}"/>
                </td>
            @endif
            <td>{{ $i }}</td>
            <td>
                <span @if($value->order_read=='no') style="color: red" @endif>
                    {{ $value->order_id }}
                </span>
            </td>

            <td>
                {{ $jdf->jdate('H:i:s',$value->created_at)  }} / {{  $jdf->jdate('Y-n-j',$value->created_at) }}
            </td>
            <td>
                <span class="alert alert-primary" style="padding: 5px 10px;border-radius:0px;">
                    {{ number_format($value['price']) }} تومان
                </span>
            </td>
            <td>
                @if($value['pay_status']=='awaiting_payemnt')
                    <span class="alert alert-warning" style="padding: 5px 10px;border-radius:0px;">در انتظار پرداخت</span>
                @elseif($value['pay_status']=='ok')
                    <span  class="alert alert-success"  style="padding: 5px 10px;border-radius:0px;">پرداخت شده</span>
                @elseif($value['pay_status']=='canceled')
                    <span  class="alert alert-warning"  style="padding: 5px 10px;border-radius:0px;">لغو شده</span>
                @else
                    <span  class="alert alert-danger"  style="padding: 5px 10px;border-radius:0px;">خطا در اتصال به درگاه</span>
                @endif
            </td>
           <td>
                @if(!$value->trashed())
                    <a href="{{ url('admin/orders/'.$value->id) }}"><span class="fa fa-eye"></span></a>
                @endif

                @if(!isset($remove_delete_link))
                   @if($value->trashed())
                     <span  data-toggle="tooltip" data-placement="bottom"  title='بازیابی سفارش' onclick="restore_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این سفارش مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                   @endif

                  @if(!$value->trashed())
                     <span data-toggle="tooltip" data-placement="bottom"  title='حذف سفارش' onclick="del_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این سفارش مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                  @else
                     <span data-toggle="tooltip" data-placement="bottom"  title='حذف سفارش برای همیشه' onclick="del_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این سفارش مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                  @endif
                @endif
                
            </td>
        </tr>

    @endforeach

    @if(sizeof($orders)==0)
        <tr>
            <td colspan="7">رکوردی برای نمایش وجود ندارد</td>
        </tr>
    @endif
    </tbody>
</table>