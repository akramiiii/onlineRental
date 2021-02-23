<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Order;
use App\Comment;
use App\Question;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\CustomController;

class UsersController extends CustomController
{
    protected $model='User';
    protected $title='کاربر';
    protected $route_params='users';
    public function index(Request $request)
    {
        $roles=UserRole::get();
        $users=User::getData($request->all());
        $trash_user_count=User::onlyTrashed()->count();
        return view('users.index', ['users'=>$users,'trash_user_count'=>$trash_user_count,'req'=>$request,'roles'=>$roles]);
    }
    public function create()
    {
        $roles=UserRole::get();
        return view('users.create', ['roles'=>$roles]);
    }
    public function store(UserRequest $request)
    {
        $user=new User($request->all());
        if ($request->get('role')=="admin" || $request->get('role')=="user") {
            $user->role=$request->get('role');
        } else {
            $user->role="user";
            $user->role_id=$request->get('role');
        }
        $user->password= Hash::make($request->get('password'));
        $user->saveOrFail();
        return redirect('admin/users')->with('message', 'ثبت کاربر جدید با موفقیت انجام شد');
    }
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles=UserRole::pluck('name', 'id')->toArray();
        $roles=['admin'=>'مدیر','user'=>'کاربر عادی']+$roles;
        return view('users.edit', ['roles'=>$roles,'user'=>$user]);
    }
    public function update($id, UserRequest $request)
    {
        $data=$request->all();
        $user=User::findOrFail($id);
        // dd($request->get('role'));
        if ($request->get('role')=="admin" || $request->get('role')=="user") {
            $data['role']=$request->get('role');
            $data['role_id']=0;
        } else {
            $data['role']="user";
            $data['role_id']=$request->get('role');
        }
        if (!empty($request->get('password'))) {
            $data['password']= Hash::make($request->get('password'));
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect('admin/users')->with('message', 'ویرایش اطلاعات کاربر با موفقیت انجام شد');
    }
    public function show($id)
    {
        $user=User::with(['getRole','getAdditionalInfo'])->findOrFail($id);
        $orders=Order::where('user_id', $id)->orderBy('id', 'DESC')->limit(10)->get();
        return view('users.show', [
            'user'=>$user,
            'orders'=>$orders,
        ]);
    }
}
