<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SignInController extends Controller
{
    public function SignInView(){
        return view("user.signin");
    }

    public function CheckSignIn(Request $request){
        $request->validate(
            [
                "txtEmail" => "required|email",
                "txtPassword" => "required"
            ],
            [
                'txtEmail.required' => 'Email is required',
                'txtEmail.email' => 'Invalid email',
                'txtPassword.required' => 'Password is required'
            ]
        );
        $user = User::select('id', 'name', 'password', 'email', 'user_type')
                ->where('email', '=', $request['txtEmail'])
                ->where('status', '=', 1)
                ->get();

        $data = $user->toArray();
        $password = '';
        foreach($data AS $d){
            $id = $d['id'];
            $name = $d['name'];
            $email = $d['email'];
            $user_type = $d['user_type'];
            $password = $d['password'];
        }
        $verify = password_verify($request['txtPassword'], $password);
    
        if($verify){
            session()->put('id',$id);
            session()->put('name',$name);
            session()->put('email',$email);
            session()->put('user_type',$user_type);

            return redirect(route('user_dashboard'));
        }else if(COUNT($data)!=1){
            echo'Invalid email address.';
        } else{
            echo'Invalid password.';
        }
    }
}