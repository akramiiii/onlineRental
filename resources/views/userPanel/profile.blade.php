@extends('layouts.shop')

@section('content')

    <div class="row">

        <div class="col-md-3">
            @include('include.user_panel_menu',['active'=>'profile'])
        </div>

        <div class="col-md-9" style="padding-right: 0px">
            <span class="profile_menu_title" style="padding: 0px;margin-top: 20px">اطلاعات شخصی</span>
            <div class="profile_menu" style="padding-top: 20px">
                <table class="table table-bordered order_table_info">
                    <tr>
                        <td>
                            نام و نام خانوادگی :
                            <span>
                                {{ getUserPersonalData($additionalInfo,'first_name','last_name') }}
                            </span>
                        </td>
                        <td>
                            پست الکترونیکی :
                            <span>{{ getUserPersonalData($additionalInfo,'email') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            شماره تلفن همراه :
                            <span>{{ Auth::user()->mobile }}</span>
                        </td>
                        <td>
                            کد ملی :
                            <span>{{ getUserPersonalData($additionalInfo,'national_identity_number') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            شماره کارت بانکی :
                            <span>{{ getUserPersonalData($additionalInfo,'bank_card_number') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span  style="text-align: center">
                                <a class="data-link" href="{{ url('user/profile/additional-info') }}" style="font-size: 14px">
                                    <i class="fa fa-pencil"></i>
                                    ویرایش اطلاعات
                                </a>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <span class="profile_menu_title" style="padding: 0px">آخرین سفارش های من</span>
            <div class="profile_menu" style="padding-top: 20px">
                @include('include.user_order_list')
            </div>
        </div>
    </div>

@endsection
