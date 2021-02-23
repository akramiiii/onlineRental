@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت استان ها' , 'url' => url("admin/province")],
    ['title' => 'ویرایش استان' , 'url' => url("admin/province/".$province->id."/edit")]
    ]])
    <div class="panel">
        <div class="header">ویرایش نام استان {{ $province->name }}</div>
        <div class="panel_content">
            {!! Form::model($province , ['url' => 'admin/province/'.$province->id]) !!}
            {{ method_field('PUT') }}
                <div class="form-group">
                    {{ Form::label('_name','نام استان : ') }}
                    {{ Form::text('name',null,['class'=>'form-control']) }}
                    @if ($errors->has('name'))
                        <span class="has_error">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button class="btn btn-primary">ویرایش</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection