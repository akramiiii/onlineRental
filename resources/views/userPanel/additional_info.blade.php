@extends('layouts.shop')

@section('content')

    <div class="row">

        <div class="col-md-3">
            @include('include.user_panel_menu',['active'=>'profile'])
        </div>

        <div class="col-md-9" style="padding-right: 0px">
            <span class="profile_menu_title" style="padding: 0px;margin-top: 20px">ویرایش اطلاعات شخصی</span>

            @if(Session::has('status'))
                <div class="alert alert-success custom-alert">{{ Session::get('status') }}</div>
            @endif
            <div class="profile_menu profile_info">
                <form method="post" id="additional_info" action="{{ url('user/profile/additional-info') }}">
                    @csrf
                    <?php
                        $personal_input=['first_name'=>'نام','last_name'=>'نام خانوادگی','national_identity_number'=>'کد ملی','mobile_phone'=>'شماره موبایل','email'=>'ایمیل','bank_card_number'=>'شماره کارت'];
                    ?>
                    <span class="profile_menu_title center mr-3 mb-3" style="padding: 0px;margin-top: 20px">حساب شخصی</span>
                    <div class="row">
                        @foreach($personal_input as $key=>$value)
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="account_title">{{ $value }}</div>
                                    <label class="input_label">
                                        <input style="width: 150%" type="text" class="form-control @if($errors->has($key)) validate_error_border @endif" value="{{ getUserData($key,$additionalInfo) }}" name="{{ $key }}" placeholder="لطفا {{ $value }} خود را وارد نمایید">
                                        @if($errors->has($key))
                                            <label class="feedback-hint" style="display:block">
                                                <span>{{ $errors->first($key) }}</span>
                                            </label>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="footer m-3">
                        <button class="btn btn-success">ثبت اطلاعات</button>
                        <a href="{{ url('user/profile') }}" style="color: white" class="btn btn-dark">انصراف</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('head')
    <link rel="stylesheet" href="{{ url('css/toggles-full.css') }}"/>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ url('js/toggles.min.js') }}"></script>
    <script>
        $("#account_type").toggles({
            type:'Light',
            text:{'on':'','off':''},
            width:50,
            direction:'rtl',
            on:true
        });
        $("#account_type").on('toggle',function (e,action) {
            if(action){
                $('.form_cover').show();
                document.getElementById('Legal').value=false;
            }
            else{
                $('.form_cover').hide();
                document.getElementById('Legal').value=true;
            }
        });

        
    </script>
@endsection
