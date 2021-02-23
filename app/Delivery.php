<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;
    protected $table = 'delivery';
    protected $fillable = ['delivery'];

    public static function getData($request)
    {
        $string = "?";
        $delivery = self::orderBy('id', 'DESC');
        if (inTrashed($request)) {
            $delivery = $delivery->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $delivery = $delivery->where('delivery', 'like', '%'. $request['string'] . '%');
            $string = create_paginate_url($string, 'string='.$request['string']);
        }
        $delivery = $delivery->paginate(10);
        $delivery->withPath($string);
        return $delivery;
    }
}
