<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pledge extends Model
{
    use SoftDeletes;
    protected $table = 'pledge';
    protected $fillable = ['pledge'];

    public static function getData($request)
    {
        $string = "?";
        $pledge = self::orderBy('id', 'DESC');
        if (inTrashed($request)) {
            $pledge = $pledge->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $pledge = $pledge->where('pledge', 'like', '%'. $request['string'] . '%');
            $string = create_paginate_url($string, 'string='.$request['string']);
        }
        $pledge = $pledge->paginate(10);
        $pledge->withPath($string);
        return $pledge;
    }
}
