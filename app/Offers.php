<?php

namespace App;

use App\Jobs\IncredibleOffers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Offers{
    public function add($request , $product){
        $validator = Validator::make($request->all() , [
            'price1' => 'required|numeric',
            'price2' => 'required|numeric',
            'product_number' => 'required|numeric',
            'product_number_cart' => 'required|numeric',
            'date1' => 'required',
            'date2' => 'required',
        ] , [] , [
            'price1' =>'هزینه محصول',
            'price2' => 'هزینه محصول برای فروش',
            'product_number' => 'تعداد موجودی محصول',
            'product_number_cart' => 'تعداد قابل سفارش در سبد خرید',
            'date1' => 'تاریخ شروع',
            'date2' => 'تاریخ پایان',
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        else{
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $offers_first_time = getTimestamp($date1, 'first');
            $offers_last_time = getTimestamp($date2, 'last');

            $row = DB::table('old_price')->where('product_id', $product->id)->first();

            if (!$row) {
                $this->addNewPriceRow($product, $request);
            } 
            else {
                $this->updatePriceRow($row, $product, $request);
            }
            $product->offers_first_date = $date1;
            $product->offers_last_date = $date2;
            $product->offers_first_time = $offers_first_time;
            $product->offers_last_time = $offers_last_time;
            $product->offers = 1;

            if ($product->update($request->all())) {
                $second = $offers_last_time - time() + 1;
                IncredibleOffers::dispatch($product->id)->delay(now()->addSecond($second));
                return 'ok';
            } 
            else {
                return ['error' => true];
            }

        }
    }

    public function addNewPriceRow($product , $request){
        $n = $product->product_number-$request->get('product_number');
        if ($n<0) {
            $n=0;
        }
        $insert_id = DB::table('old_price')->insertGetId([
            'product_id' => $product->id,
            'price1' => $product->price1,
            'price2' => $product->price2,
            'product_number' => $n,
            'product_number_cart' => $product->product_number_cart,
            'number_product_rent' => $request->get('product_number')
        ]);
    }

    public function updatePriceRow($row , $product , $request){
        $n = $row->product_number;
        if ($row->number_product_rent > $request->get('product_number')) {
            $n1 = $row->number_product_rent - $request->get('product_number');
            $n = $n + $n1;
        } else {
            $n1 = $request->get('product_number') - $row->number_product_rent;
            $n = $n - $n1;
        }
        DB::table('old_price')->where(['product_id' => $product->id])->update([
            'number_product_rent' => $request->get('product_number'),
            'product_number' => $n
        ]);
    }

    public function remove($product){
        $old_price = DB::table('old_price')->where('product_id' , $product->id)->first();

        if($old_price){
            $product->price1 = $old_price->price1;
            $product->price2 = $old_price->price2;
            if($old_price->product_number>0){
                $product->product_number = $product->product_number + $old_price->product_number;
            }
        }

        $product->offers = 0;
        $product->update();
        DB::table('old_price')->where('product_id', $product->id)->delete();

        return $product;
    }
}