@extends("layouts.auth")

@section('content')
<div id="auth_box">
    <div class="auth_box_title">
        <span>یاد آوری کلمه عبور</span>
    </div>
    <div style="margin:30px">
        @if (session('status'))
           <div class="alert alert-success" role="alert">
             {{ session('status') }}
           </div>
       @endif
        <form method="POST" action="{{ route('password.email') }}" id="forget_password_form">
          @csrf

            <div class="form-group">
                <div class="field_name">شماره موبایل</div>
                <label class="input_label user_name w-100" style="position: relative">
                   <input style="height: 50px" type="text" class="form-control @if($errors->has('mobile')) validate_error_border @endif" name="mobile" id="login_mobile" value="{{ old('mobile') }}" placeholder="شماره موبایل خود را وارد نمایید">

                    <label id="mobile_error_message" class="feedback-hint"  @if($errors->has('mobile')) style="display:block" @endif>
                        @if($errors->has('mobile'))
                            <span>{{ $errors->first('mobile') }}</span>
                        @endif
                    </label>
                </label>
            </div>

            <div class="send_btn forget_password" id="forget_password">
                <span class="line"></span>
                <span class="title">یاد آوری کلمه عبور</span>
            </div>
        </form>

    </div>
</div>
@endsection
