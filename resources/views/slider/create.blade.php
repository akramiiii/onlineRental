@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت اسلایدر ها' , 'url' => url("admin/slider")],
    ['title' => 'افزودن اسلایدر جدید' , 'url' => url("admin/slider/create")]
    ]])
    <div class="panel">
        <div class="header">افزودن اسلایدر جدید</div>
        <div class="panel_content">
            {!! Form::open(['url' => 'admin/slider' ,'files'=>true]) !!}
                <div class="form-group">
                    {{ Form::label('title','عنوان : ') }}
                    {{ Form::text('title',null,['class'=>'form-control']) }}
                    @if ($errors->has('title'))
                        <span class="has_error">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('url','آدرس (url) : ') }}
                    {{ Form::text('url',null,['class'=>'form-control left total_width_inpu']) }}
                    @if ($errors->has('url'))
                        <span class="has_error">{{ $errors->first('url') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="file" name="pic" id="pic" onchange="loadFile(event)" style="display:none">
                    <div onclick="selectFile()" class="btn btn-primary">انتخاب تصویر اسلایدر</div>
                    @if($errors->has('pic'))
                        <span class="has_error">{{ $errors->first('pic') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <img onclick="selectFile()" id="output" style="cursor: pointer; margin-top: 0px;" width="150px" class="slider_img">
                </div>
                
                <button class="btn btn-success">ثبت اسلایدر</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection