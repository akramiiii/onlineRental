<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    protected $table = 'province';
    protected $fillable = ['name'];

    public static function getData($request){
        $string = "?";
        $province = self::orderBy('id' , 'DESC');
        if(inTrashed($request)){
            $province = $province->onlyTrashed();
            $string = create_paginate_url($string , 'trashed=true');
        }
        if(array_key_exists('string' , $request) && !empty($request['string'])){
            $province = $province->where('name' , 'like' , '%'. $request['string'] . '%');
            $string = create_paginate_url($string, 'string='.$request['string']);
        }
        $province = $province->paginate(10);
        $province->withPath($string);
        return $province;
    }
}
