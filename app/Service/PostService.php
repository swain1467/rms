<?php
namespace App\Service;

use Illuminate\Http\Request;
use App\Models\House;

class PostService{
    public static function validateData(Request $request){
        return $request->validate(
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
    }

    public static function saveImage(Request $request){
        // $file = $request->file('filImage')->store('postimage');

        $fileName = $request['selCity'].$request['selArea'].$request['selHouseType']
                    .date("dmyHis").'.'.$request['filImage']->extension();
        
        $path = $request->filImage->storeAs('postimage', $fileName);
        return $path;
    }

    public static function saveData(Request $request, $path){
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
    }
    public static function validateAPIData(Request $request){
        $output = array('status' => '', 'message' => '');
        if(!$request['selCity']){
            $output['status'] = 'Error';
            $output['message'] = 'City is required';
            return $output; 
        }
        if(!$request['selArea']){
            $output['status'] = 'Error';
            $output['message'] = 'Area required';
            return $output;
        }
        if(!$request['selHouseType']){
            $output['status'] = 'Error';
            $output['message'] = 'Property type required';
            return $output;
        }
        if(!$request['txtRentAmount']){
            $output['status'] = 'Error';
            $output['message'] = 'Rent required';
            return $output;
        }
        if(!$request['txtAdvance']){
            $output['status'] = 'Error';
            $output['message'] = 'Advance required';
            return $output;
        }
        if(!$request['txtAvailableFromDate']){
            $output['status'] = 'Error';
            $output['message'] = 'Available from required';
            return $output;
        }
        if(!$request['txtContactNo']){
            $output['status'] = 'Error';
            $output['message'] = 'Contact no required';
            return $output;
        }
        if(!$request['txtDetailedAddress']){
            $output['status'] = 'Error';
            $output['message'] = 'Address required';
            return $output;
        }
    }
    public static function saveAPIData(Request $request){
        $house = new House;
            $house->city_id = $request['selCity'];
            $house->area_id = $request['selArea'];
            $house->type_id = $request['selHouseType'];
            $house->advance = $request['txtAdvance'];
            $house->rent = $request['txtRentAmount'];
            $house->from_date = $request['txtAvailableFromDate'];
            $house->contact_no = $request['txtContactNo'];
            $house->detailed_address = $request['txtDetailedAddress'];
            $house->created_by = $request['user_id'];
            $house->updated_by = $request['user_id'];
            $house->created_at = date("Y-m-d H:i:s");
            $house->updated_at = date("Y-m-d H:i:s");
            $house->image = 'Vue API Image';
            $house->status = 1;
            $house->save();
    }
}