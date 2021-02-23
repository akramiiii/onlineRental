<div class="profile_menu">

    <div class="profile_menu_header">حساب کاربری شما</div>

    <ul class="profile_menu_ul">
        <li @if($active=='profile') class="active_li" @endif>
            <a href="{{ url('user/profile') }}">
                <span class="fa fa-user"></span>
                پروفایل
            </a>
        </li>

        <li @if($active=='orders') class="active_li" @endif>
            <a href="{{ url('user/profile/orders') }}">
                <span class="fa fa-shopping-cart"></span>
                سفارشات
            </a>
        </li>

        <li @if($active=='favorite') class="active_li" @endif>
            <a href="{{ url('user/profile/favorite') }}">
                <span class="fa fa-star-o"></span>
                لیست علاقه مندی ها
            </a>
        </li>

        <li @if($active=='comments') class="active_li" @endif>
            <a href="{{ url('user/profile/comments') }}">
                <span class="fa fa-camera-retro"></span>
               نقد و نظرات
            </a>
        </li>

        {{-- <li @if($active=='gift-cart') class="active_li" @endif>
            <a href="{{ url('user/profile/gift-cart') }}">
                <span class="fa fa-gift"></span>
                کارت های هدیه
            </a>
        </li> --}}

        <li @if($active=='address') class="active_li" @endif>
            <a href="{{ url('user/profile/address') }}">
                <span class="fa fa-address-card"></span>
               آدرس ها
            </a>
        </li>

        <li @if($active=='messages') class="active_li" @endif>
            <a href="{{ url('user/profile/messages') }}">
                <span class="fa fa-envelope"></span>
                پیغام های من
            </a>
        </li>
    </ul>

</div>
