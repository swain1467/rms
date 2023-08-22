<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

use App\Service\SignUpService;

class SignUpController extends Controller
{
    public function SignUpView(){
        return view("user.signup");
    }

    public function Save(Request $request){
        SignUpService::validateData($request);
        $count = SignUpService::checkDuplicate($request);
        if($count){
            return 'This email address is already exist.';
        }else{
            SignUpService::saveData($request);
        }
        return redirect(route('user_sign_in'));
    }
//API--------------------------------------
    public function Register(Request $request){
        $output = SignUpService::validateAPIData($request);
        if(!$output){
            $count = SignUpService::checkAPIDuplicate($request);   
            if($count){
                $output['status'] = 'Error';
                $output['message'] = 'This email address is already exist.';
                return $output;
            }else{
                SignUpService::saveAPIData($request);
                $output['status'] = 'Success';
                $output['message'] = 'You have successfull Signed up.';
                return $output;
            }
        }else{
            return $output;
        }
    }
}
