<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Setting
{
    public function set_data($data)
    {
        $update_data = array();
        foreach ($data as $key => $value) {
            if ($key != "_token") {
                $this->add_table($key, $value);
                $update_data[$key] = $value;
            }
        }
        return $update_data;
    }

    public function add_table($key, $value)
    {
        $row = DB::table('setting')->where('option_name', $key)->first();
        if ($row) {
            if (!empty($value)) {
                DB::table('setting')->where('option_name', $key)->update(['option_value'=>$value]);
            } else {
                DB::table('setting')->where('option_name', $key)->delete();
            }
        } else {
            if (!empty($value)) {
                DB::table('setting')->insert(['option_name' => $key , 'option_value' => $value]);
            }
        }
    }

    public function get_data($keys)
    {
        $fetch_data = array();
        foreach ($keys as $option_name) {
            $row = DB::table('setting')->where('option_name', $option_name)->first();
            if ($row) {
                $fetch_data[$option_name] = $row->option_value;
            } else {
                $fetch_data[$option_name] = '';
            }
        }
        return $fetch_data;
    }

    public static function get_value($option_name){
        $row=DB::table('setting')->where('option_name',$option_name)->first();
        if($row)
        {
            return $row->option_value;
        }
        else{
            return  '';
        }
    }
}
