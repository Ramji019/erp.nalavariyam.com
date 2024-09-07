<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
    public function login(Request $request){
    $message = "";
    $username = array("username" => $request->username, "password" => $request->password);
    if(Auth::attempt($username)) {
        Auth::loginUsingId(Auth::user()->id);
        $user_id = Auth::user()->id;
        $username = Auth::user()->username;
        
        $updatetoken = DB::table('users')->where('id',$user_id)->update([
            'device_id'        => $request->device_id,
          ]);
        $sql="select isverified from wallet_users where username='$username'";
        $result=DB::select($sql);
        $isverified=$result[0]->isverified;
        return redirect('/dashboard')->with('isverified',$isverified);
      }else{
        $message = 'Login Failed';
        return redirect('/')->with('message',$message);
      }
      
    }

    
}
