<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Area;
use App\Models\Type;
use App\Models\House;

class PostController extends Controller
{
    
    public function PostView(){
        return view("user.post");
    }

    public function GetCity(){
        $output = array('status' => '', 'aaData[]' => array());
        
        $city = City::select('id', 'city_name')
                ->where('status', '=', 1)
                ->get();

        $data = $city->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }

    public function GetArea(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        // $area = City::with('area:id,area_name,city_id')
        // ->select('city_name','id')
        // ->get();
        // // echo'<pre>'; dd($area); 
        // // die;
        
        $area = Area::with('city:city_name,id')
        ->select("id", "area_name", "city_id")
        ->where('city_id', $request['city_id'])
        ->get();
                     
        $data = $area->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }

    public function GetType(){
        $output = array('status' => '', 'aaData[]' => array());
        
        $type = Type::select('id', 'type')
                ->where('status', '=', 1)
                ->get();

        $data = $type->toArray();
        foreach($data as $row){  
            $output['aaData'][] = $row;
            $output['status'] = 'Success';
        }
        return $output;
    }

    public function SavePost(Request $request){
        $request->validate(
            [
                "selCity" => "required",
                "selArea" => "required",
                "selHouseType" => "required",
                "txtAdvance" => "required|integer",
                "txtRentAmount" => "required|integer",
                "txtAvailableFromDate" => "required",
                "txtContactNo" => "required|digits_between:10,10",
                "txtDetailedAddress" => "required",
                "filImage" => "required"
            ],
            [
                'selCity.required' => 'City is required',
                'selArea.required' => 'Area is required',
                'selHouseType.required' => 'Type is required',
                'txtAdvance.required' => 'Advance required',
                'txtRentAmount.required' => 'Rent is required',
                'txtAvailableFromDate.required' => 'Available From is required',
                'txtContactNo.required' => 'Contact no. is required',
                'txtDetailedAddress.required' => 'Address is required',
                'filImage.required' => 'Image is required',

                'txtAdvance.integer' => 'Advance must be a number',
                'txtRentAmount.integer' => 'Rent must be a number',
                'txtContactNo.digits_between' => 'Contact no shoud be 10 digits'
            ]
        );

        $file = $request->file('filImage')->store('postimage');
        $fileName = $request['selCity'].$request['selArea'].$request['selHouseType']
                    .date("dmyHis").'.'.$request['filImage']->extension();
        
        $path = $request->filImage->storeAs('postimage', $fileName);

        $house = new House;
            $house->city_id = $request['selCity'];
            $house->area_id = $request['selArea'];
            $house->type_id = $request['selHouseType'];
            $house->advance = $request['txtAdvance'];
            $house->rent = $request['txtRentAmount'];
            $house->from_date = $request['txtAvailableFromDate'];
            $house->contact_no = $request['txtContactNo'];
            $house->detailed_address = $request['txtDetailedAddress'];
            $house->created_by = session('id');
            $house->updated_by = session('id');
            $house->created_at = date("Y-m-d H:i:s");
            $house->updated_at = date("Y-m-d H:i:s");
            $house->image = $path;
            $house->status = 1;
            $house->save();
            
        return redirect(route('post_history'));
    }
}
