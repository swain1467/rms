<?php
namespace App\Service;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Type;

class SetupService{
    public function GetCityListAPI(){
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

    public function validateCityData(Request $request){
        $output = array('status' => '', 'message' => '');
        if(!$request['city_name']){
            $output['status'] = 'Error';
            $output['message'] = 'City/Town is required';
            return $output;
        }
    }
    public function saveCityData(Request $request){
        $output = array('status' => '', 'message' => '');
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
}