@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت زمان تحویل' , 'url' => url("admin/delivery")],
        ['title' => 'افزودن زمان تحویل جدید' , 'url' => url("admin/delivery/create")],
    ]])
    <div class="panel">
        <div class="header">افزودن زمان تحویل جدید</div>
        <div class="panel_content">
            {!! Form::open(['url' => 'admin/delivery']) !!}
                <div class="form-group">
                    {{ Form::label('delivery','زمان تحویل : ') }}
                    {{ Form::text('delivery',null,['class'=>'form-control']) }}
                    @if ($errors->has('delivery'))
                        <span class="has_error">{{ $errors->first('delivery') }}</span>
                    @endif
                </div>
                <button class="btn btn-success">ثبت</button>
            {!! Form::close() !!}
        </div>
@endsection