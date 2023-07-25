<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function ActiveUsersView(){
        return view("admin.active_users");
    }

    public function GetActiveUsersList(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
        ];
        $total_user = User::select('id')
                ->where('status', 1)
                ->get();
        $output['iTotalDisplayRecords'] = COUNT($total_user);
        $search_keyword = $request['search']['value'];
        $user = User::select('id', 'name', 'email', 'user_type', 'status')
                ->where('status', '=', 1)
                ->Where(function ($query) use ($search_keyword) {
                    $query->orWhere('name', 'LIKE', '%'. $search_keyword .'%')
                    ->orWhere('email', 'LIKE', '%'. $search_keyword .'%')
                    ->orWhere('user_type', 'LIKE', '%'. $search_keyword .'%');
                })->limit($request['length'])
                ->offset($request['start'])
                ->orderBy('name','ASC')
                ->get();

        $data = $user->toArray();
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

    public function UpdateUserDetails(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['name']){
            $output['status'] = 'Error';
            $output['message'] = 'Name is required';
            return $output;
        }

        if(!$request['email']){
            $output['status'] = 'Error';
            $output['message'] = 'Email is required';
            return $output;
        }
        if(!$request['user_type']){
            $output['status'] = 'Error';
            $output['message'] = 'User Type required';
            return $output;
        }

        $update = User::where("id", $request['id'])->
        update(["name" => $request['name'], "email" => $request['email'],
                "user_type" => $request['user_type'], "updated_at" => date("Y-m-d H:i:s")]);
        
        if($update == 1){
            $output['status'] = 'Success';
            $output['message'] = 'User data  updated successfully';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! Something went wrong';
        }
       return $output;
    }

    public function BlackListUser(Request $request){
        $output = array('status' => '', 'message' => '');

        $update = User::where("id", $request['id'])->
        update(["status" => 0, "updated_at" => date("Y-m-d H:i:s")]);
        
        if($update == 1){
            $output['status'] = 'Success';
            $output['message'] = 'User black listed';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! Something went wrong';
        }
       return $output;
    }

    public function DeleteUser(Request $request){
        $output = array('status' => '', 'aaData[]' => array());
        
        $user=User::where('id',$request['id'])->delete();
                 
        if($user == 1){
            $output['status'] = 'Success';
            $output['message'] = 'User deleted';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Sorry something went wrong';
        }
       return $output;
    }
//Black List Users All functions 
}
