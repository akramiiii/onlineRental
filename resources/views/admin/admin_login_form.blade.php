@extends('layouts.auth')

@section('content')
    <div id="auth_box">
    <div class="auth_box_title">
        <span>ورود به بخش مدیریت</span>
    </div>
    <div style="margin: 30px">
        <form action="{{ route('login') }}" method="post" id="admin_login_form">
            @csrf
            <div class="form-group">
                <div class="field_name">نام کاریری</div>
                <label class="input_lable username">
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="نام کاربری خود را وارد نمایید">

                    <label id="username_error_message" class="feedback-hint">
                        
                    </label>
                </label>
            </div>
            <div class="form-group">
                <div class="field_name">کلمه عبور</div>
                <label class="input_lable user_pass">
                    <input id="password" type="password" class="form-control @if($errors->has('password')) validate_error_border @endif" name="password" placeholder="کلمه عبور خود را وارد نمایید">

                    <label id="password_error_message" class="feedback-hint" @if($errors->has('password')) style="display:block" @endif>
                        @if($errors->has('password'))
                            <span>{{ $errors->first('password') }}</span>
                        @endif
                    </label>
                </label>                   
            </div>
            @if ($errors->has('username'))
                <div class="alert alert-danger">{{ $errors->first('username') }}</div>
            @endif
            <div class="send_btn login_btn" id="admin_login_btn">
                <span class="line"></span>
                <span class="title">ورود به بخش مدیریت</span>
            </div>
            <div class="row form-group">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check" style="margin-right: -15px">
                        <input class="form-check-input" checked="checked" name="remember" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="check_box active" id="login_remember"></span>
                        <span class="form-check-label">مرا به خاطر بسپار</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection