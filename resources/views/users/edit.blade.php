@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت کاربران','url'=>url('admin/users')],
         ['title'=>'ویرایش اطلاعات کاربر','url'=>url('admin/users/'.$user->id.'/ediy')]
    ]])

    <div class="panel">

        <div class="header">
            ویرایش اطلاعات کاربر - {{ $user->mobile }}
        </div>

        <div class="panel_content">


            {!! Form::model($user,['url' => 'admin/users/'.$user->id]) !!}

            {!! method_field('PUT') !!}
            <div class="form-group">

                {{ Form::label('name','نام و نام خانوادگی : ') }}
                {{ Form::text('name',null,['class'=>'form-control']) }}
                @if($errors->has('name'))
                    <span class="has_error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">

                {{ Form::label('username','نام کاربری (برای نقش مدیر) : ') }}
                {{ Form::text('username',null,['class'=>'form-control']) }}
                @if($errors->has('username'))
                    <span class="has_error">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="form-group">

                {{ Form::label('mobile','شماره موبایل : ') }}
                {{ Form::text('mobile',null,['class'=>'form-control']) }}
                @if($errors->has('mobile'))
                    <span class="has_error">{{ $errors->first('mobile') }}</span>
                @endif
            </div>

            <div class="form-group">

                {{ Form::label('password','کلمه عبور : ') }}
                {{ Form::password('password',['class'=>'form-control']) }}
                @if($errors->has('password'))
                    <span class="has_error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('account_status','وضعیت اکانت : ') }}
                {{ Form::select('account_status',['active'=>'فعال','Inactive'=>'غیر فعال'],null,['class'=>'selectpicker']) }}
            </div>

            <div class="form-group">
                {{ Form::label('role','نقش کاربری : ') }}
                {{ Form::select('role',$roles,null,['class'=>'selectpicker']) }}
            </div>
            <button class="btn btn-primary">ویراش اطلاعات کاربر</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
