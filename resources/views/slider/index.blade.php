@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت اسلایدر ها' , 'url' => url("admin/slider")]
        ]])
    <div class="panel">
        <div class="header">
            مدیریت اسلایدر ها
            @include('include.item_table' , ['count' => $trash_slider_count , 'route' => 'admin/slider' , 'title' => 'اسلایدر'])
        </div>
        <div class="panel_content">
            @include('include.alert')
            @php
                $i = (isset($_GET['page'])) ? (($_GET['page']-1)*10) : 0;
            @endphp
            <form action="" method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>تصویر</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slider as $key => $value)  
                    @php
                        $i++;
                    @endphp                   
                    <tr>
                        <td>
                            <input type="checkbox" name="slider_id[]" value="{{ $value->id }}" id="" class="check_box">
                        </td>
                        <td>{{ $i }}</td>
                        <td>{{ $value->title }}</td>
                        <td>
                            <img src="{{ url("files/slider/".$value->image_url) }}" class="slide_image">                     
                        </td>
                        <td>
                            @if (!$value->trashed())
                                <a href="{{ url('admin/slider/'.$value->id.'/edit') }}"><span  class="fa fa-edit"></span></a>
                            @endif
                            @if ($value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="بازیابی اسلایدر" onclick="restore_row('{{ url('admin/slider/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از بازیابی این اسلایدر مطمئن هستید ؟')" class="fa fa-refresh" style="cursor: pointer"></span>
                            @endif
                            @if (!$value->trashed())
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف اسلایدر" onclick="del_row('{{ url('admin/slider/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این اسلایدر مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @else
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف اسلایدر برای همیشه" onclick="del_row('{{ url('admin/slider/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این اسلایدر مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if (sizeof($slider) == 0)
                    <td colspan="5">رکوردی برای نمایش وجود ندارد </td>
                @endif
            </table>
            </form>
            {{ $slider->links() }}
        </div>
    </div>

@endsection