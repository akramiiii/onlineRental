@extends('layouts.admin')
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'تعیین هزینه ارسال سفارشات' , 'url' => url("admin/setting/payment-gateway")],
    ]])
    <div class="panel">
        <div class="header">تنظیمات اتصال به درگاه پرداخت</div>

        <div class="panel_content">
            {!! Form::open(['url' => 'admin/setting/send-order-price']) !!}
                <p style="color: red">تنظیمات اتصال به درگاه بانک ملت</p>
                <div class="form-group">
                    {{ Form::label('TerminalId', 'ترمینال آی دی بانک ملت : ') }}
                    {{ Form::text('TerminalId',$data['TerminalId'],['class'=>'form-control left']) }}
                    @if ($errors->has('TerminalId'))
                        <span class="has_error">{{ $errors->first('TerminalId') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('Username',' نام کاربری : ') }}
                    {{ Form::text('Username',$data['Username'],['class'=>'form-control left']) }}
                    @if ($errors->has('Username'))
                        <span class="has_error">{{ $errors->first('Username') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('Password','کلمه عبور : ') }}
                    {{ Form::text('Password',$data['Password'],['class'=>'form-control left']) }}
                    @if ($errors->has('Password'))
                        <span class="has_error">{{ $errors->first('Password') }}</span>
                    @endif
                </div>
                <p style="color: red">تنظیمات اتصال به درگاه زرین پال</p>
                <div class="form-group">
                    {{ Form::label('MerchantID', 'MerchantID : ') }}
                    {{ Form::text('MerchantID',$data['MerchantID'],['class'=>'form-control left']) }}
                    @if ($errors->has('MerchantID'))
                        <span class="has_error">{{ $errors->first('MerchantID') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('gateway' , 'درگاه پیش فرض : ') }}
                    {{ Form::select('gateway' , [1=>'بانک ملت' , 2=>'زرین پال'] , $data['gateway'] , ['class'=>'selectpicker auto-width']) }}
                </div>
                <button class="btn btn-success">ثبت اطلاعات</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection