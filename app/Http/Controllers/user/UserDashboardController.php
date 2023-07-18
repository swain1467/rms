<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function View(){
        return view("user.user_dashboard");
    }
    public function FindView(){
        return view("user.find");
    }

    public function SignOut(){
        session()->flush();
        return redirect(route('user_sign_in'));
    }
}
