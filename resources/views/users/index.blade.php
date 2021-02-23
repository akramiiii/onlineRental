@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت کاربران','url'=>url('admin/users')]]])
    <div class="panel">

        <div class="header">
            مدیریت کاربران

            @include('include.item_table',['count'=>$trash_user_count,'route'=>'admin/users','title'=>'کاربر'])
        </div>

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; $Jdf=new \App\Lib\Jdf(); ?>

            <form method="get" class="search_form">
                @if(isset($_GET['trashed']) && $_GET['trashed']==true)
                    <input type="hidden" name="trashed" value="true">
                @endif
                <input type="text" name="name" class="form-control" value="{{ $req->get('name','') }}" placeholder="نام کاربر">
                <input type="text" name="mobile" class="form-control" value="{{ $req->get('mobile','') }}" placeholder="شماره موبایل">

                <select name="role" class="selectpicker">
                    <option @if($req->get('role','')=='admin') selected="selected" @endif   value="admin">مدیر</option>
                    <option @if($req->get('role','')=='user') selected="selected" @endif   value="user">کاربر عادی</option>
                    @foreach ($roles as $role)
                      <option @if($req->get('role','')==$role->id) selected="selected" @endif   value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select> 
                <button class="btn btn-primary" style="margin-right:80px">جست و جو</button>
            </form>
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped user_table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام کاربر</th>
                        <th>شماره موبایل</th>
                        <th>تاریخ عضویت</th>
                        <th>وضعیت</th>
                        <th>نقش کاربری</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="users_id[]" class="check_box" value="{{ $value->id }}"/>
                            </td>
                            <td>{{ $i }}</td>
                            <td>
                                @if (!empty($value->name))
                                   {{  $value->name }}
                                @else  
                                    ثبت نشده  
                                @endif
                            </td>
                            <td>{{ $value->mobile }}</td>
                            <td>
                                @php
                                    $e=explode(' ',$value->created_at);
                                    $e2=explode('-',$e[0]);
                                @endphp
                                {{ $Jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-') }}
                            </td>
                            <td>
                                @if ($value['account_status']=='active')
                                    <span class="alert alert-success">فعال</span>
                                @else
                                   <span class="alert alert-danger">غیر فعال</span>
                                @endif
                            </td>
                            <td>
                                @if ($value->getRole)
                                    {{ $value->getRole->name }}
                                @elseif($value->role=='admin') 
                                    مدیر
                                @else
                                   کاربر عادی
                                @endif
                            </td>
                            <td>
                                @if(!$value->trashed())
                                <a href="{{ url('admin/users/'.$value->id.'/edit') }}"><span class="fa fa-edit"></span></a>
                                @endif
                                <a href="{{ url('admin/users/'.$value->id) }}">
                                    <span  data-toggle="tooltip" data-placement="bottom"  title='سفارش های کاربر' class="fa fa-eye"></span>
                                </a>

                                @if($value->trashed())
                                   <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='بازیابی کاربر' onclick="restore_row('{{ url('admin/users/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این کاربر مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                @endif

                                @if(!$value->trashed())
                                    <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف کاربر' onclick="del_row('{{ url('admin/users/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این کاربر مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                @else
                                    <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف کاربر برای همیشه' onclick="del_row('{{ url('admin/users/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این کاربر مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                 @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($users)==0)
                        <tr>
                            <td colspan="8">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>

            {{ $users->links() }}
        </div>
    </div>

@endsection
