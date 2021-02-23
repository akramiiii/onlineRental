@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت بررسی اجمالی ','url'=>url('admin/product/review?product_id='.$product->id)]]])
    <div class="panel">

        <div class="header">
            مدیریت بررسی اجمالی 
            ({{ $product->title }})
            @include('include.item_table',['count'=>$trash_review_count,'route'=>'admin/product/review','title'=>'بررسی اجمالی','queryString'=>['param'=>'product_id','value'=>$product->id]])
        </div>

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>

           {{-- <a  class="btn btn-success" href="{{ url('admin/product/review/primary?product_id='.$product->id) }}">افزودن توضیحات اولیه</a> --}}
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped" style="margin-top: 20px">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>عنوان بررسی اجمالی</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($review as $key=>$value)
                            @php $i++; @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="product/review_id[]" class="check_box" value="{{ $value->id }}"/>
                                </td>
                                <td>{{ $i}}</td>
                                <td>{{ $value->title }}</td>
                                <td>
                                    @if(!$value->trashed())
                                        <a href="{{ url('admin/product/review/'.$value->id.'/edit?product_id='.$product->id) }}"><span class="fa fa-edit"></span></a>
                                    @endif

                                    @if($value->trashed())
                                        <span  data-toggle="tooltip" data-placement="bottom"  title='بازیابی بررسی اجمالی' onclick="restore_row('{{ url('admin/product/review/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','آیا از بازیابی این بررسی اجمالی مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                    @endif

                                    @if(!$value->trashed())
                                        <span data-toggle="tooltip" data-placement="bottom"  title='حذف بررسی اجمالی' onclick="del_row('{{ url('admin/product/review/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','آیا از حذف این بررسی اجمالی مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                    @else
                                        <span data-toggle="tooltip" data-placement="bottom"  title='حذف بررسی اجمالی برای همیشه' onclick="del_row('{{ url('admin/product/review/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','آیا از حذف این بررسی اجمالی مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach

                        @if(sizeof($review)==0)
                            <tr>
                                <td colspan="4">رکوردی برای نمایش وجود ندارد</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </form>

            {{ $review->links() }}
        </div>
    </div>

@endsection
