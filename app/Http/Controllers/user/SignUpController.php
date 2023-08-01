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
}
