<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransitionController extends Controller
{
    public function TransitionView(){
        return view("admin.transition");
    }
}
