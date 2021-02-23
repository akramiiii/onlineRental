@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت دسته ها' , 'url' => url("admin/category")],
    ['title' => 'افزودن دسته جدید' , 'url' => url("admin/category/create")]
    ]])
    <div class="panel">
        <div class="header">افزودن دسته جدید</div>
        <div class="panel_content">
            {!! Form::open(['url' => 'admin/category' ,'files'=>true]) !!}
                <div class="form-group">
                    {{ Form::label('name','نام دسته : ') }}
                    {{ Form::text('name',null,['class'=>'form-control']) }}
                    @if ($errors->has('name'))
                        <span class="has_error">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('ename','نام انگلیسی دسته : ') }}
                    {{ Form::text('ename',null,['class'=>'form-control left']) }}
                    @if ($errors->has('ename'))
                        <span class="has_error">{{ $errors->first('ename') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('search_url','url دسته : ') }}
                    {{ Form::text('search_url',null,['class'=>'form-control left']) }}
                    @if ($errors->has('search_url'))
                        <span class="has_error">{{ $errors->first('search_url') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('parent_id','انتخاب سر دسته : ') }}
                    {{ Form::select('parent_id' , $parent_cat , null , ["class" => "selectpicker" , "data-live-search" => "true"]) }}
                </div>
                <div class="form-group">
                    <input type="file" name="pic" id="pic" onchange="loadFile(event)" style="display:none">
                    {{ Form::label('pic','انتخاب تصویر  : ') }}
                    <img src="{{ url('files/images/pic1.jpg') }}" onclick="selectFile()" width="150" id="output" style="cursor: pointer">
                    @if($errors->has('pic'))
                        <span class="has_error">{{ $errors->first('pic') }}</span>
                    @endif
                </div>
                
                <div class="form-group">
                    {{ Form::label('notShow','عدم نمایش در لیست اصلی : ') }}
                    {{ Form::checkbox('notShow',false) }}
                </div>
                <button class="btn btn-success">ثبت دسته</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection