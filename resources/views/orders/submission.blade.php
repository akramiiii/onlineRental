@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>$label,'url'=>url('admin/orders/'.$label_url)]]])
    <div class="panel">

        <div class="header">
          {{ $label }}
        </div>

        <div class="panel_content">

            @include('include.Alert')


            <form method="get" class="search_form">

                <input type="text" name="submission_id" class="form-control" value="{{ $req->get('submission_id','') }}" placeholder="شماره مرسوله"><button class="btn btn-primary">جست و جو</button>
            </form>

            <?php
            $OrderStatus=\App\Order::OrderStatus();
            ?>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>کد مرسوله</th>
                    <th>تاریخ ثبت</th>
                    {{-- <th>تاریخ تحویل به مشتری</th>
                    <th>ساعت تحویل به مشتری</th>
                    <th>مدرک تحویلی از مشتری</th> --}}
                    <th>تعداد کالا</th>
                    <th>وضعیت مرسوله</th>
                    <th>عمیات</th>
                </tr>
                </thead>
                <tbody>
                <?php use App\Lib\Jdf;$jdf=new Jdf(); $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>
                @foreach($submission as $key=>$value)
                    @php $i++; $e=explode(' ',$value->created_at); $e2=explode('-',$e[0])  @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $value->id }}</td>
                        <td>{{ $jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-') }}</td>
                        {{-- <td>{{ $value->delivery_day }}</td>
                        <td>{{ $value->delivery_time }}</td>
                        <td>{{ $value->guarantee }}</td> --}}
                        <td>{{  getOrderProductCount($value->products_id) }}</td>
                        <td>
                            @if(array_key_exists($value->send_status,$OrderStatus))
                                {{ $OrderStatus[$value->send_status] }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/orders/submission/'.$value->id) }}">
                                <span class="fa fa-eye" data-toggle="tooltip" data-placement="bottom"  title='جزییات مرسوله' ></span>
                            </a>

                        </td>
                    </tr>

                @endforeach

                @if(sizeof($submission)==0)
                    <tr>
                        <td colspan="6">رکوردی برای نمایش وجود ندارد</td>
                    </tr>
                @endif
                </tbody>
            </table>

            {{ $submission->links() }}
        </div>

    </div>
@endsection
