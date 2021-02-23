@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
         ['title'=>'تعیین دسترسی های نقش : '.$role->name,'url'=>url('admin/userRole/access/'.$role->id)]
    ]])
    <div class="panel">
        <div class="header">تعیین دسترسی های نقش : {{ $role->name }}</div>

        @php
            $AccessList=\App\User::AccessList();
        @endphp
        <div class="panel_content">
            @include('include.Alert')
            <form method="POST">
                @csrf
                <ul class="access">
                    @foreach ($AccessList as $key=>$item)
                        <li class="item_groups" style="margin-bottm:20px">
                            <span>{{ $item['label'] }}</span>
                            <ul>
                                @foreach ($item['access'] as $key2=>$value2)
                                    <li>
                                        <input type="checkbox" style="cursor: pointer" @if(CheckAccess($role_accesses,$key,$key2)) checked="checked" @endif name="access[{{ $key }}][]" value="{{ $key2 }}">
                                        {{ $value2['label'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>

                <div class="form-group">
                    <button class="btn btn-success">ثبت</button>
                </div>
            </form>
        </div>
    </div>
@endsection    