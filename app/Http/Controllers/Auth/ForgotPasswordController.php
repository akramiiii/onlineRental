<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function confirm()
    {
        $mobile=Session::get('mobile');
        $token=Session::get('forget_password_token');
        if($token && $mobile)
        {
            return view('auth/passwords/confirm',['mobile'=>$mobile]);
        }
        else{
            return redirect('/');
        }
    }

    public function check_confirm_code(Request $request)
    {
        $mobile=$request->get('mobile');
        $token=Session::get('forget_password_token');
        $forget_password_code=$request->get('forget_password_code');
        $user=User::where(['forget_password_code'=>$forget_password_code,'mobile'=>$mobile])->first();
        if($user){
            $user->forget_password_code=null;
            $user->update();
            Session::forget('token');
            return redirect('/password/reset/'.$token.'?mobile='.$mobile);

        }
        else{
            return redirect()->back()->with('mobile', $mobile)->with('token', $token)->with('validate_error', 'کد وارد شده اشتباه میباشد')->withInput();
        }

        // $mobile=$request->get('mobile');
        // $token=Session::get('fotger_password_token');
        // $forget_password_code=$request->get('forget_password_code');
        // $user=User::where(['forget_password_code'=>$forget_password_code,'mobile'=>$mobile])->first();
        // if($user)
        // {
        //     $user->forget_password_code=null;
        //     $user->update();
        //     Session::forget('token');
        //     return redirect('/password/reset/'.$token.'?mobile='.$mobile); 
        // }
        // else{
        //     return redirect()->back()->with('mobile',$mobile)->with('token',$token)->with('validate_error','کد وارد شده اشتباه میباشد')->withInput();
        // }
    }
}
