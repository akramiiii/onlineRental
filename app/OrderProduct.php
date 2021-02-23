<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table='order_products';
    public function getProduct()
    {
        return $this->hasOne(Product::class,'id','product_id')->select(['id','title','img_url','offers']);
    }
}
