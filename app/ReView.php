<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReView extends Model
{
    use SoftDeletes;
    protected $table='review_product';
    protected $fillable=['title','tozihat','product_id'];
    public static function getData($request)
    {
        $string='?';
        $review=self::orderBy('id','DESC')->whereNotNull('title');
        if(inTrashed($request))
        {
            $review=$review->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        $review=$review->paginate(10);
        $review->withPath($string);
        return $review;
    }
}
