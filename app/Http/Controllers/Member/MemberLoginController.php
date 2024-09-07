<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Session;

class MemberLoginController extends Controller
{

    public function memberlogin()
    {
        return view('member/memberlogin');
    }

    /*   public function checklogin(Request $request)
    {
    $message = "";
    $registeration_no = trim($request->registeration_no);
    $registeration_date = trim($request->registeration_date);
    $sql = "select * from customers where registeration_no='$registeration_no' and user_type_id='18'";
    $result = DB::select(DB::raw($sql));
    $hash = "";
    if (count($result) > 0) {
    $hash = $result[0]->registeration_date;
    }
    if (Hash::check($registeration_date, $hash)) {
    if (count($result) > 0) {
    Session::put("customer_id", $result[0]->id);
    Session::put("name", $result[0]->full_name);
    return redirect('/memberdashboard')->with('message', $message);
    } else {
    $message = "Login Failed";
    return redirect('/memberlogin')->with('message', $message);
    }
    } else {
    $message = "Incorrect Password";
    return redirect('/memberlogin')->with('message', $message);
    }
    } */

    public function checklogin(Request $request)
    {
        $message = "";
        $registeration_no = trim($request->registeration_no);
        $password = trim($request->password);
        $sql = "select * from customers where registeration_no='$registeration_no' and pas='$password'and 
        (user_type_id='18' or user_type_id='19' or user_type_id='20' or user_type_id='21') ";
        $result = DB::select(DB::raw($sql));
        if (count($result) > 0) {
            Session::put("customer_id", $result[0]->id);
            Session::put("name", $result[0]->full_name);
            Session::put("member_photo", $result[0]->member_photo);
            Session::put("colour", $result[0]->colour);
            Session::put("wallet", $result[0]->wallet);
            Session::put("login_id", $result[0]->id);
            Session::put("referral_id", $result[0]->referral_id);
            Session::put("user_type", $result[0]->user_type_id);
            Session::put("password", $result[0]->password);
            Session::put("status", $result[0]->status);
            Session::put("user_dist_id", $result[0]->dist_id);
            Session::put("user_taluk_id", $result[0]->taluk_id);
            Session::put("user_panchayath_id", $result[0]->panchayath_id);
            return redirect("/memberdashboard");
        } else {
            $message = "Login Failed";
            return redirect('/')->with('message', $message);
            ;
        }
    }

    public function memberlogout()
    {
        Session::flush();
        return redirect("/");
    }
}