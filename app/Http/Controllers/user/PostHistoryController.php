<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Type;
use App\Models\House;

class PostHistoryController extends Controller
{
    public function PostHistoryView(){
        return view("user.post_history");
    }

    public function GetHouseList(){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house_details = House::with('city:city_name,id','area:area_name,id','type:type,id')
        ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image", "status")
        ->where('created_by', session('id'))
        ->get();
        
        // $house_details = House::select('houses.id','B.id AS city_id','B.city_name',
        //         'C.id AS area_id','C.area_name')
        //         ->leftJoin('cities AS B', 'B.id', '=', 'houses.city_id')
        //         ->leftJoin('areas AS C', 'C.id', '=', 'houses.area_id')
        //         ->leftJoin('types AS D', 'D.id', '=', 'houses.type_id')
        //         ->where('houses.status', '=', 1)
        //         ->where('houses.created_by', '=', session('id'))
        //         ->get();  
                     
        $data = $house_details->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }

    public function MoveToTrash(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house=House::where('id',$request['id'])->delete();
                 
        if($house == 1){
            $output['status'] = 'Success';
            $output['message'] = 'Data Moved to trash';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Sorry something went wrong';
        }
       return $output;
    }

    public function UpdateHouse(Request $request){
        if(!$request['selCity']){
            $output['status'] = 'Error';
            $output['message'] = 'City/Town is required';
            return $output;
        }
        if(!$request['selArea']){
            $output['status'] = 'Error';
            $output['message'] = 'Area is required';
            return $output;
        }
        if(!$request['selHouseType']){
            $output['status'] = 'Error';
            $output['message'] = 'City/Town is required';
            return $output;
        }
        if(!$request['txtAdvance']){
            $output['status'] = 'Error';
            $output['message'] = 'Advance is required';
            return $output;
        }
        if(!$request['txtRentAmount']){
            $output['status'] = 'Error';
            $output['message'] = 'Rent is required';
            return $output;
        }
        if(!$request['txtAvailableFromDate']){
            $output['status'] = 'Error';
            $output['message'] = 'Available from date is required';
            return $output;
        }
        if(!$request['txtContactNo']){
            $output['status'] = 'Error';
            $output['message'] = 'Contact number is required';
            return $output;
        }
        if(!$request['txtDetailedAddress']){
            $output['status'] = 'Error';
            $output['message'] = 'Detailed address is required';
            return $output;
        }

        $house = House::find($request['id']);
            $house->city_id = $request['selCity'];
            $house->area_id = $request['selArea'];
            $house->type_id = $request['selHouseType'];
            $house->advance = $request['txtAdvance'];
            $house->rent = $request['txtRentAmount'];
            $house->from_date = $request['txtAvailableFromDate'];
            $house->contact_no = $request['txtContactNo'];
            $house->detailed_address = $request['txtDetailedAddress'];
            $house->updated_by = session('id');
            $house->updated_at = date("Y-m-d H:i:s");
            $house->save();
           
            $output['status'] = 'Success';
            $output['message'] = 'Data updated successfully';
           
           return $output;
    }
// Trash Functions-------------------------------------------
    public function MyTrashView(){
        return view("user.trash");
    }
    public function GetTrashHouseList(){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house_details = House::with('city:city_name,id','area:area_name,id','type:type,id')
        ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "status")
        ->where('created_by', session('id'))
        ->onlyTrashed()
        ->get();
                    
        $data = $house_details->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }
    public function RestoreHouse(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house=House::where('id',$request['id'])->restore();
                 
        if($house == 1){
            $output['status'] = 'Success';
            $output['message'] = 'Data Restored successfully';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Sorry something went wrong';
        }
       return $output;
    }
    public function DeleteHouse(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $house=House::where('id',$request['id'])->forceDelete();
                 
        if($house == 1){
            $output['status'] = 'Success';
            $output['message'] = 'Data deleted successfully';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Sorry something went wrong';
        }
       return $output;
    }
// API methods
    public function GetAPIHouseList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        if(auth()->check() == 1){
            $house_details = House::with('city:city_name,id','area:area_name,id','type:type,id')
            ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image", "status")
            ->where('created_by', $request['user_id'])
            ->get();
          
            $data = $house_details->toArray();
            foreach($data as $row){  
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
        return $output;
    }
    public function GetAPIHouseData(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        if(auth()->check() == 1){
            $house_details = House::with('city:city_name,id','area:area_name,id','type:type,id')
            ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image", "status")
            ->where('id', $request['id'])
            ->get();
          
            $data = $house_details->toArray();
            foreach($data as $row){  
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
        return $output;
    }
    public function UpdateAPIHouse(Request $request){
        if(auth()->check() == 1){
            if(!$request['selCity']){
                $output['status'] = 'Error';
                $output['message'] = 'City/Town is required';
                return $output;
            }
            if(!$request['selArea']){
                $output['status'] = 'Error';
                $output['message'] = 'Area is required';
                return $output;
            }
            if(!$request['selHouseType']){
                $output['status'] = 'Error';
                $output['message'] = 'City/Town is required';
                return $output;
            }
            if(!$request['txtAdvance']){
                $output['status'] = 'Error';
                $output['message'] = 'Advance is required';
                return $output;
            }
            if(!$request['txtRentAmount']){
                $output['status'] = 'Error';
                $output['message'] = 'Rent is required';
                return $output;
            }
            if(!$request['txtAvailableFromDate']){
                $output['status'] = 'Error';
                $output['message'] = 'Available from date is required';
                return $output;
            }
            if(!$request['txtContactNo']){
                $output['status'] = 'Error';
                $output['message'] = 'Contact number is required';
                return $output;
            }
            if(!$request['txtDetailedAddress']){
                $output['status'] = 'Error';
                $output['message'] = 'Detailed address is required';
                return $output;
            }
            $house = House::find($request['id']);
                $house->city_id = $request['selCity'];
                $house->area_id = $request['selArea'];
                $house->type_id = $request['selHouseType'];
                $house->advance = $request['txtAdvance'];
                $house->rent = $request['txtRentAmount'];
                $house->from_date = $request['txtAvailableFromDate'];
                $house->contact_no = $request['txtContactNo'];
                $house->detailed_address = $request['txtDetailedAddress'];
                $house->updated_by = $request['user_id'];
                $house->updated_at = date("Y-m-d H:i:s");
                $house->save();
            $output['status'] = 'Success';
            $output['message'] = 'Data updated successfully';
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }  
        return $output;
    }
    public function DeleteAPIHouse(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        if(auth()->check() == 1){
            $house=House::where('id',$request['id'])->forceDelete();
                 
            if($house == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Data deleted successfully';
            }else{
                $output['status'] = 'Failure';
                $output['message'] = 'Sorry something went wrong';
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
       return $output;
    }
}
