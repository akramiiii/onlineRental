<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use App\Product;
use App\Category;
use App\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Admin\CustomController;

class ProductController extends CustomController
{
    protected $model = 'Product';
    protected $title = 'محصول';
    protected $route_params = 'product';

    public function index(Request $request)
    {
        $product = Product::getData($request->all());
        $trash_product_count = Product::onlyTrashed()->count();
        return view('product.index', compact('product', 'trash_product_count', 'request'));
    }

    public function create()
    {
        $status = Product::ProductStatus();
        $catList = Category::get_parent2();
        return view('product.create', compact('catList', 'status'));
    }

    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());
        $product_url = get_url($request->get('title'));
        $product->product_url = $product_url;
        $image_url = upload_file($request, 'pic', 'products');
        $product->img_url = $image_url;
        $product->view = 0;
        create_fit_pic('files/products/'.$image_url, $image_url);
        $product->saveOrFail();

        // foreach ($product_color as $key => $value) {
        //     DB::table('product_color')->insert([
        //         'product_id' => $product->id,
        //         'color_id' => $value,
        //         'cat_id' => $product->cat_id
        //     ]);
        // }

        return redirect('admin/product')->with('message', 'ثبت محصول با موفقیت انجام شد');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $status = Product::ProductStatus();
        // $colors = Color::get();
        // $brand[''] = 'انتخاب برند';
        // $brand = $brand + Brand::pluck('brand_name', 'id')->toArray();
        $catList = Category::get_parent2();
        // $product_color = DB::table('product_color')->where('product_id', $product->id)->pluck('color_id', 'color_id')->toArray();
        return view('product.edit', compact('product', 'catList', 'status'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        // $product_color = $request->get('product_color', array());
        $product_url = get_url($request->get('title'));
        $product->product_url = $product_url;
        $image_url = upload_file($request, 'pic', 'products');
        if (!empty($image_url)) {
            remove_file($product->img_url, 'products');
            remove_file($product->img_url, 'thumbnails');
            create_fit_pic('files/products/'.$image_url, $image_url);
            $product->img_url = $image_url;
        }

        $product->update($request->all());

        return redirect('admin/product')->with('message', 'ویرایش محصول با موفقیت انجام شد');
    }

    public function gallery($id){
        $product = Product::where('id' , $id)->select(['id' , 'title'])->firstOrFail();
        $product_gallery = ProductGallery::where('product_id' , $id)->orderBy('position','ASC')->get();
        return view('product.gallery' , ['product' => $product , 'product_gallery' => $product_gallery]);
    }

    public function gallery_upload($id , Request $request){
        $product = Product::where('id' , $id)->select(['id'])->firstOrFail();
        if($product){
            $count = DB::table('product_gallery')->where('product_id' , $id)->count();
            $image_url = upload_file($request , 'file' , 'gallery' , 'image_'.$id.rand(1,100));
            if($image_url != null){
                $count++;
                DB::table('product_gallery')->insert([
                    'product_id' => $id,
                    'image_url' => $image_url,
                    'position' => $count,
                ]);
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }

    public function removeImageGallery($id){
        $image = ProductGallery::findOrFail($id);
        $image_url = $image->image_url;
        $image->delete();

        if(file_exists('files/gallery/'.$image_url)){
            unlink('files/gallery/'.$image_url);
        }

        return redirect()->back()->with('message' , 'حذف تصویر با موفقیت انجام شد');
    }

    public function change_images_status($id , Request $request){
        $n=1;
        $parameters = $request->get('parameters');
        $parameters = explode(',' , $parameters);
        foreach ($parameters as $key => $value) {
            if(!empty($value)){
                DB::table('product_gallery')->where('id' , $value)->update(['position' => $n]);
                $n++;
            }
        }
        return 'ok';
    }

    public function item($id){
        $product = Product::where('id' , $id)->select(['id' , 'title' , 'cat_id'])->firstOrFail();
        $product_item = Item::getProductItem($product);
        return view('product.item' , compact('product' , 'product_item'));
    }

    public function add_item($id , Request $request){
        $product = Product::where('id', $id)->select(['id' , 'title' , 'cat_id'])->firstOrFail();
        $item_value = $request->get('item_value');
        DB::table('item_value')->where(['product_id' => $id])->delete();
        foreach ($item_value as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if(!empty($value2)){
                    DB::table('item_value')->insert([
                        'product_id' => $id,
                        'item_id' => $key,
                        'item_value' => $value2
                    ]);
                }
            }
        }

        return redirect()->back()->with('message' , 'ثبت مشخصات فنی برای محصول انجام شد ');
    }
}
