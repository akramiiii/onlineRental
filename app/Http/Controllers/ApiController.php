<?php

namespace App\Http\Controllers;

use App\City;
use App\Pledge;
use App\Delivery;
use App\Province;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_province(){
        $province = Province::orderBy('id' , 'ASC')->get();
        return $province;
    }

    public function get_city($province_id){
        $city = City::where('province_id' , $province_id)->orderBy('id' , 'ASC')->get();
        return $city;
    }

    public function get_pledge(){
        $pledge = Pledge::orderBy('id' , 'ASC')->get();
        return $pledge;
    }

    public function get_delivery(){
        $delivery = Delivery::orderBy('id', 'ASC')->get();
        return $delivery;
    }
}
