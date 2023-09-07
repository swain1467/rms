<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Type;

class SetupController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function SetupView(){
        return view("admin.setup");
    }

    public function GetCityList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $total_city = City::select('id')
                ->get();
        $output['iTotalDisplayRecords'] = COUNT($total_city);
        $search_keyword = $request['search']['value'];
        $city = City::select('id', 'city_name', 'status')
                ->Where('city_name', 'LIKE', '%'. $search_keyword .'%')
                ->limit($request['length'])
                ->offset($request['start'])
                ->orderBy('city_name','ASC')
                ->get();

        $data = $city->toArray();
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
    public function SaveCity(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['city_name']){
            $output['status'] = 'Error';
            $output['message'] = 'City/Town is required';
            return $output;
        }
        
        if($request['city_id'] == ''){
            $city = new City;
            $city->city_name = $request['city_name'];
            $city->contact_person = session('id');
            $city->status = $request['city_status'];
            $city->contact_on = '7846993676';
            $city->created_at = date("Y-m-d H:i:s");
            $city->created_by = session('id');
            $city->updated_at = date("Y-m-d H:i:s");
            $city->updated_by = session('id');
            $city->save();
            $output['status'] = 'Success';
            $output['message'] = 'City  added successfully';
        }else{
            $update = City::where("id", $request['city_id'])->
            update(["city_name" => $request['city_name'], "status" => $request['city_status'],
                    "updated_by" => session('id'), "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'City  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }

    public function GetAreaList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $area = Area::with('city:city_name,id')
        ->select("id", "area_name", "status", "city_id")
        ->where('city_id', $request['city_id'])
        ->get();

        $data = $area->toArray();
        $slno = 1; 
        foreach($data as $row){  
            $row['sl_no'] = $slno;
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
            $slno++;
        }
        return $output;
    }
    
    public function SaveArea(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['area_name']){
            $output['status'] = 'Error';
            $output['message'] = 'Area is required';
            return $output;
        }
        
        if($request['area_id'] == ''){
            $type = new Area;
            $type->area_name = $request['area_name'];
            $type->city_id = $request['city_id'];
            $type->status = $request['area_status'];
            $type->created_at = date("Y-m-d H:i:s");
            $type->created_by = session('id');
            $type->updated_at = date("Y-m-d H:i:s");
            $type->updated_by = session('id');
            $type->save();
            $output['status'] = 'Success';
            $output['message'] = 'Area  added successfully';
        }else{
            $update = Area::where("id", $request['area_id'])->
            update(["area_name" => $request['area_name'], "status" => $request['area_status'],
                    "updated_by" => session('id'), "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Area  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }

    public function GetHouseTypeList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        if(auth()->check() == 1){
            $type = Type::select('id', 'type', 'status')
                ->orderBy('type','ASC')
                ->get();

            $data = $type->toArray();
            $slno = 1; 
            foreach($data as $row){  
                $row['sl_no'] = $slno;
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
                $slno++;
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
        return $output;
    }

    public function SaveHouseType(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['type']){
            $output['status'] = 'Error';
            $output['message'] = 'House type is required';
            return $output;
        }
        
        if($request['id'] == ''){
            $type = new Type;
            $type->type = $request['type'];
            $type->status = $request['type_status'];
            $type->created_at = date("Y-m-d H:i:s");
            $type->created_by = session('id');
            $type->updated_at = date("Y-m-d H:i:s");
            $type->updated_by = session('id');
            $type->save();
            $output['status'] = 'Success';
            $output['message'] = 'Type  added successfully';
        }else{
            $update = Type::where("id", $request['id'])->
            update(["type" => $request['type'], "status" => $request['type_status'],
                    "updated_by" => session('id'), "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Type  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }
//API Data-------------------------------------- 
    public function GetCityListAPI(Request $request){
        $output = array('status' => '', 'aaData[]' => array(), 'aaData1[]' => array());
        
        $city = City::select('id', 'city_name', 'status')
                ->orderBy('city_name','ASC')
                ->get();

        $data = $city->toArray();
        $slno = 1; 
        foreach($data as $row){  
            $row['sl_no'] = $slno;
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
            $slno++;
        }
        
        $city = City::select('id', 'city_name')
                ->where('status', 1)
                ->orderBy('city_name','ASC')
                ->get();

        $data = $city->toArray();
        foreach($data as $row){  
            $output['aaData1'][] = $row;
        }
        return $output;
    }

    public function SaveCityAPI(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['city_name']){
            $output['status'] = 'Error';
            $output['message'] = 'City/Town is required';
            return $output;
        }
        
        if($request['city_id'] == ''){
            $city = new City;
            $city->city_name = $request['city_name'];
            $city->contact_person = $request['id'];
            $city->status = $request['city_status'];
            $city->contact_on = '7846993676';
            $city->created_at = date("Y-m-d H:i:s");
            $city->created_by = $request['id'];
            $city->updated_at = date("Y-m-d H:i:s");
            $city->updated_by = $request['id'];
            $city->save();
            $output['status'] = 'Success';
            $output['message'] = 'City  added successfully';
        }else{
            $update = City::where("id", $request['city_id'])->
            update(["city_name" => $request['city_name'], "status" => $request['city_status'],
                    "updated_by" => $request['id'], "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'City  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }

    public function GetAreaListAPI(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $area = Area::with('city:city_name,id')
        ->select("id", "area_name", "status", "city_id")
        ->where('city_id', $request['city_id'])
        ->get();

        $data = $area->toArray();
        $slno = 1; 
        foreach($data as $row){  
            $row['sl_no'] = $slno;
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
            $slno++;
        }
        return $output;
    }
    public function SaveAreaAPI(Request $request){
        $output = array('status' => '', 'message' => '');
        if(!$request['city_id']){
            $output['status'] = 'Error';
            $output['message'] = 'City is required';
            return $output;
        }
        if(!$request['area_name']){
            $output['status'] = 'Error';
            $output['message'] = 'Area is required';
            return $output;
        }
        
        if($request['area_id'] == ''){
            $type = new Area;
            $type->area_name = $request['area_name'];
            $type->city_id = $request['city_id'];
            $type->status = $request['area_status'];
            $type->created_at = date("Y-m-d H:i:s");
            $type->created_by = $request['id'];
            $type->updated_at = date("Y-m-d H:i:s");
            $type->updated_by = $request['id'];
            $type->save();
            $output['status'] = 'Success';
            $output['message'] = 'Area  added successfully';
        }else{
            $update = Area::where("id", $request['area_id'])->
            update(["area_name" => $request['area_name'], "status" => $request['area_status'],
                    "updated_by" => $request['id'], "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Area  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }

    public function GetHouseTypeListAPI(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        if(auth()->check() == 1){
            $type = Type::select('id', 'type', 'status')
                ->orderBy('type','ASC')
                ->get();

            $data = $type->toArray();
            $slno = 1; 
            foreach($data as $row){  
                $row['sl_no'] = $slno;
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
                $slno++;
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
        return $output;
    }

    public function SaveHouseTypeAPI(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['type']){
            $output['status'] = 'Error';
            $output['message'] = 'House type is required';
            return $output;
        }
        
        if($request['type_id'] == ''){
            $type = new Type;
            $type->type = $request['type'];
            $type->status = $request['type_status'];
            $type->created_at = date("Y-m-d H:i:s");
            $type->created_by = $request['id'];
            $type->updated_at = date("Y-m-d H:i:s");
            $type->updated_by = $request['id'];
            $type->save();
            $output['status'] = 'Success';
            $output['message'] = 'Type  added successfully';
        }else{
            $update = Type::where("id", $request['type_id'])->
            update(["type" => $request['type'], "status" => $request['type_status'],
                    "updated_by" => $request['id'], "updated_at" => date("Y-m-d H:i:s")]);
            
            if($update == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Type  updated successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! Something went wrong';
            }
        }
       return $output;
    }
}
