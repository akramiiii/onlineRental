<?php

namespace App\Http\Controllers\Admin;

use App\ReView;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;

class ReviewController extends CustomController
{
    protected $model='ReView';
    protected $title='بررسی اجمالی';
    protected $route_params='product/review';
    protected $product;
    protected $query_string;
    public function __construct(Request $request)
    {
        // $product_id=$request->get('product_id');
        // $this->product=Product::findOrFail($product_id);
        // $this->query_string='product_id='.$product_id;
    }
    public function index(Request $request)
    {
        $review=ReView::getData($request->all());
        $trash_review_count=ReView::onlyTrashed()->count();
        return view('review.index', ['review'=>$review,'trash_review_count'=>$trash_review_count,'product'=>$this->product]);
    }
    public function create()
    {
        return view('review.create', ['product'=>$this->product]);
    }
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required','tozihat'=>'required'], [], [
            'title'=>'عنوان بررسی اجمالی',
            'tozihat'=>'توضیحات'
        ]);
        $review=new ReView($request->all());
        $review->product_id=$this->product->id;
        $review->saveOrFail();
        return redirect('admin/product/review?product_id='.$this->product->id)
            ->with('message', 'ثبت بررسی اجمالی با موفقیت انجام شد');
    }
    public function edit($id)
    {
        $review=ReView::findOrFail($id);
        return view('review.edit', [
            'product'=>$this->product,
            'review'=>$review
        ]);
    }
    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, ['title'=>'required','tozihat'=>'required'], [], [
    //         'title'=>'عنوان بررسی اجمالی',
    //         'tozihat'=>'توضیحات'
    //     ]);
    //     $review=ReView::findOrFail($id);
    //     $review->update($request->all());
    //     return redirect('admin/product/review?product_id='.$this->product->id)
    //         ->with('message', 'ویرایش بررسی اجمالی با موفقیت انجام شد');
    // }
    // public function primary()
    // {
    //     $primary_content=ReView::whereNull('title')->where('product_id', $this->product->id)->first();
    //     $tozihat=$primary_content ? $primary_content->tozihat : '';
    //     return view('review.primary', ['product'=>$this->product,'tozihat'=>$tozihat]);
    // }
    // public function add_primary_content(Request $request)
    // {
    //     DB::table('review_product')->whereNull('title')->where('product_id', $this->product->id)->delete();
    //     if (!empty($request->get('tozihat'))) {
    //         $review=new ReView($request->all());
    //         $review->product_id=$this->product->id;
    //         $review->saveOrFail();
    //     }
    //     return redirect('admin/product/review?product_id='.$this->product->id)
    //         ->with('message', 'ثبت توضیحات با موفقیت انجام شد');
    // }
}
