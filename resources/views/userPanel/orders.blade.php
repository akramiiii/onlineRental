@extends('layouts.shop')

@section('content')

    <div class="row">

        <div class="col-md-3">
            @include('include.user_panel_menu',['active'=>'orders'])
        </div>
        <div class="col-md-9" style="padding-right: 0px">

            <div class="profile_menu">

                <span class="profile_menu_title">سفارشات من</span>

                @include('include.user_order_list')

                {{ $orders->links() }}
            </div>
        </div>

    </div>

@endsection
