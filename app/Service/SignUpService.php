<?php
namespace App\Service;

use Illuminate\Http\Request;
use App\Models\User;

class SignUpService{
    public static function validateData(Request $request){
        return $request->validate(
            [
                "txtName" => "required",
                "txtEmail" => "required|email",
                "txtPassword" => "required",
                "txtConfPassword" => "required|same:txtPassword"
            ],
            [
                'txtName.required' => 'Name is required',
                'txtEmail.required' => 'Email is required',
                'txtEmail.email' => 'Invalid email',
                'txtPassword.required' => 'Password is required',
                'txtConfPassword.required' => 'Confirm password is required',
                'txtConfPassword.same' => 'Password and confirm password must be same'
            ]
        );
    }

    public static function checkDuplicate(Request $request){
        $user = User::select('id', 'name', 'password', 'email')
                ->where('email', '=', $request['txtEmail'])
                ->get();
        $data = $user->toArray();
        return COUNT($data);
    }

    public static function saveData(Request $request){
        $user = new User;
            $user->name = $request['txtName'];
            $user->email = $request['txtEmail'];
            $user->otp = '';
            $user->password = password_hash($request['txtPassword'], PASSWORD_DEFAULT);
            $user->status = 1;
            $user->save();
    }
    // API Data-------------------------------------
    public static function validateAPIData(Request $request){
        $output = array('status' => '', 'message' => '');
        if(!$request['txtName']){
            $output['status'] = 'Error';
            $output['message'] = 'Name is required';
            return $output; 
        }
        if(!$request['txtEmail']){
            $output['status'] = 'Error';
            $output['message'] = 'Email is required';
            return $output;
        }
        if (!filter_var($request['txtEmail'], FILTER_VALIDATE_EMAIL)){
            $output['status'] = 'Error';
            $output['message'] = 'Invalid email format';
            return $output;
        }
        if(!$request['txtPassword']){
            $output['status'] = 'Error';
            $output['message'] = 'Password is required';
            return $output;
        }
        if(!$request['txtConfPassword']){
            $output['status'] = 'Error';
            $output['message'] = 'Confirm password is required';
            return $output;
        }
        if($request['txtPassword'] != $request['txtConfPassword']){
            $output['status'] = 'Error';
            $output['message'] = 'Password and Confirm password must be same';
            return $output;
        }
    }

    public static function checkAPIDuplicate(Request $request){
        $user = User::select('id', 'name', 'password', 'email')
                ->where('email', '=', $request['txtEmail'])
                ->get();
        $data = $user->toArray();
        return COUNT($data);
    }

    public static function saveAPIData(Request $request){
        $user = new User;
            $user->name = $request['txtName'];
            $user->email = $request['txtEmail'];
            $user->otp = '';
            $user->password = password_hash($request['txtPassword'], PASSWORD_DEFAULT);
            $user->status = 1;
            $user->save();
    }
}