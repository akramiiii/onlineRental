<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CustomController;
use App\Item;

class ItemController extends CustomController
{
    public function item($id){
        $category = Category::findOrFail($id);
        $items = Item::with('getChild')->where(['category_id' => $id , 'parent_id' => 0])->orderBy('position' , 'ASC')->get();
        return view('item.index' , compact('category' , 'items'));
    }

    public function add_item($cat_id , Request $request){
        $items = $request->get('item' , array());
        $child_item = $request->get('child_item' , array());
        $checked_item = $request->get('check_box_item' , array());

        Item::addItem($items , $child_item , $checked_item , $cat_id);

        return redirect()->back()->with('message' , 'ثبت مشخصات با موفقیت انجام شد');
    }

    public function destroy($id){
        $item = Item::findOrFail($id);
        $item->getChild()->delete();
        $item->delete();

        return redirect()->back()->with('message' , 'حذف مشخصات با موفقیت انجام شد');
    }
}
