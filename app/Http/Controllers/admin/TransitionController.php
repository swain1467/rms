<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\HouseExcelTemplate;
use App\Exports\HouseExcelReference;
use App\Imports\HouseDetailsImport;
use Excel;

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
        ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image", "status", "created_by")
        ->where('from_date','>', date("Y-m-d")) 
        ->Where(function ($query) use ($search_keyword) {
            $query->orWhere('contact_no', 'LIKE', '%'. $search_keyword .'%')
            ->orWhere('from_date', 'LIKE', '%'. $search_keyword .'%');
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

    public function UpdateHouseDetails(Request $request){
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
            $house->status = $request['hdStatus'];
            $house->updated_by = session('id');
            $house->updated_at = date("Y-m-d H:i:s");
            $house->save();
           
            $output['status'] = 'Success';
            $output['message'] = 'Data updated successfully';

        return $output;
    }

    public function DeleteHD(Request $request){
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

    public function ExcelTemplateDownload(Request $request){
        // return Excel::download(new HouseExcelTemplate, 'HouseDetailsTemplate.xlsx');
        return new HouseExcelTemplate;
    }

    public function ExcelReferenceDownload(Request $request){
        $area = Area::with('city:city_name,id')
        ->select("id", "area_name", "city_id")
        ->where('status', 1)
        ->orderBy('area_name', 'ASC')
        ->get()->toArray();

        foreach($area as $a){  
            $areas[]['area'] = $a['area_name'];
            $cities[]['city'] = $a['city']['city_name'];
        }

        $type = Type::select('id', 'type', 'status')
                ->orderBy('type','ASC')
                ->get()->toArray();
        foreach($type as $t){  
            $types[]['type'] = $t['type'];
        }
        
    
        $ac = array();
        foreach ($cities as $key => $value){
            $ac[] = (object)array_merge((array)$areas[$key], (array)$value);
        }


        if(count($ac) >= count($types)){
            $arr1 = $ac;
            $arr2 = $types;
            $acg = 1;
        }else{
            $arr1 = $types;
            $arr2 = $ac;
            $acg = 0;
        }
        
        $arrays = array();
        foreach ($arr1 as $key => $value){
            if(isset($arr2[$key])){
                if($acg){
                    $arrays[] = array_merge((array)$value, (array)$arr2[$key]);
                }else{
                    $arrays[] = array_merge((array)$arr2[$key], (array)$value);
                }
            }
            else{
                if($acg){
                    $arrays[] = array_merge((array)$value,['type'=>'']);
                }else{
                    $arrays[] = array_merge(['area'=>'','city'=>''],(array)$value);
                }
            }
        }
        return new HouseExcelReference($arrays);
    }

    public function ExcelPreview(Request $request)
    {
        $output = array();

        $city = City::select('id','city_name')
        ->where('status', 1)
        ->get()->toArray();

        foreach($city as $c){  
            $cities[$c['id']] = $c['city_name'];
        }

        $type = Type::select('id', 'type', 'status')
                ->orderBy('type','ASC')
                ->get()->toArray();
        foreach($type as $t){  
            $types[$t['id']] = $t['type'];
        }

        $formdata = $request->input();
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            (new HouseDetailsImport($cities, $types))->import($file);
            $output['status'] = 'Success';
            $output['message'] = 'Excel uploaded successfully.';
        } else {
            $output['status'] = 'Failure';
            $output['message'] = 'Excel file not found.';
        }
        return $output;
    }
}
