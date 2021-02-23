<div id="auth_box">
    <div class="auth_box_title">
        <span>ورود به سایت</span>
    </div>
    <div style="margin: 25px">
        <form action="{{ route('login') }}" method="post" id="login_form">
            @csrf
            <div class="form-group">
                <div class="field_name">شماره موبایل</div>
                <label class="input_lable user_name">
                    <input id="login_mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="شماره موبایل خود را وارد نمایید">

                    <label id="mobile_error_message" class="feedback-hint">
                        
                    </label>
                </label>
            </div>
            <div class="form-group">
                <div class="field_name">کلمه عبور</div>
                <label class="input_lable user_pass">
                    <input id="login_password" type="password" class="form-control @if($errors->has('password')) validate_error_border @endif" name="password" placeholder="کلمه عبور خود را وارد نمایید">

                    <label id="password_error_message" class="feedback-hint" @if($errors->has('password')) style="display:block" @endif>
                        @if($errors->has('password'))
                            <span>{{ $errors->first('password') }}</span>
                        @endif
                    </label>
                </label>                   
            </div>
            @if ($errors->has('mobile'))
                <div class="alert alert-danger">{{ $errors->first('mobile') }}</div>
            @endif
            <a class="reset_password_link" href="{{ url('password/reset') }}">بازیابی کلمه عبور</a>
            <div class="send_btn login_btn" id="login_btn">
                <span class="line"></span>
                <span class="title">ورود</span>
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
    <div class="alert alert-warning">
        <span>کاربر جدید هستید ؟ </span>
        <span>
            <a class="data-link" href="{{ route('register') }}">ثبت نام در سایت</a>
        </span>
    </div>
</div>