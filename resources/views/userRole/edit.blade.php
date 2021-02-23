@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
         ['title'=>'ویرایش نقش کاربری','url'=>url('admin/userRole/'.$userRole->id.'/edit')]
    ]])

    <div class="panel">

        <div class="header">ویرایش نقش کاربری - {{ $userRole->name }}</div>

        <div class="panel_content">


            {!! Form::model($userRole,['url' => 'admin/userRole/'.$userRole->id]) !!}

            {{ method_field('put') }}
            <div class="form-group">

                {{ Form::label('name','نام نقش کاربری : ') }}
                {{ Form::text('name',null,['class'=>'form-control']) }}
                @if($errors->has('name'))
                    <span class="has_error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <button class="btn btn-primary">ویرایش</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
