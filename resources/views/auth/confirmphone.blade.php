@extends("layouts.auth")

@section('content')

    <div id="auth_box">
        <div class="auth_box_title">
            <span>تایید شماره تلفن همراه</span>
        </div>

        <div class="alert alert-success">
           <span>برای شماره موبایل {{ Session::get('mobile_number') }} کد تایید ارسال شد</span>
            <a href="{{ url('user/profile/additional-info') }}" class="data_link">ویرایش شماره</a>
        </div>

        <div style="margin: 25px">
            <form method="POST" action=" {{ url('changeMobileNumber') }}" id="active_account_form">
            @csrf
                <div class="form-group">
                    <div class="field_name">کد تایید را وارد نمایید</div>
                    <input type="hidden" value="{{ Session::get('mobile_number') }}" id="user_mobile" name="mobile">
                    <div class="number_input_div">
                        <input type="text" name="active_code" max="6" value="{{ old('active_code') }}" class="number_input number" maxlength="6">
                    </div>
                    <div class="line_box">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>

                    <p id="resend_active_code">
                        <span>ارسال مجدد کد</span>
                        <span id="timer"></span>
                    </p>

                    @if(Session::has('validate_error'))
                        <p class="alert alert-danger">{{ Session::get('validate_error') }}</p>
                    @endif

                    <div class="send_btn confirm" id="active_account_btn">
                        <span class="line"></span>
                        <span class="title">تایید و ارسال</span>
                    </div>
                </div>
            </form>
        </div>



    </div>
@endsection

@section('footer')
    <script>
        startTimer();
    </script>
@endsection
