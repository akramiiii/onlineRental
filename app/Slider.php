<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $table = 'sliders';
    protected $fillable = ['title' , 'url' , 'image_url'];

    public static function getData($request)
    {
        $string = "?";
        $slider = self::orderBy("id" , "DESC");
        if(inTrashed($request)){
            $slider = $slider->onlyTrashed();
            $string = create_paginate_url($string , 'trashed=true');
        }
        $slider = $slider->paginate(10);
        $slider->withPath($string);
        return $slider;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($slider){
            if($slider->isForceDeleting()){
                if(!empty($slider->image_url) && file_exists('files/slider/'.$slider->image_url)){
                    unlink('files/slider/'.$slider->image_url);
                }
            }
        });
    }
}
