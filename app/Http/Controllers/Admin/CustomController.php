<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CustomController extends BaseController{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function destroy($id){
        $query_string = property_exists($this , 'query_string') ? '&'.$this->query_string : "";

        $model_name = "App\\".$this->model;
        $row = $model_name::withTrashed()->findOrFail($id);
        if ($row->deleted_at == null) {
            $message = " $this->title انتخاب شده به سطل زباله منتقل شد";
            $row->delete();
        }
        else{
            $message = " $this->title انتخاب شده حذف شد ";
            $row->forceDelete();
        }
        return redirect("admin/".$this->route_params."?trashed=true".$query_string)->with('message' , $message);
    }

    public function remove_items(Request $request){
        $query_string = property_exists($this, 'query_string') ? '&'.$this->query_string : "";

        $model_name = "App\\".$this->model;
        $param_name = $this->route_params.'_id';
        $ids = $request->get($param_name , array());
        foreach ($ids as $key => $value) {
            $row = $model_name::withTrashed()->where('id' , $value)->firstOrFail();
            if($row->deleted_at == null){
                $message = " $this->title های انتخاب شده به سطل زباله منتقل شد";
                $row->delete();
            }
            else{
                $message = " $this->title های انتخاب شده حذف شد ";
                $row->forceDelete();
            }
        }
        return redirect("admin/".$this->route_params."?trashed=true".$query_string)->with('message', $message);
    }

    public function restore_items(Request $request){
        $query_string = property_exists($this, 'query_string') ? '&'.$this->query_string : "";

        $model_name = "App\\".$this->model;
        $param_name = $this->route_params.'_id';
        $ids = $request->get($param_name, array());
        foreach ($ids as $key => $value) {
            $row = $model_name::withTrashed()->where('id', $value)->firstOrFail();
            $row->restore();
        }
        return redirect("admin/".$this->route_params."?trashed=true".$query_string)->with('message', "بازیابی $this->title ها با موفقیت انجام شد ");
    }

    public function restore($id){
        $query_string = property_exists($this, 'query_string') ? '&'.$this->query_string : "";

        $model_name = "App\\".$this->model;
        $row = $model_name::withTrashed()->where('id', $id)->firstOrFail();
        $row->restore();
        return redirect("admin/".$this->route_params."?trashed=true".$query_string)->with('message', "بازیابی $this->title با موفقیت انجام شد ");
    }
}