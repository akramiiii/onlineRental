@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت سفارشات','url'=>url('admin/orders')]]])
    <div class="panel">

        <div class="header">
            مدیریت سفارشات

            @include('include.item_table',['count'=>$trash_orders_count,'route'=>'admin/orders','title'=>'سفارش'])
        </div>

        <div class="panel_content">

            <?php
                use App\Lib\Jdf;
                $jdf=new Jdf(); 
            ?>
            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0; ?>


            <form method="get" class="search_form order_search">
               @if(isset($_GET['trashed']) && $_GET['trashed']==true)
                   <input type="hidden" name="trashed" value="true">
               @endif
               <input type="text" autocomplete="off" name="order_id" class="form-control" value="{{ $req->get('order_id','') }}" placeholder="شماره سفارش">
               <input type="text" autocomplete="off" name="first_date" style="margin-right: 10px" class="pdate form-control" id="pcal1" value="{{ $req->get('first_date','') }}" placeholder="شروع از تاریخ">
               <input type="text" autocomplete="off" name="end_date" style="margin: 0px 10px" class="pdate form-control" id="pcal2" value="{{ $req->get('end_date','') }}" placeholder="تا تاریخ">
               <button class="btn btn-primary">جست و جو</button>
            </form>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
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
                                <td>
                                    <input type="checkbox" name="category_id[]" class="check_box" value="{{ $value->id }}"/>
                                </td>
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
                                        <span class="alert alert-danger"  style="padding: 5px 10px;border-radius:0px;">خطا در اتصال به درگاه</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$value->trashed())
                                        <a href="{{ url('admin/orders/'.$value->id) }}"><span class="fa fa-eye"></span></a>
                                    @endif

                                    @if($value->trashed())
                                        <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='بازیابی سفارش' onclick="restore_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این سفارش مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                    @endif

                                    @if(!$value->trashed())
                                        <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف سفارش' onclick="del_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این سفارش مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                    @else
                                        <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف سفارش برای همیشه' onclick="del_row('{{ url('admin/orders/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این سفارش مطمئن هستین ؟ ')" class="fa fa-remove"></span>
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
            </form>

            {{ $orders->links() }}
        </div>
    </div>

@endsection
@section('head')
    <link href="{{ asset('css/js-persian-cal.css') }}" rel="stylesheet">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/js-persian-cal.min.js') }}"></script>
    <script>
        const pcal1= new AMIB.persianCalendar('pcal1');
        const pcal2= new AMIB.persianCalendar('pcal2');
    </script>
@endsection
