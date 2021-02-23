<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addAddress(Request $request)
    {
        return Address::addUserAddress($request);
    }
    public function removeAddress($id,Request $request)
    {
        $user_id=$request->user()->id;
        $delete=Address::where(['user_id'=>$user_id,'id'=>$id])->delete();
        if($delete)
        {
            $AddressList=Address::with(['getCity','getProvince'])->where(['user_id'=>$user_id])->orderBy('id','DESC');
            if($request->get('paginate')=='ok'){
                $AddressList=$AddressList->paginate(10);
            }
            else{
                $AddressList=$AddressList->get();
            }
            return $AddressList;
        }
        else{
            return 'error';
        }
    }
    public function getAddreass(Request $request){
        $user_id=$request->user()->id;
        $userAddress=Address::with(['getProvince','getcity'])->where('user_id',$user_id)->orderBy('id','DESC')->paginate(10);
        return $userAddress;
    }
}
