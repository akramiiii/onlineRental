@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت محصولات' , 'url' => url("admin/product")]
    ]])
        
    <div class="panel">
        <div class="header">
            مدیریت محصولات
            @include('include.item_table' , ['count' => $trash_product_count , 'route' => 'admin/product' , 'title' => 'محصول'])
        </div>

        <div class="panel_content">
            @include('include.alert')
            @php
                $i = (isset($_GET['page'])) ? (($_GET['page']-1)*10) : 0;
            @endphp
            <form class="search_form" method="get">
                @if (isset($_GET['trashed']) && $_GET['trashed'] == true)
                    <input type="hidden" name="trashed" value="true">
                @endif
                <input type="text" name="string" value="{{ $request->get('string' , '') }}" class="form_control" placeholder="کلمه مورد نظر ...">
                <button class="btn btn-primary">جستجو</button>
            </form>
            <form action="" method="post" id="data_form">
                @csrf
                <?php
                use App\Product;
                $status = Product::ProductStatus(); 
                ?>
                <table class="table table-bordered table-striped"  id="product_price1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>قیمت اجاره محصول</th>
                        <th>قیمت محصول برای اجاره</th>
                        <th>تعداد موجودی محصول</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product as $key => $value)  
                    @php
                        $i++;
                    @endphp                   
                    <tr id="{{ $value->id }}">
                        <td>
                            <input type="checkbox" name="product_id[]" value="{{ $value->id }}" id="" class="check_box">
                        </td>
                        <td>{{ $i }}</td>
                        <td><img src="{{ url('files/thumbnails/'.$value->img_url) }}" class="product_pic"></td>
                        <td>{{ $value->title }}</td>
                        <td style="min-width: 160px"><span class="alert alert-warning">{{ number_format($value->price1).' تومان' }}</span></td>
                        <td style="min-width: 160px"><span class="alert alert-success">{{ number_format($value->price2).' تومان' }}</span></td>
                        <td>{{ $value->product_number }}</td>
                        <td style="width: 120px">
                            @if (array_key_exists($value->status , $status))
                                <span class="alert @if ($value->status == 1) alert-success @elseif ($value->status == 0) alert-warning @endif" style="font-size: 13px;padding: 5px 7px">
                                    {{ $status[$value->status] }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if (!$value->trashed())
                                <a href="{{ url('admin/product/'.$value->id.'/edit') }}"><span  class="fa fa-edit"></span></a>
                            @endif
                            @if ($value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="بازیابی محصول" onclick="restore_row('{{ url('admin/product/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از بازیابی این محصول مطمئن هستید ؟')" class="fa fa-refresh" style="cursor: pointer"></span>
                            @endif
                            @if (!$value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف محصول" onclick="del_row('{{ url('admin/product/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این محصول مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @else
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف محصول برای همیشه" onclick="del_row('{{ url('admin/product/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این محصول مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if (sizeof($product) == 0)
                    <td colspan="9">رکوردی برای نمایش وجود ندارد </td>
                @endif
            </table>
            </form>
            {{ $product->links() }}
        </div>
    </div>

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/contextmenu.css') }}">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ url('js/contextmenu.js') }}"></script>
    <script>
        let id=4;
        var menu= new Contextmenu({
            name:"menu",
            wrapper:".table",
            trigger: "tbody tr",
            item:[
                {
                    "name":"ثبت مشخصات فنی",
                    "func":"setItem()",
                    "disable":false
                },
            ],
            target:"_blank",
            beforeFunc: function (ele) {
                id = $(ele).attr('id');
            }
        });
        function setItem() {
            const url='product/'+id+'/item';
            window.open(url, '_blank');
        }
    </script>
@endsection