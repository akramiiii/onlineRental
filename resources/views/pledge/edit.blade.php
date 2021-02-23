@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت ضمانت ها' , 'url' => url("admin/pledge")],
    ['title' => 'ویرایش ضمانت' , 'url' => url("admin/pledge/".$pledge->id."/edit")]
    ]])
    <div class="panel">
        <div class="header">ویرایش نام ضمانت {{ $pledge->pledge }}</div>
        <div class="panel_content">
            {!! Form::model($pledge , ['url' => 'admin/pledge/'.$pledge->id]) !!}
            {{ method_field('PUT') }}
                <div class="form-group">
                    {{ Form::label('_name','نام ضمانت : ') }}
                    {{ Form::text('pledge',null,['class'=>'form-control']) }}
                    @if ($errors->has('pledge'))
                        <span class="has_error">{{ $errors->first('pledge') }}</span>
                    @endif
                </div>
                <button class="btn btn-primary">ویرایش</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection