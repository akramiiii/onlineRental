@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت اسلایدر ها' , 'url' => url("admin/slider")],
    ['title' => 'ویرایش اسلایدر' , 'url' => url("admin/slider/".$slider->id."/edit")]
    ]])
    <div class="panel">
        <div class="header">ویرایش اسلایدر - {{ $slider->title }}</div>
        <div class="panel_content">
            {!! Form::model($slider , ['url' => 'admin/slider/'.$slider->id ,'files'=>true]) !!}
            {{ method_field('PUT') }}
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
                    <img src="{{ url('files/slider/'.$slider->image_url) }}"  onclick="selectFile()" id="output" style="cursor: pointer; margin-top: 0px;" class="slide_image_edit">
                </div>
                
                <button class="btn btn-primary">ویرایش اسلایدر</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection