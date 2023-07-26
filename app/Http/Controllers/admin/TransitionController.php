<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Type;
use App\Models\House;

class TransitionController extends Controller
{
    public function TransitionView(){
        return view("admin.transition");
    }

    public function GetHouseDetailsList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());

        $total_house = House::select('id')
                ->where('from_date','>', date("Y-m-d"))
                ->get();
        $output['iTotalDisplayRecords'] = COUNT($total_house);
        $search_keyword = $request['search']['value'];

        $house_details = House::with('user:email,id','city:city_name,id','area:area_name,id','type:type,id')
        ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image","created_by")
        ->where('from_date','>', date("Y-m-d")) 
        ->when($search_keyword, function ($query, $search_keyword) {
            $query->where('contact_no', 'LIKE', '%'. $search_keyword .'%');
        })->limit($request['length'])
        ->offset($request['start'])
        ->get(); 

        $data = $house_details->toArray();
        $slno = $request['start'] + 1; 
        $output['iTotalRecords'] = COUNT($data);
        foreach($data as $row){  
            $row['sl_no'] = $slno;
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
            $slno++;
        }
        return $output;
    }
}
