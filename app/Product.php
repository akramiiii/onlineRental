<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = "products";
    protected $fillable = ['title' , 'ename' , 'product_url' , 'show' , 'view' , 'keywords' , 'description' , 'special' , 'cat_id' , 'img_url' , 'tozihat' , 'status' , 'price1' , 'price2' , 'send_time' , 'product_number' , 'product_number_cart' , 'discount_price' , 'order_number' , 'offers_first_date' , 'offers_last_date' , 'offers_first_time' , 'offers_last_time' , 'offers' , 'show_index' , 'order_number' , 'roz'];

    public static function ProductStatus()
    {
        $array = array();
        $array[0] = 'ناموجود';
        $array[1] = 'منتشر شده';

        return $array;
    }

    public static function getData($request){
        $string = "?";
        $products = self::orderBy('id' , 'DESC');
        if(inTrashed($request)){
            $products = $products->onlyTrashed();
            $string = create_paginate_url($string , 'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $products=$products->where('title','like','%'.$request['string'].'%');
            $products=$products->orWhere('ename','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $products = $products->paginate(10);
        $products->withPath($string);
        return $products;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($product){
            if($product->isForceDeleting()){
                remove_file($product->img_url, 'products');
                remove_file($product->img_url, 'thumbnails');
                DB::table('item_value')->where('product_id', $product->id)->delete();
            }
        });
    }

    // public function getColor()
    // {
    //    return $this->belongsTo(Color::class,'color_id','id')
    //        ->withDefault(['name'=>'','id'=>0]);
    // }

    public function getCat(){
        return $this->hasOne(Category::class , 'id' , 'cat_id')->withDefault(['name' => '']);
    }

    public function itemValue(){
        return $this->hasMany(ItemValue::class , 'product_id' , 'id');
    }
}
