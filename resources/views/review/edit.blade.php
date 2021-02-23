@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت بررسی اجمالی ها','url'=>url('admin/product/review?product_id='.$product->id)],
         ['title'=>'ویرایش بررسی اجمالی جدید','url'=>url('admin/product/review/'.$review->id.'/edit?product_id='.$product->id)]
    ]])
    <div class="panel">

        <div class="header">
            ویرایش بررسی اجمالی جدید برای {{ $product->title }}
        </div>

        <div class="panel_content">
            {!! Form::model($review,['url' => 'admin/product/review/'.$review->id.'?product_id='.$product->id]) !!}

            {{ method_field('PUT') }}
            <div class="form-group">

                {{ Form::label('title','عنوان  : ') }}
                {{ Form::text('title',null,['class'=>'form-control total_width_input']) }}
                @if($errors->has('title'))
                    <span class="has_error">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group">

                {{ Form::textarea('tozihat',null,['class'=>'form-control ckeditor']) }}
                @if($errors->has('tozihat'))
                    <span class="has_error">{{ $errors->first('tozihat') }}</span>
                @endif
            </div>

            <button class="btn btn-primary">ویرایش بررسی اجمالی</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection
