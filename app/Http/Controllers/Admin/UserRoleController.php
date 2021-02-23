<?php

namespace App\Http\Controllers\Admin;

use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;

class UserRoleController extends CustomController
{
    protected $model='UserRole';
    protected $title='نقش کاربری';
    protected $route_params='userRole';
    public function index(Request $request)
    {
        $userRole=UserRole::getData($request->all());
        $trash_role_count=UserRole::onlyTrashed()->count();
        return view('userRole.index', ['userRole'=>$userRole,'trash_role_count'=>$trash_role_count,'req'=>$request]);
    }
    public function create()
    {
        return view('userRole.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, ['name'=>'required|unique:user_roles'], [], ['role_name'=>'نام نقش کاربری']);
        $userRole=new UserRole($request->all());
        $userRole->saveOrFail();
        return redirect('admin/userRole')->with('message', 'ثبت نقش کاربری با موفقیت انجام شد');
    }
    public function edit($id)
    {
        $userRole=UserRole::findOrFail($id);
        return view('userRole.edit', ['userRole'=>$userRole]);
    }
    public function update($id, Request $request)
    {
        $this->validate($request, ['name'=>'required|unique:user_roles,name,'.$id], [], ['role_name'=>'نام نقش کاربری']);
        $userRole=UserRole::findOrFail($id);
        $userRole->update($request->all());
        return redirect('admin/userRole')->with('message', 'ویرایش نقش کاربری با موفقیت انجام شد');
    }
    public function access($role_id)
    {
        $role=UserRole::findOrFail($role_id);
        $role_accesses=DB::table('role_accesses')->where('role_id', $role_id)->first();
        return view('userRole.access', compact('role' , 'role_accesses'));
    }
    public function add_access($role_id, Request $request)
    {
        $role=UserRole::findOrFail($role_id);
        $access=$request->get('access', array());
        DB::table('role_accesses')->where('role_id', $role_id)->delete();

        $string=json_encode($access);
        DB::table('role_accesses')->insert(['role_id'=>$role_id,'access'=>$string]);
        return redirect()->back()->with('message', 'ثبت دسترسی با موفقیت انجام شد');
    }
}
