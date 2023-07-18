<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function SignUpView(){
        return view("user.signup");
    }

    public function Save(Request $request){
        $request->validate(
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
        //Check Duplicate Email
        $user = User::select('id', 'name', 'password', 'email')
                ->where('email', '=', $request['txtEmail'])
                ->get();

        $data = $user->toArray();
        if(COUNT($data)>0){
            return 'This email address is already exist.';
        }else{
            $user = new User;
            $user->name = $request['txtName'];
            $user->email = $request['txtEmail'];
            $user->otp = '';
            $user->password = password_hash($request['txtPassword'], PASSWORD_DEFAULT);
            $user->status = 1;
            $user->save();
        }

        // Normal Route
        // return redirect("/SignIn");
        // Named Route
        return redirect(route('user_sign_in'));
    }
}
