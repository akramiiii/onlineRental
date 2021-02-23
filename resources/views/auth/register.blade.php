@extends('layouts.auth')

@section('content')
    <div id="auth_box">
        <div class="auth_box_title">
            <span>ثبت نام در سایت</span>
        </div>
        <div style="margin: 25px">
            <form action="{{ route('register') }}" method="post" id="register_form">
                @csrf
                <div class="form-group">
                    <div class="field_name">شماره موبایل</div>
                    <label class="input_lable user_name">
                        <input id="register_mobile" type="text" class="form-control @if($errors->has('mobile')) validate_error_border @endif" name="mobile" value="{{ old('mobile') }}" placeholder="شماره موبایل خود را وارد نمایید">

                        <label id="mobile_error_message" class="feedback-hint" @if($errors->has('mobile')) style="display:block" @endif>
                            @if($errors->has('mobile'))
                                <span>{{ $errors->first('mobile') }}</span>
                            @endif
                        </label>
                    </label>
                </div>
                <div class="form-group">
                    <div class="field_name">کلمه عبور</div>
                    <label class="input_lable user_pass">
                        <input id="register_password" type="password" class="form-control @if($errors->has('password')) validate_error_border @endif" name="password" placeholder="کلمه عبور خود را وارد نمایید">

                        <label id="password_error_message" class="feedback-hint" @if($errors->has('password')) style="display:block" @endif>
                            @if($errors->has('password'))
                                <span>{{ $errors->first('password') }}</span>
                            @endif
                        </label>
                    </label>                   
                </div>
                <div class="send_btn register_btn" id="register_btn">
                    <span class="line"></span>
                    <span class="title">ثبت نام</span>
                </div>
            </form>
        </div>
        <div class="alert alert-warning">
            <span>آیا قبلا در سایت ثبت نام کرده اید ؟ </span>
            <span>
                <a class="data-link" href="{{ route('login') }}">وارد شوید</a>
            </span>
        </div>
    </div>
@endsection
