@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')]]])
    <div class="panel">

        <div class="header">
            مدیریت نقش های کاربری

            @include('include.item_table',['count'=>$trash_role_count,'route'=>'admin/userRole','title'=>'نقش کاربری'])
        </div>

        <div class="panel_content">

            @include('include.Alert')
            <?php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*10): 0 ; ?>

         
            <form method="post" id="data_form">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام نقش</th>
                        <th>تعداد کاربر</th>
                        <th>عمیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userRole as $key=>$value)
                        @php $i++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="userRole_id[]" class="check_box" value="{{ $value->id }}"/>
                            </td>
                            <td>{{ $i }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->userrole_count }}</td>
                            <td>
                                @if(!$value->trashed())
                                    <a href="{{ url('admin/userRole/'.$value->id.'/edit') }}"><span class="fa fa-edit"></span></a>
                                @endif

                                <a href="{{ url('admin/userRole/access/'.$value->id) }}" style="color:black">
                                    <span  data-toggle="tooltip" data-placement="bottom"  title='دسترسی ها'  class="fa fa-lock"></span>
                                </a>

                                @if($value->trashed())
                                   <span data-toggle="tooltip" data-placement="bottom"  title='بازیابی نقش کاربری' onclick="restore_row('{{ url('admin/userRole/'.$value->id) }}','{{ Session::token() }}','آیا از بازیابی این نقش کاربری مطمئن هستین ؟ ')" class="fa fa-refresh"></span>
                                @endif

                                @if(!$value->trashed())
                                <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف نقش کاربری' onclick="del_row('{{ url('admin/userRole/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این نقش کاربری مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                @else
                                <span style="cursor: pointer" data-toggle="tooltip" data-placement="bottom"  title='حذف نقش کاربری برای همیشه' onclick="del_row('{{ url('admin/userRole/'.$value->id) }}','{{ Session::token() }}','آیا از حذف این نقش کاربری مطمئن هستین ؟ ')" class="fa fa-remove"></span>
                                 @endif
                            </td>
                        </tr>

                    @endforeach

                    @if(sizeof($userRole)==0)
                        <tr>
                            <td colspan="5">رکوردی برای نمایش وجود ندارد</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>

            {{ $userRole->links() }}
        </div>
    </div>

@endsection
