@extends('layouts.admin')
@section('content')
@include('include.breadcrumb' , ['data' => [
    ['title' => 'مدیریت ساعت تحویل' , 'url' => url("admin/delivery")],
    ['title' => 'ویرایش ساعت تحویل' , 'url' => url("admin/delivery/".$delivery->id."/edit")]
    ]])
    <div class="panel">
        <div class="header">ویرایش ساعت تحویل {{ $delivery->delivery }}</div>
        <div class="panel_content">
            {!! Form::model($delivery , ['url' => 'admin/delivery/'.$delivery->id]) !!}
            {{ method_field('PUT') }}
                <div class="form-group">
                    {{ Form::label('_name','ساعت تحویل : ') }}
                    {{ Form::text('delivery',null,['class'=>'form-control']) }}
                    @if ($errors->has('delivery'))
                        <span class="has_error">{{ $errors->first('delivery') }}</span>
                    @endif
                </div>
                <button class="btn btn-primary">ویرایش</button>
            </form>
            {!! Form::close() !!}
        </div>
    </div>
@endsection