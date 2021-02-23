@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت ضمانت ها' , 'url' => url("admin/pledge")],
        ['title' => 'افزودن ضمانت جدید' , 'url' => url("admin/pledge/create")],
    ]])
    <div class="panel">
        <div class="header">افزودن ضمانت جدید</div>
        <div class="panel_content">
            {!! Form::open(['url' => 'admin/pledge']) !!}
                <div class="form-group">
                    {{ Form::label('pledge','نام ضمانت : ') }}
                    {{ Form::text('pledge',null,['class'=>'form-control left']) }}
                    @if ($errors->has('pledge'))
                        <span class="has_error">{{ $errors->first('pledge') }}</span>
                    @endif
                </div>
                <button class="btn btn-success">ثبت</button>
            {!! Form::close() !!}
        </div>
@endsection