@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
          ['title'=>'مدیریت کاربران','url'=>url('admin/users')],
          ['title'=>'مشخصات کاربر : '.$user->mobile,'url'=>url('admin/users/'.$user->id)]
        ]])
    <div class="panel">

        <div class="header">
            <div>
                <span>مشخصات کاربر : </span>
                <span>{{ $user->name }}</span>
                (<span>
                   @if ($user->getRole)
                    {{ $user->getRole->name }}
                   @elseif($user->role=='admin')  
                        مدیر  
                   @else
                      کاربر عادی
                   @endif
                </span>)
            </div>
        </div>

        <div class="panel_content">

            <?php $additionalInfo=$user->getAdditionalInfo;  ?>
            @include('include.Alert')

            <table class="table table-bordered order_table_info" style="margin:0px !important;width:100% !important">
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
                        <span>{{ $user->mobile }}</span>
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
                    <td></td>
                </tr>
            </table>

            <div id="tab_div">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="order-tab" data-toggle="tab" href="#last-order" role="tab" aria-controls="home" aria-selected="true">
                          <span class="fa fa-shopping-cart"></span>
                          <span>آخرین سفارشات کاربر</span>
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="last-order" role="tabpanel" aria-labelledby="home-tab">
                        <div class="conetnt_tab_div">
                            @include('include.orderList',['remove_delete_link'=>true])
                            @if (sizeof($orders)>0)
                                <a href="{{ url('admin/orders?user_id='.$user->id) }}" target="_blank">
                                    <span class="fa fa-arrow-left"></span>
                                    <span>نمایش لیست کامل سفارشات کاربر</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                  </div>
            </div>

        </div>
    </div>

@endsection    