@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
         ['title'=>'افزودن نقش کاربری جدید','url'=>url('admin/userRole/create')]
    ]])
    <div class="panel">
        <div class="header">افزودن نقش کاربری جدید</div>

        <div class="panel_content">

            {!! Form::open(['url' => 'admin/userRole']) !!}

            <div class="form-group">

                {{ Form::label('name','نام نقش کاربری : ') }}
                {{ Form::text('name',null,['class'=>'form-control']) }}
                @if($errors->has('name'))
                    <span class="has_error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <button class="btn btn-success">ثبت</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
