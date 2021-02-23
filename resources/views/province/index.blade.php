@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت استان ها' , 'url' => url("admin/province")]
        ]])
    <div class="panel">
        <div class="header">
            مدیریت استان ها
            @include('include.item_table' , ['count' => $trash_province_count , 'route' => 'admin/province' , 'title' => 'استان'])
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
                        <th>نام استان</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($province as $key => $value)  
                    @php
                        $i++;
                    @endphp                   
                    <tr>
                        <td>
                            <input type="checkbox" name="province_id[]" value="{{ $value->id }}" id="" class="check_box">
                        </td>
                        <td>{{ $i }}</td>
                        <td>{{ $value->name }}</td>
                        <td>
                            @if (!$value->trashed())
                                <a href="{{ url('admin/province/'.$value->id.'/edit') }}"><span  class="fa fa-edit"></span></a>
                            @endif
                            @if ($value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="بازیابی استان" onclick="restore_row('{{ url('admin/province/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از بازیابی این استان مطمئن هستید ؟')" class="fa fa-refresh" style="cursor: pointer"></span>
                            @endif
                            @if (!$value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف استان" onclick="del_row('{{ url('admin/province/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این استان مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @else
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف استان برای همیشه" onclick="del_row('{{ url('admin/province/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این استان مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if (sizeof($province) == 0)
                    <td colspan="4">رکوردی برای نمایش وجود ندارد </td>
                @endif
            </table>
            </form>
            {{ $province->links() }}
        </div>
    </div>

@endsection