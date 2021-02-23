@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت کاربران','url'=>url('admin/users')],
         ['title'=>'افزودن کاربر جدید','url'=>url('admin/users/create')]
    ]])

    <div class="panel">

        <div class="header">افزودن کاربر جدید</div>

        <div class="panel_content">


            {!! Form::open(['url' => 'admin/users']) !!}

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
                <select name="account_status" class="selectpicker">
                    <option  @if(old('account_status')=='active') selected="selected" @endif value="active">فعال</option>
                    <option @if(old('account_status')=='Inactive') selected="selected" @endif value="Inactive">غیر فعال</option>
                </select>
            </div>

            <div class="form-group">
                {{ Form::label('role','نقش کاربری : ') }}
                <select name="role" class="selectpicker">
                    <option @if(old('role')=='admin') selected="selected" @endif value="admin">مدیر</option>
                    <option @if(old('role')=='user') selected="selected" @endif value="user">کاربر عادی</option>
                    @foreach ($roles as $role)
                      <option @if(old('role')==$role->id) selected="selected" @endif value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select> 
            </div>
            <button class="btn btn-success">ثبت کاربر</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
