<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    protected $table = 'item_value';
    protected $fillable = ['product_id' , 'item_id' , 'item_value'];

    public function important_item(){
        return $this->hasOne(Item::class , 'id' , 'item_id')->where('show_item' , 1);
    }
}
