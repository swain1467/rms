<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Area;
use App\Models\Type;
use App\Models\House;

use App\Service\PostService;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    
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
        ->where('status', 1)
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
        PostService::validateData($request);
        $path = PostService::saveImage($request);
        PostService::saveData($request, $path);
        return redirect(route('post_history'));
    }
    //API methods
    public function SavePostProperty(Request $request){
        if(auth()->check() == 1){
            $output = PostService::validateAPIData($request);
            if(!$output){
                PostService::saveAPIData($request);
                $output['status'] = 'Success';
                $output['message'] = 'Proprty posted successfully';
            }else{
                return $output;
            }
        }else{
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Access Please log in';
        }
        return $output;
    }

    public function GetAPICity(){
        $output = array('status' => '', 'aaData[]' => array());
        if(auth()->check() == 1){
            $city = City::select('id', 'city_name')
            ->where('status', '=', 1)
            ->get();

            $data = $city->toArray();
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

    public function GetAPIArea(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        // $area = City::with('area:id,area_name,city_id')
        // ->select('city_name','id')
        // ->get();
        // // echo'<pre>'; dd($area); 
        // // die;
        if(auth()->check() == 1){
            $area = Area::with('city:city_name,id')
            ->select("id", "area_name", "city_id")
            ->where('city_id', $request['city_id'])
            ->where('status', 1)
            ->get();
                         
            $data = $area->toArray();
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

    public function GetAPIType(){
        $output = array('status' => '', 'aaData[]' => array());
        if(auth()->check() == 1){
            $type = Type::select('id', 'type')
                ->where('status', '=', 1)
                ->get();

            $data = $type->toArray();
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
}
