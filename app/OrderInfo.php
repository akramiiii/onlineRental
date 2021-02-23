<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $table='order_info';
    protected $fillable=['order_id','delivery_day','delivery_time','guarantee','send_order_amount','products_id','send_status'];

    public static function getData($request,$send_status=0,$order='ASC'){
        $string='?';
        $submission=self::orderBy('created_at',$order);
        if(inTrashed($request))
        {
            $submission=$submission->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('submission_id',$request) && !empty($request['submission_id']))
        {
            // $submission_id=replace_number2($request['submission_id']);
            $submission=$submission->where('id',$request['submission_id']);
            $string=create_paginate_url($string,'submission_id='.$request['submission_id']);
        }

        if($send_status>=1){
            $submission=$submission->where('send_status',$send_status);
        }
        $submission=$submission->orderBy('id','DESC')->paginate(10);
        $submission->withPath($string);
        return $submission;
    }
    public function getOrder(){
        return $this->hasOne(Order::class,'id','order_id');
    }
}
