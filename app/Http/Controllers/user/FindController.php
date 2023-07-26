<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Type;
use App\Models\House;

class FindController extends Controller
{
    public function FindView(){
        return view("user.find");
    }

    public function GetAvailableHouseList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house_details = House::with('user:name,id','city:city_name,id','area:area_name,id','type:type,id')
        ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image","created_by")
        ->where('from_date','>', date("Y-m-d")) 
        ->where('status', 1) 
        ->when($request->get('city'), function ($query, $city) {
            $query->where('city_id', $city);
        })
        ->when($request->get('area'), function ($query, $area) {
            $query->where('area_id', $area);
        })
        ->when($request->get('type'), function ($query, $type) {
            $query->where('type_id', $type);
        })
        ->get(); 

        $data = $house_details->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }

}
