@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت دسته ها' , 'url' => url("admin/category")]
        ]])
    <div class="panel">
        <div class="header">
            مدیریت دسته ها
            @include('include.item_table' , ['count' => $trash_cat_count , 'route' => 'admin/category' , 'title' => 'دسته'])
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
                <input type="text" name="string" value="{{ $request->get('string' , '') }}" class="form-control" placeholder="کلمه مورد نظر ...">
                <button class="btn btn-primary">جستجو</button>
            </form>
            <form action="" method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام دسته</th>
                        <th>دسته والد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $key => $value)  
                    @php
                        $i++;
                    @endphp                   
                    <tr id="{{ $value->id }}">
                        <td>
                            <input type="checkbox" name="category_id[]" value="{{ $value->id }}" id="" class="check_box">
                        </td>
                        <td>{{ $i }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->getparent->name }}</td>
                        <td>
                            @if (!$value->trashed())
                                <a href="{{ url('admin/category/'.$value->id.'/edit') }}"><span  class="fa fa-edit"></span></a>
                            @endif
                            @if ($value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="بازیابی دسته" onclick="restore_row('{{ url('admin/category/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از بازیابی این دسته مطمئن هستید ؟')" class="fa fa-refresh" style="cursor: pointer"></span>
                            @endif
                            @if (!$value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف دسته" onclick="del_row('{{ url('admin/category/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این دسته مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @else
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف دسته برای همیشه" onclick="del_row('{{ url('admin/category/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این دسته مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if (sizeof($category) == 0)
                    <td colspan="6">رکوردی برای نمایش وجود ندارد </td>
                @endif
            </table>
            </form>
            {{ $category->links() }}
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
                    "name":"ثبت لیست مشخصات فنی",
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
            const url='category/'+id+'/item';
            window.open(url, '_blank');
        }
    </script>
@endsection