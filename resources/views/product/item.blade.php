@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت محصولات' , 'url' => url("admin/product")],
        ['title' => 'ثبت مشخصات فنی محصول' , 'url' => url("admin/product/".$product->id."/item")],
    ]])
    <div class="panel">
        <div class="header">
            افزودن مشخصات فنی - {{ $product->title }}
        </div>

        <div class="panel_content">
            @include('include.alert')
            @if (sizeof($product_item) > 0)
                <form id="product_item_form" action="{{ url('admin/product/'.$product->id.'/item') }}" method="post">
                    @csrf
                    @foreach ($product_item as $key=>$value)
                        <div class="item_groups" style="margin-bottom: 20px">
                            <p class="title">{{ $value->title }}</p>
                            @foreach ($value->getChild as $key2=>$value2)
                                <div class="form-group">
                                    <label>{{ $value2->title }}</label>
                                    @if (sizeof($value2->getValue) > 0)
                                        <input value="{{ $value2->getValue[0]->item_value }}" type="text" class="form-control" name="item_value[{{ $value2->id }}][]">
                                    @else
                                        <input type="text" class="form-control" name="item_value[{{ $value2->id }}][]">
                                    @endif
                                    <span class="fa fa-plus-circle" onclick="add_item_value_input({{ $value2->id }})"></span>
                                    <div class="input_item_box" id="input_item_box_{{ $value2->id }}">
                                        @if (sizeof($value2->getValue) > 1)
                                            @foreach ($value2->getValue as $item_key=>$item_value)
                                                @if ($item_key > 0)
                                                    <div class="form-group">
                                                        <label></label> 
                                                        <input type="text" name="item_value[{{ $value2->id }}][]" class="form-control" value="{{ $item_value->item_value }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button class="btn btn-success">ثبت محصول</button>
                </form>
            @else
                
            @endif
        </div>
    </div>
@endsection