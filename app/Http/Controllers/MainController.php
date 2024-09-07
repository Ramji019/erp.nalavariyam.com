<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{


    public function welcome()
    {
	    $today = date('Y-m-d');
        $sql = "Select * from advertisement where add_from_date <='$today' and add_to_date >='$today' and status = 'Active' and add_location='2' order by id";
        $loginheader = DB::select(DB::raw($sql));

        $sql = "Select * from advertisement where add_from_date <='$today' and add_to_date >='$today' and status = 'Active' and add_location='3' order by id";
        $loginfooter = DB::select(DB::raw($sql));
		
        $sql = "Select * from advertisement where add_from_date <='$today' and add_to_date >='$today' and status = 'Active' and add_location='4' order by id";
        $loginleft = DB::select(DB::raw($sql));
		
        $sql = "Select * from advertisement where add_from_date <='$today' and add_to_date >='$today' and status = 'Active' and add_location='5' order by id";
        $loginright = DB::select(DB::raw($sql));
		
        $sql = "Select * from advertisement where add_from_date <='$today' and add_to_date >='$today' and status = 'Active' and add_location='1' order by id";
        $welcome = DB::select(DB::raw($sql));
		
    	return view('welcome', compact('loginheader','loginfooter','loginleft','loginright','welcome'));
    }

}