@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت محصولات' , 'url' => url("admin/product")],
    ['title' => 'ویرایش محصول' , 'url' => url("admin/product/".$product->id."/edit")]
    ]])
    <div class="panel">
        <div class="header">ویرایش محصول - {{ $product->title }}</div>
        <div class="panel_content">
            {!! Form::model($product , ['url' => 'admin/product/'.$product->id ,'files'=>true]) !!}
            {{ method_field('PUT') }}
                <div class="form-group">
                    {{ Form::label('title','عنوان محصول : ') }}
                    {{ Form::text('title',null,['class'=>'form-control total_width_input']) }}
                    @if ($errors->has('title'))
                        <span class="has_error">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::textArea('tozihat',null,['class'=>'form-control product_tozihat ckeditor']) }}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('ename','نام انگلیسی محصول : ') }}
                            {{ Form::text('ename',null,['class'=>'form-control left']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('cat_id','انتخاب دسته : ') }}
                            {{ Form::select('cat_id' , $catList , null , ["class" => "selectpicker" , "data-live-search" => "true"]) }}
                            @if ($errors->has('cat_id'))
                                <span class="has_error">{{ $errors->first('cat_id') }}</span>
                            @endif
                        </div>
                        {{--  <div class="form-group">
                            {{ Form::label('brand_id','انتخاب برند : ') }}
                            {{ Form::select('brand_id' , $brand , null , ["class" => "selectpicker" , "data-live-search" => "true"]) }}
                            @if ($errors->has('brand_id'))
                                <span class="has_error">{{ $errors->first('brand_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>انتخاب رنگ های محصول : </label>
                            <select class="selectpicker" data-live-search="true" multiple="multiple" name="product_color[]">
                                @foreach($colors as $key=>$value)
                                    <option @if(array_key_exists($value->id,$product_color)) selected='selected' @endif value="{{ $value->id }}" data-content="<span  style='background:{{ $value->code }}; @if($value->name=='سفید') color:#000 @endif' class='color_option'>{{ $value->name }}</span>"></option>
                                @endforeach
                            </select>
                        </div>  --}}
                        <div class="form-group">
                            {{ Form::label('status','وضعیت محصول : ') }}
                            {{ Form::select('status' , $status , null , ["class" => "selectpicker" , "data-live-search" => "true"]) }}
                        </div>
                                                <div class="form-group">
                            {{ Form::label('product_number','تعداد موجودی محصول : ') }}
                            {{ Form::text('product_number' , null , ["class" => "form-control left product_number"]) }}
                            @if ($errors->has('product_number'))
                                <span class="has_error">{{ $errors->first('product_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('product_number_cart','تعداد سفارش در سبد خرید : ') }}
                            {{ Form::text('product_number_cart' , null , ["class" => "form-control left product_number_cart"]) }}
                            @if ($errors->has('product_number_cart'))
                                <span class="has_error">{{ $errors->first('product_number_cart') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('send_time','زمان آماده سازی محصول : ') }}
                            {{ Form::text('send_time' , null , ["class" => "form-control left send_time"]) }}
                            @if ($errors->has('send_time'))
                                <span class="has_error">{{ $errors->first('send_time') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="pic" id="pic" onchange="loadFile(event)" style="display:none">
                            <div class="choice_pic_box" onclick="selectFile()">
                                <span class="title">انتخاب تصویر محصول</span>
                                <img src="{{ url('files/products/'.$product->img_url) }}" id="output" class="pic_tag">
                            </div>
                            @if ($errors->has('pic'))
                                <span class="has_error">{{ $errors->first('pic') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('price1','قیمت اجاره محصول : ') }}
                            {{ Form::text('price1' , null , ["class" => "form-control left price1"]) }}
                            @if ($errors->has('price1'))
                                <span class="has_error">{{ $errors->first('price1') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('price2','قیمت محصول برای اجاره : ') }}
                            {{ Form::text('price2' , null , ["class" => "form-control left price2"]) }}
                            @if ($errors->has('price2'))
                                <span class="has_error">{{ $errors->first('price2') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('roz','تعداد روز برای اجاره : ') }}
                            {{ Form::text('roz' , null , ["class" => "form-control left roz"]) }}
                            @if ($errors->has('roz'))
                                <span class="has_error">{{ $errors->first('roz') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="message_text">برچسب ها با استفاده از (،) از هم جدا شوند</p>
                <div class="form-group">
                    <input type="text" name="tag_list" id="tag_list" class="form-control" placeholder="برچسب های محصول">
                    <div class="btn btn-success" onclick="add_tag()">افزودن</div>
                    <input value="{{ $product->keywords }}" type="hidden" name="keywords" id="keywords">
                </div>
                <div id="tag_box">
                    @php
                        $keywords = $product->keywords;
                        $e = explode(',' , $keywords);
                        $i=1;
                    @endphp
                    @if (is_array($e))
                        @foreach ($e as $key=>$value)
                            @if (!empty($value))
                                <div class="tag_div" id="tag_div_{{ $i }}">
                                    <span class="fa fa-remove" style="margin-left:5px" onclick="remove_tag({{ $i }},'{{ $value }}')"></span>
                                    {{ $value }}
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                </div>
                <div style="clear: both"></div>
                <div class="form-group">
                    {{ Form::label('description','توضیحات مختصر در مورد محصول (حداکثر 150 کاراکتر) : ',['style' => 'width:100%']) }}
                    {{ Form::textArea('description',null,['class'=>'form-control' , 'id'=>'description']) }}
                    @if ($errors->has('description'))
                        <span class="has_error">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <button class="btn btn-primary">ویرایش محصول</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection