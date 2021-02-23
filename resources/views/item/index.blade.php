@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت ویژگی ها' , 'url' => url("admin/category/".$category->id."/item")]
    ]])
        
    <div class="panel">
        <div class="header">
            مدیریت ویژگی های دسته - {{ $category->name }}
        </div>
    </div>

    <div class="panel_content mt-3">
        @include('include.alert')

        <form action="{{ url('admin/category').'/'.$category->id.'/item' }}" method="post">
            @csrf
            <div class="category_items">
                @if (sizeof($items) > 0)
                    @foreach ($items as $key=>$value)
                        <div class="form-group item_groups" id="item_{{ $value->id }}">
                            <input type="text" value="{{ $value->title }}" class="form-control item_input" name="item[{{ $value->id }}]" placeholder="نام گروه ویژگی">
                            <span class="fa fa-plus-circle" onclick="add_child_input({{ $value->id }})"></span>
                            <span class="item_remove_message" onclick="del_row('{{ url('admin/category/item/'.$value->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این ویژگی مطمئن هستید ؟')">حذف کلی آیتم های گروه {{ $value->title }}</span>
                            <div class="child_item_box">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($value->getChild as $childItem)
                                    <div class="form-group child_{{ $value->id }}">
                                        {{ $i }} - <input type="checkbox" @if($childItem->show_item==1) checked='checked' @endif name="check_box_item[{{ $value->id }}][{{ $childItem->id }}]"><input type="text" name="child_item[{{ $value->id }}][{{ $childItem->id }}]" value="{{ $childItem->title }}" class="form-control child_input_item" placeholder="نام ویژگی">
                                        <span class="child_item_remove_message" onclick="del_row('{{ url('admin/category/item/'.$childItem->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این ویژگی مطمئن هستید ؟')">حذف ویژگی</span>
                                        @php
                                            $i++;
                                        @endphp
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group item_groups" id="item_-1">
                        <input type="text" class="form-control item_input" name="item[-1]" placeholder="نام گروه ویژگی"> 
                        <span class="fa fa-plus-circle" onclick="add_child_input(-1)"></span>
                        <div class="child_item_box">
                            
                        </div>
                    </div>
                @endif
            </div>
            <div id="item_box" class="mt-3"></div>
            <span class="fa fa-plus-square" onclick="add_item_input()"></span>
            <div class="form-group">
                <button class="btn btn-primary">ثبت اطلاعات</button>

            </div>
        </form>
    </div>

@endsection

@section('footer')
    <script>
        $(document).ready(function(){
            $('.category_items').sortable();
            $('.child_item_box').sortable();
        });
    </script>
@endsection