<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\MailNotify;
use Mail;

class RetrievePasswordController extends Controller
{
    public function RetrievePasswordView(){
        return view("user.retrivepassword");
    }

    public function SendOTP(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['email']){
            $output['status'] = 'Error';
            $output['message'] = 'Email is required';
            return $output;
        }
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){
            $output['status'] = 'Error';
            $output['message'] = 'Invalid email format';
            return $output;
        }

        $user = User::select('id', 'name', 'password', 'email')
                ->where('email', '=', $request['email'])
                ->where('status', '=', 1)
                ->get();

        $data = $user->toArray();
        if(COUNT($data)>0){

            $otp = rand(1000,9999);

            $update = User::where("email", $request['email'])->update(["otp" => $otp, "updated_at" => date("Y-m-d H:i:s")]);

            $mailData = [
                'title' => 'Please enter this below OTP for verification',
                'body' => $otp
            ];
            Mail::to($request['email'])->send(new MailNotify($mailData));

            $output['status'] = 'Success';
            $output['message'] = 'An OTP has been sent to your mail id';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'This email id is not registered';
        }
       return $output;
    }

    public function Verify(Request $request){
        $output = array('status' => '', 'message' => '');
        
        if(!$request['otp']){
            $output['status'] = 'Error';
            $output['message'] = 'OTP is required';
            return $output;
        }

        if(!$request['password']){
            $output['status'] = 'Error';
            $output['message'] = 'Password is required';
            return $output;
        }
        if(!$request['confirm_password']){
            $output['status'] = 'Error';
            $output['message'] = 'Confirm password is required';
            return $output;
        }

        $update = User::where("email", $request['email'])->
                        where("otp", $request['otp'])->
        update(["password" => password_hash($request['password'], PASSWORD_DEFAULT), 
                "updated_at" => date("Y-m-d H:i:s")]);
        
        if($update == 1){
            $output['status'] = 'Success';
            $output['message'] = 'New password set successfully';
        }else{
            $output['status'] = 'Failure';
            $output['message'] = 'Invalid OTP';
        }
       return $output;
    }
}
