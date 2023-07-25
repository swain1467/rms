<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function ActiveUsersView(){
        return view("admin.active_users");
    }

    public function BlackListedUsersView(){
        return view("admin.black_listed_users");
    }
}
