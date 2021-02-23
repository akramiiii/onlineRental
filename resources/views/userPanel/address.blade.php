@extends('layouts.shop')

@section('content')

    <div class="row">

        <div class="col-md-3">
            @include('include.user_panel_menu',['active'=>'address'])
        </div>
        <div class="col-md-9" style="padding-right: 0px">
            <span class="profile_menu_title" style="padding:20px 10px">آدرس های من</span>

            <div class="profile_address mt-0">
                <profile-address></profile-address>
            </div>
        </div>

    </div>

@endsection
