<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required','unique:users'],
            'aadhaar_no' => ['required','unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }
    public function showRegistrationForm($id)
    {
       $managedistrict = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
       $referral = DB::table( 'users' )->select('id','user_type_id')->where('id',$id)->get();
       $referral_id = 0;
       $usertype = 0;
        if ( count( $referral ) > 0 ) {
            $referral_id = $referral[ 0 ]->id;
            $usertype = $referral[ 0 ]->user_type_id;
       }
       return view('auth.register',compact('managedistrict','referral_id','usertype'));
  // return "<h1>stopped register user Joining</h1>";

    }

    public function gettalukfront( Request $request )
    {
           $gettaluk = DB::table( 'taluk' )->where( 'parent', $request->taluk_id )->orderBy( 'id', 'Asc' )->get();
           return response()->json( $gettaluk );
       }
   
       public function getpanchayathfront( Request $request ) {
           //$getpanchayath = DB::table( 'panchayath' )->where( 'parent', $request->panchayath_id )->orderBy( 'id', 'Asc' )->get();
           $taluk_id = $request->panchayath_id;
           $sql = "select * from panchayath where parent=$taluk_id and id not in (select panchayath_id from users where user_type_id in (12,13) and taluk_id=$taluk_id)";
           $getpanchayath = DB::select($sql);
           return response()->json( $getpanchayath );
       }

       public function getcenterfront( Request $request ) {
        $getcenter = DB::table( 'users' )->select('user_type_id')->distinct()->where( 'panchayath_id', $request->centerid )->whereIn('user_type_id', array(12,13))->get();
        return response()->json( $getcenter );
    }

   
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $dist_id = $data['dist_id'];
      /*  $managedistrict = DB::table( 'district' )->where('id',$dist_id)->get();
        if ( count( $managedistrict ) > 0 ) {
            $districtid = $managedistrict[ 0 ]->districtid;
        }
        $uniqueId = rand( 111111111, 999999999 );
        $username = 'RJ' . $districtid . 'N' . $uniqueId;*/
        //dd($data);
        $user = User::create([
            'full_name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'pas' => $data['password'],
            'dist_id' => $dist_id,
            'taluk_id' => $data['taluk_id'],
            'panchayath_id' => $data['panchayath_id'],
            'user_type_id' => $data['user_type_id'],
            'referral_id' => $data['referral_id'],
            'aadhaar_no' => $data['aadhaar_no'],
            'status' => 'New',
            'created_at' => date('Y-m-d'),

        ]);

        $insertid = $user->id;
        $maxid=0;
            $sql="select max(id) as maxid from wallet_users";
            $result = DB::select($sql);
            if(count($result) > 0){   
                $maxid = $result[0]->maxid;
            }
            $maxid=$maxid+1;
            $maxid=str_pad($maxid,5,"0",STR_PAD_LEFT);
            $uniqueId = rand( 111111111, 999999999 );
            $username = 'RJN' . $maxid . $uniqueId;
            $sql="insert into wallet_users (username) values ('$username')";
            DB::insert($sql);
             $sql = "update users set username='$username' where id = $insertid";
            DB::update(DB::raw( $sql ));

            return $user;
    }
}
