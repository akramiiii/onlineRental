<?php

namespace App;

use App\City;
use App\Province;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    protected $table='additional_infos';
    protected $fillable=['user_id','first_name','last_name','national_identity_number','mobile_phone','email','province_id','city_id','bank_card_number'];

    public static function addUserData($user,$request)
    {
        $row=AdditionalInfo::where('user_id',$user->id)->first();
        if($row){
            $data=$request->all();
            $row->update($data);
            $AdditionalInfo=$row;
            $user->name=$request->get('first_name').' '.$request->get('last_name');
            if($user->mobile!=$row->mobile_phone) {
                $active_code = rand(99999, 1000000);
                $user->active_code = $active_code;
            }
            $user->update();
        }
        else{
            $AdditionalInfo=new AdditionalInfo($request->all());
            $AdditionalInfo->user_id=$user->id;
            $AdditionalInfo->save();

            $user->name=$request->get('first_name').' '.$request->get('last_name');
            if($user->mobile!=$AdditionalInfo->mobile_phone) {
                $active_code = rand(99999, 1000000);
                $user->active_code = $active_code;
            }
            $user->update();
        }
        if($user->mobile!=$AdditionalInfo->mobile_phone)
        {
            $active_code=rand(99999,1000000);
            $user->active_code=$active_code;
            return redirect('/confirmphone')->with('mobile_number',$AdditionalInfo->mobile_phone);
        }
        else{
            return redirect()->back()->with('status','ثبت اطلاعات با موفقیت انجام شد');
        }
    }
    public function getProvince()
    {
        return $this->hasone(Province::class,'id','province_id')->withDefault(['name'=>'']);
    }
    public function getCity()
    {
        return $this->hasone(City::class,'id','city_id')->withDefault(['name'=>'']);;
    }
}
