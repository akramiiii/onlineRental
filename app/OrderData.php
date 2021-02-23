<?php
namespace App;

class OrderData
{
    protected $OrderInfo;
    protected $ProductRow;
    protected $order_row_amount=array();
    protected $order_row_products=array();
    protected $array_product_id=array();
    protected $user_id=0;
    public function __construct($OrderInfo, $ProductRow)
    {
        // $this->user_id=$user_id;
        $this->OrderInfo=$OrderInfo;
        $this->ProductRow=$ProductRow;
    }
    public function getData($id=0)
    {
        foreach ($this->OrderInfo as $info) {
            if (($id>0 && $info->id=$id) || $id==0) {
                $this->order_row_amount[$info->id]=$info->send_order_amount;
                $products_id=explode('-', $info->products_id);
                // var_dump($products_id);
                foreach ($products_id as $key=>$value) {
                    if (!empty($value)) {
                        $this->getProductDataOfList($info, $this->ProductRow, $value);
                    }
                }
            }
        }

        $this->getProductData();
        // dd($this->order_row_products);
        return [
            'order_row_amount'=>$this->order_row_amount,
            'row_data'=>$this->row_data
        ];
    }
    public function getProductDataOfList($info, $products, $product_id)
    {
        foreach ($products as $key=>$value) {
            if ($value->product_id==$product_id) {
                $amount=$value->product_price2*$value->product_count*$value->product_roz;
                $p=array_key_exists($info->id, $this->order_row_amount) ? $this->order_row_amount[$info->id] : 0;
                $this->order_row_amount[$info->id]=$p+$amount;

                $size=array_key_exists($info->id, $this->order_row_products) ? sizeof($this->order_row_products[$info->id]) : 0;
                $this->order_row_products[$info->id][$size]=$value;
                $this->array_product_id[$value->product_id]=$value->product_id;
            }
        }
    }
    public function getProductData()
    {
        $products=Product::whereIn('id', $this->array_product_id)->select(['id','title','img_url','offers'])->get();
        // dd($products);
        $j=0;
        foreach ($this->order_row_products as $key=>$value) {
            // echo $key;
            foreach ($value as $key2=>$value2) {
                $product=getCartProductData($products, $value2->product_id);
                if ($product) {
                    // echo 'ok';
                    $this->row_data[$key][$j]['title']=$product->title;
                    $this->row_data[$key][$j]['img_url']=$product->img_url;
                    $this->row_data[$key][$j]['product_count']=$value2->product_count;
                    $this->row_data[$key][$j]['product_roz']=$value2->product_roz;
                    $this->row_data[$key][$j]['product_price1']=$value2->product_price1;
                    $this->row_data[$key][$j]['product_price2']=$value2->product_price2;
                    $this->row_data[$key][$j]['offers']=$value2->product_offers;
                    $j++;
                }
            }
        }
    }
}
