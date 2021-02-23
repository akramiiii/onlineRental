@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت ساعت تحویل' , 'url' => url("admin/delivery")]
        ]])
    <div class="panel">
        <div class="header">
            مدیریت ساعت تحویل
            @include('include.item_table' , ['count' => $trash_delivery_count , 'route' => 'admin/delivery' , 'title' => 'ساعت تحویل'])
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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ردیف</th>
                            <th>ساعت تحویل</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delivery as $key => $value)  
                        @php
                            $i++;
                        @endphp                   
                        <tr>
                            <td>
                                <input type="checkbox" name="delivery_id[]" value="{{ $value->id }}" id="" class="check_box">
                            </td>
                            <td>{{ $i }}</td>
                            <td>{{ $value->delivery }}</td>
                            <td>
                                @if (!$value->trashed())
                                    <a href="{{ url('admin/delivery/'.$value->id.'/edit') }}"><span  class="fa fa-edit"></span></a>
                                @endif
                                @if ($value->trashed())
                                    <span data-toggle="tooltip" data-placement="bottom" title="بازیابی ساعت تحویل" onclick="restore_row('{{ url('admin/delivery/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از بازیابی این ساعت تحویل مطمئن هستید ؟')" class="fa fa-refresh" style="cursor: pointer"></span>
                                @endif
                                @if (!$value->trashed())
                                    <span data-toggle="tooltip" data-placement="bottom" title="حذف ساعت تحویل" onclick="del_row('{{ url('admin/delivery/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این ساعت تحویل مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                                @else
                                    <span data-toggle="tooltip" data-placement="bottom" title="حذف ساعت تحویل برای همیشه" onclick="del_row('{{ url('admin/delivery/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این ساعت تحویل مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @if (sizeof($delivery) == 0)
                        <td colspan="4">رکوردی برای نمایش وجود ندارد </td>
                    @endif
                </table>
            </form>
            {{ $delivery->links() }}
        </div>
    </div>

@endsection