<?php
namespace App\Http\Controllers;
use App\WalletHelper;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\api\WalletapiController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    public function resendotpemail(){
        $username = Auth::user()->username;
        $email = Auth::user()->email;
        $full_name = Auth::user()->full_name;
        $otp = rand(1001,9999);
        $sql="insert into email_otp (username,otp) values ('$username','$otp')";
        DB::insert($sql);
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtpout.secureserver.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@nalavariyam.com';
            $mail->Password = "Ramji@019";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('info@nalavariyam.com', 'Nalavariam');
            $mail->addAddress($email);
            $mail->Subject = "Email Verification OTP";
            $mail->Body    = "Dear $full_name \r\nPlease use OTP $otp to confirm your email address\r\n\r\nRegards\r\nTeam Nalavariam";
            if( !$mail->send() ) {
                return back()->with("error", "Email not sent")->withErrors($mail->ErrorInfo);
            }
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
        return $email;
    }

    public function sendotpemail($email,$aadhaar_no,$phone){
        $response = array();
        $status_type = 0;
        $message =  "";
        $full_name = Auth::user()->full_name;
        $usertoken = Auth::user()->usertoken;
        $username = Auth::user()->username;
        $otp = rand(1001,9999);
        $sql="select email from wallet_users where email='$email' and isverified=1";
        $result1=DB::select($sql);
        $sql="select email from wallet_users where aadhaar_no='$aadhaar_no' and isverified=1";
        $result2=DB::select($sql);
        $sql="select email from wallet_users where phone='$phone' and isverified=1";
        $result3=DB::select($sql);
        if(count($result1)>0){
            $status_type=1;
            $message="Email already used by another user";
        }else if(count($result2)>0){
            $status_type=1;
            $message="Aadhaar No already used by another user";
        }else if(count($result3)>0){
            $status_type=1;
            $message="Phone no already used by another user";
        }else{
            $message="success";
            $sql = "update users set email='$email',aadhaar_no='$aadhaar_no',phone='$phone' where username='$username'";
            DB::update($sql);
            $sql = "update wallet_users set email='$email',aadhaar_no='$aadhaar_no',phone='$phone' where username='$username'";
            DB::update($sql);
            $sql="insert into email_otp (username,otp) values ('$username','$otp')";
            DB::insert($sql);
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtpout.secureserver.net';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@nalavariyam.com';
                $mail->Password = "Ramji@019";
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('info@nalavariyam.com', 'Nalavariam');
                $mail->addAddress($email);
                $mail->Subject = "Email Verification OTP";
                $mail->Body    = "Dear $full_name \r\nPlease use OTP $otp to confirm your email address\r\n\r\nRegards\r\nTeam Nalavariam";
                if( !$mail->send() ) {
                    return back()->with("error", "Email not sent")->withErrors($mail->ErrorInfo);
                }
            } catch (Exception $e) {
                return back()->with('error',$e->getMessage());
            }
        }
        $response["message"] = $message;
        $response["status_type"] = $status_type;
        return response()->json($response);
    }

    public function confirmotpemail($username,$otp){
        $verified="0";
        $dbotp="";
        $sql="select otp from email_otp where username='$username' order by id desc limit 1";
        $result=DB::select($sql);
        if(count($result)>0){
            $dbotp=$result[0]->otp;
        }
        if($dbotp == $otp){
            $verified="1";
            $sql="update wallet_users set isverified=1 where username='$username'";
            DB::update($sql);
            $sql="update users set emailverified=1 where username='$username'";
            DB::update($sql);
        }
        return $verified;
    }

    public function resetpassword( $userid ) {
        $pas = '12345678';
        $password = Hash::make( $pas );
        $sql = "update users set pas='$pas',password = '$password' where id=$userid";
        DB::update( DB::raw( $sql ) );
        return redirect()->back()->with( 'success', 'Password reset successfully ' );
    }

    public function resetpass( $limit ) {
        $offset = $limit - 5000;
        set_time_limit( 30000 );
        $sql = "select username,email,phone,aadhaar_no from customers limit $offset,5000";
        $users = DB::select( DB::raw( $sql ) );
        $i = 0;
        foreach ( $users as $user ) {
            $i++;
            $username = $user->username;
            $email = $user->email;
            $phone = $user->phone;
            $aadhaar_no = $user->aadhaar_no;
            $aadhaar_no = str_replace("'", "", $aadhaar_no);
            $sql = "update wallet_users set email = '$email',phone = '$phone',aadhaar_no = '$aadhaar_no' where username='$username'";
            DB::update( DB::raw( $sql ) );
        }
        echo "<h1>Data updated for $i users</h1>";
    }

    public function usertypes()
    {

        if ( ( Auth::user()->user_type_id == '1' ) || ( Auth::user()->user_type_id == '2' ) || ( Auth::user()->user_type_id == '3' ) ) {

        } else {
            return redirect( 'dashboard' );
        }

        $usertypes = DB::table( 'user_type' )->orderBy( 'id', 'Asc' )->get();
        return view( 'users/user_types', compact( 'usertypes' ) );
    }

    public function renewal()
    {

        if ( ( Auth::user()->user_type_id == '1' ) || ( Auth::user()->user_type_id == '2' ) || ( Auth::user()->user_type_id == '3' ) ) {

        } else {
            return redirect( 'dashboard' );
        }

        $types = array();
        $types[ 'C' ] = 'District';
        $types[ 'D' ] = 'Taluk';
        $types[ 'E' ] = 'Sub Block';
        $types[ 'F' ] = 'Block';
        $types[ 'G' ] = 'Center';
        $sql = 'select * from user_renewal where id in (1)';
        $district = DB::select( DB::raw( $sql ) );
        $sql = 'select * from user_renewal where id in (2,3) order by id';
        $taluk = DB::select( DB::raw( $sql ) );
        $sql = 'select * from user_renewal where id in (4,5) order by id';
        $block = DB::select( DB::raw( $sql ) );
        $sql = 'select * from user_renewal where id in (6,7,8,9) order by id';
        $panchayath = DB::select( DB::raw( $sql ) );
        $sql = 'select * from user_renewal where id in (10,11,12,13,14) order by id';
        $center = DB::select( DB::raw( $sql ) );
        return view( 'users/renewal', compact( 'district', 'taluk', 'block', 'panchayath', 'center', 'types' ) );
    }

    public function updaterenewamount( Request $request ) {
        foreach ( $request->id as $i => $id ) {
            $reg_amount = $request->reg_amount[ $i ];
            $renew_amount = $request->renew_amount[ $i ];
            $sql = "update user_renewal set reg_amount='$reg_amount',renew_amount='$renew_amount' where id=$id";
            DB::update( DB::raw( $sql ) );
        }
        return redirect( '/renewal' )->with( 'success', 'Amount updated Succesfully' );
    }

    public function adduser( Request $request )
    {
        $email = $request->email;
        $aadhaar_no = $request->aadhaar_no;
        $phone = $request->phone;
        $user_id = Auth::user()->id;
        $dist_id = $request->dist_id;
        $taluk_id = $request->taluk_id;
        $user_type_id = $request->user_type_id;
        $pas = $request->password;
        $password = Hash::make( $pas );
        $adduser = DB::table( 'users' )->insert( [
            'full_name' => $request->full_name,
            'password' => $password,
            'email' => $email,
            'pas' => $pas,
            'dist_id' => $dist_id,
            'taluk_id' => $taluk_id,
            'panchayath_id' => $request->panchayath_id,
            'referral_id' => $user_id,
            'aadhaar_no' => $aadhaar_no,
            'phone' => $phone,
            'gender' => $request->gender,
            'user_type_id' => $user_type_id,
            'status' => 'Inactive',
            'from_to_date' => $to_date = date( 'y-m-d', strtotime( '- 2 day' ) ),
            'user_photo' => 'user.jpg',
            'log_id' => $user_id
        ] );
        $insertid = DB::getPdo()->lastInsertId();
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
        $sql="insert into wallet_users (username,email,aadhaar_no,phone) values ('$username','$email','$aadhaar_no','$phone')";
        DB::insert($sql);
        $sql = "update users set username='$username' where id = $insertid";
        DB::update( DB::raw( $sql ) );
        return redirect()->back()->with( 'success', 'User added successfully' );
    }

    public function checkemail( Request $request )
    {
        $email = trim( $request->email );
        $id = trim( $request->id );
        if ( $id == 0 ) {
            $sql = "SELECT * FROM wallet_users where email='$email'";
        } else {
            $sql = "SELECT * FROM wallet_users where email='$email' and id <> $id";
        }
        $users = DB::select( DB::raw( $sql ) );
        if ( count( $users ) > 0 ) {
            return response()->json( array( 'exists' => true ) );
        } else {
            return response()->json( array( 'exists' => false ) );
        }
    }

    public function checkaadhar( Request $request )
    {
        $aadhar = trim( $request->aadhar );
        $id = trim( $request->id );
        if ( $id == 0 ) {
            $sql = "SELECT * FROM wallet_users where aadhaar_no='$aadhar'";
        } else {
            $sql = "SELECT * FROM wallet_users where aadhaar_no='$aadhar' and id <> $id";
        }
        $users = DB::select( DB::raw( $sql ) );
        if ( count( $users ) > 0 ) {
            return response()->json( array( 'exists' => true ) );
        } else {
            return response()->json( array( 'exists' => false ) );
        }
    }

    public function checkphone( Request $request )
    {
        $phone = trim( $request->phone );
        $id = trim( $request->id );
        if ( $id == 0 ) {
            $sql = "SELECT * FROM wallet_users where phone='$phone'";
        } else {
            $sql = "SELECT * FROM wallet_users where phone='$phone' and id <> $id";
        }
        $users = DB::select( DB::raw( $sql ) );
        if ( count( $users ) > 0 ) {
            return response()->json( array( 'exists' => true ) );
        } else {
            return response()->json( array( 'exists' => false ) );
        }
    }

    public function edituser( $id )
    {
        $editusers = DB::table( 'users' )->where( 'id', '=', $id )->get();
        $managedistrict = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        $managetaluk = DB::table( 'taluk' )->orderBy( 'id', 'Asc' )->get();
        $managepanchayath = DB::table( 'panchayath' )->where( 'status', '=', 1 )->orderBy( 'id', 'Asc' )->get();
        $manageuser_type = DB::table( 'user_type' )->orderBy( 'id', 'Asc' )->get();
        $userdata = DB::table( 'users' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/edituser', compact( 'editusers', 'managedistrict', 'manageuser_type', 'userdata' ) );
    }

    public function updateuser( Request $request ) {
        $createtailoringuser = ($request->get("tailoring_user") != null) ? 1 : 0;
        $updateuser = DB::table( 'users' )->where( 'id', $request->id )->update( [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'dist_id' => $request->dist_id,
            'taluk_id' => $request->taluk_id,
            'panchayath_id' => $request->panchayath_id,
            'aadhaar_no' => $request->aadhaar_no,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'status' => $request->status,
            'user_type_id' => $request->user_type_id,
            'referral_id' => $request->referral_id,
            'permanent_address_1' => $request->permanent_address_1,
            'e_form_date' => $request->e_form_date,
            'signature_owner' => $request->signature_owner,
            'signature_phone' => $request->signature_phone,
            'tailoring_user' => $createtailoringuser,

        ] );
        $user_id = $request->id;
        $photo = '';
        if ( $request->photo != null ) {
            $photo = $user_id.'.'.$request->file( 'photo' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'user_photo'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ], $filepath.$photo );
            $sql = "update users set user_photo='$photo' where id = $user_id";
            DB::update( DB::raw( $sql ) );
        }
        $signature = '';
        if ( $request->signature2 != null ) {
            $signature = $user_id.'.'.$request->file( 'signature2' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'off'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'signature2' ][ 'tmp_name' ], $filepath.$signature );
            $sql = "update users set signature2='$signature' where id = $user_id";
            DB::update( DB::raw( $sql ) );
        }
        return redirect( 'dashboard' )->with( 'success', 'Edit User Successfully ... !' );
    }

    public function profile()
    {
        $userid = Auth::user()->id;

        $profile = DB::table( 'users' )->where( 'id', '=', $userid )->get();
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
        return view( 'users/profile', compact( 'profile', 'managedistrict' ) );
    }

    public function updateprofile( Request $request ) {
        $userid = Auth::user()->id;

        $updateprofile = DB::table( 'users' )->where( 'id', $userid )->update( [
            'full_name'  => $request->full_name,
            'aadhaar_no' => $request->aadhaar_no,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'gender'     => $request->gender,
            'permanent_address_1' => $request->permanent_address_1,
            'upi'        => $request->upi,
        ] );

        $qrcode = '';
        if ( $request->payment_qr_oode != null ) {
            $qrcode = $userid.'.'.$request->file( 'payment_qr_oode' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'qrcodeimg'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'payment_qr_oode' ][ 'tmp_name' ], $filepath.$qrcode );
            $sql = "update users set payment_qr_oode='$qrcode' where id = $userid";
            DB::update( DB::raw( $sql ) );
        }

        $profile = '';
        if ( $request->user_photo != null ) {
            $profile = $userid.'.'.$request->file( 'user_photo' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'user_photo'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'user_photo' ][ 'tmp_name' ], $filepath.$profile );
            $sql = "update users set user_photo='$profile' where id = $userid";
            DB::update( DB::raw( $sql ) );
        }

        $signature = '';
        if ( $request->signature2 != null ) {
            $signature = $userid.'.'.$request->file( 'signature2' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'off'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'signature2' ][ 'tmp_name' ], $filepath.$signature );
            $sql = "update users set signature2='$signature' where id = $userid";
            DB::update( DB::raw( $sql ) );
        }
        return redirect( 'dashboard' )->with( 'success', 'Edit User Successfully ... !' );
    }

    public function changepassword()
    {
        $userid = Auth::user()->id;

        return view( 'users/changepassword' );
    }

    public function updatepassword( Request $request ) {
        $userid = Auth::user()->id;
        $old_password = trim( $request->get( 'oldpassword' ) );
        $currentPassword = auth()->user()->password;
        if ( Hash::check( $old_password, $currentPassword ) ) {
            $new_password = trim( $request->get( 'new_password' ) );
            $confirm_password = trim( $request->get( 'confirm_password' ) );
            if ( $new_password != $confirm_password ) {
                return redirect( 'changepassword' )->with( 'error', 'Passwords does not match' );
            } elseif ( $new_password == '12345678' ) {
                return redirect( 'changepassword' )->with( 'error', 'You cannot use the passord 12345678' );
            } else {
                $updatepass = DB::table( 'users' )->where( 'id', '=', $userid )->update( [
                    'password' => Hash::make( $new_password ),
                    'pas'      => $request->new_password,
                ] );
                return redirect( 'dashboard' )->with( 'success', 'Passwords Change Succesfully' );
            }
        } else {
            return redirect( 'changepassword' )->with( 'error', 'Sorry, your current password was not recognised' );
        }
    }

    public function primaryusers()
    {
        if ( Auth::user()->user_type_id == 1 ) {
            $user_type_id = array( '2', '3' );

            $primaryusers = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as userID', 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $user_type_id )->orderBy( 'users.id', 'Asc' )->get();

        }
        return view( 'users/primaryusers', compact( 'primaryusers' ) );
    }

    public function specialusers()
    {

        if ( Auth::user()->user_type_id == 1 ) {
            $user_type_id = array( '16', '17' );

            $specialusers = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as userID' , 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $user_type_id )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 2 ) {
            $specialusers = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as userID' , 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', '16' )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 3 ) {
            $specialusers = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as userID' , 'wallet_users.wallet as balance')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', '17' )->orderBy( 'users.id', 'Asc' )->get();
        }
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
        return view( 'users/specialusers', compact( 'specialusers', 'managedistrict' ) );
    }

    public function assigned( $id )
    {
        $user_id = Auth::user()->id;
        if ( ( Auth::user()->user_type_id == '2' ) || ( Auth::user()->user_type_id == '16' ) ) {

            $user_type_id = '4';
        }
        if ( ( Auth::user()->user_type_id == '3' ) || ( Auth::user()->user_type_id == '17' ) ) {

            $user_type_id = '5';
        }

        $assigned = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as userID' )
        ->Join( 'district', 'district.id', '=', 'users.dist_id' )
        ->Join( 'assigned_district', 'assigned_district.district_user_id', '=', 'users.id' )
        ->where( 'assigned_district.user_id', $user_id )->orderBy( 'users.id', 'Asc' )->get();

        $getdistrictlimit = DB::table( 'users' )->select( 'users.*', 'district.*', 'users.id as districtID' )
        ->Join( 'district', 'users.dist_id', '=', 'district.id' )

        ->where( 'users.user_type_id', $user_type_id )->orderBy( 'users.id', 'Asc' )->get();

        return view( 'users/assigned', compact( 'assigned', 'getdistrictlimit' ) );
    }

    public function addassigneduser( Request $request ) {
        $addaddassigneduser = DB::table( 'users' )->insert( [
            'district_name' => $request->district_name,
            'status' => 'Active'
        ] );
        return redirect()->back()->with( 'success', 'Assigned Added Successfully ... !' );
    }

    public function districtusers() {
        $districtuser = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $districtuse = array( '4', '5' );
            $districtusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'user_type.group_name', 'users.id as userID', 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'user_type', 'user_type.id', '=', 'users.user_type_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $districtuse )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 2 ) {
            $districtuser = '4';
            $districtusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'user_type.group_name', 'users.id as userID', 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'user_type', 'user_type.id', '=', 'users.user_type_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $districtuser )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 3 ) {
            $districtuser = '5';
            $districtusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'user_type.group_name', 'users.id as userID', 'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'user_type', 'user_type.id', '=', 'users.user_type_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $districtuser )->orderBy( 'users.id', 'Asc' )->get();
        }

//$balance =  WalletHelper::wallet_balance(Auth::user()->username);

        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
        $sql = "select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = '$districtuser')";
        $getdistrictlimit = DB::select( DB::raw( $sql ) );

        return view( 'users/districtusers', compact( 'districtusers', 'managedistrict', 'getdistrictlimit' ) );
    }

    public function talukusers() {
        $login_user = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $talukuser = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $talukuse = array( '6', '7' );
            $talukusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID' , 'wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $talukuse )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 2 ) {
            $talukuser = '6';
            $talukusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID' , 'wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $talukuser )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 3 ) {
            $talukuser = '7';
            $talukusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID' , 'wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $talukuser )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 4 ) {
            $talukuser = '6';
            $talukusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID' , 'wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $talukuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 5 ) {
            $talukuser = '7';
            $talukusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID' , 'wallet_users.wallet as balance')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $talukuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        }
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();

        $sql = "select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = '$talukuser')";
        $getdistrictlimit = DB::select( DB::raw( $sql ) );
        return view( 'users/talukusers', compact( 'talukusers', 'managedistrict', 'getdistrictlimit' ) );
    }

    public function blockusers() {

        $login_user = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $blockuser = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $blockuse = array( '10', '11' );
            $blockusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID','wallet_users.wallet as balance')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $blockuse )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 2 ) {
            $blockuser = 10;
            $blockusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $blockuser )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 3 ) {
            $blockuser = 11;
            $blockusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $blockuser )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 4 ) {
            $blockuser = 10;
            $blockusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $blockuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 5 ) {
            $blockuser = 11;
            $blockusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $blockuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        }
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();

        $sql = "select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = '$blockuser')";
        $getdistrictlimit = DB::select( DB::raw( $sql ) );

        return view( 'users/blockusers', compact( 'blockusers', 'managedistrict' ) );
    }

    public function panchayathusers()
    {
        $login_user = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $panchayathuser = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $panchayathuse = array( '8', '9' );
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $panchayathuse )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 2 ) {
            $panchayathuser = 8;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 3 ) {
            $panchayathuser = 9;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 4 ) {
            $panchayathuser = 8;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 5 ) {
            $panchayathuser = 9;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) ) {
            $panchayathuser = 8;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) ) {
            $panchayathuser = 9;
            $panchayathusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $panchayathuser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        }

        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();

        $sql = "select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = '$panchayathuser')";
        $getdistrictlimit = DB::select( DB::raw( $sql ) );
        return view( 'users/panchayathusers', compact( 'panchayathusers', 'managedistrict' ) );
    }

    public function centerusers() {
        $login_user = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $centeruser = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $centeruse = array( '12', '13' );
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->wherein( 'users.user_type_id', $centeruse )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 2 ) {
            $centeruser = 12;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 3 ) {
            $centeruser = 13;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( Auth::user()->user_type_id == 4 ) {

            $centeruser = 12;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 5 ) {
            $centeruser = 13;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance'  )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) ) {
			
            $centeruser = 12;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID' ,'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();

        } elseif ( ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) ) {
            $centeruser = 13;
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID' ,'wallet_users.wallet as balance' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
            ->where( 'users.user_type_id', $centeruser )->where( 'users.referral_id', $login_user )->orderBy( 'users.id', 'Asc' )->get();
        }
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();

        $sql = "select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = '$centeruser')";
        $getdistrictlimit = DB::select( DB::raw( $sql ) );

        return view( 'users/centerusers', compact( 'centerusers', 'managedistrict' ) );
    }

    public function avilableposting()
    {
        $avilableposting = DB::table( 'users_posting' )->select( 'users_posting.*', 'district.district_name', 'user_type.group_name' )
        ->Join( 'district', 'district.id', '=', 'users_posting.dist_id' )
        ->Join( 'user_type', 'user_type.id', '=', 'users_posting.user_type_id' )
        ->orderBy( 'users_posting.status', 'Asc' )->get();
        return view( 'users/avilableposting', compact( 'avilableposting' ) );
    }

    public function updateavilableposting( Request $request ) {
        $id = $request->id;
        $status = $request->status;
        $sql = "update users_posting set status='$status' where id=$id";
        DB::update( DB::raw( $sql ) );
        return redirect( 'avilableposting' );
    }

    public function gettaluk( Request $request )
    {
        $gettaluk = DB::table( 'taluk' )->where( 'parent', $request->taluk_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $gettaluk );
    }

    public function getpanchayath( Request $request ) {
        $getpanchayath = DB::table( 'panchayath' )->where( 'parent', $request->panchayath_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $getpanchayath );
    }

    public function editusertype( Request $request )
    {

        $editusertype = DB::table( 'user_type' )->where( 'id', $request->id )->update( [
            'group_name'        => $request->group_name,
            'user_discount'     => $request->user_discount,
            'other_discount'    => $request->other_discount,

        ] );

        return redirect()->back()->with( 'success', 'Edit User Successfully ... !' );
    }

    public function gettaluklimit( $district_id ) {
        $user_type_id = 0;
        if ( ( Auth::user()->user_type_id == 2 ) || ( Auth::user()->user_type_id == 4 ) ) {
            $user_type_id = 6;
        } elseif ( ( Auth::user()->user_type_id == 3 ) || ( Auth::user()->user_type_id == 5 ) ) {
            $user_type_id = 7;
        }
        $sql = "select id,taluk_name from taluk where parent=$district_id and id not in (select distinct(taluk_id) from users  where user_type_id = $user_type_id and taluk_id is not NULL)";
        $taluk = DB::select( DB::raw( $sql ) );
        return response()->json( $taluk );
    }

    public function getpanchayathlimit( $taluk_id ) {
        $user_type_id = 0;
        if ( ( Auth::user()->user_type_id == 2 ) || ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) ) {
            $user_type_id = 8;
        } elseif ( ( Auth::user()->user_type_id == 3 ) || ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) ) {
            $user_type_id = 9;

        }
        $sql = "select id,panchayath_name from panchayath where parent = $taluk_id and  id not in (select distinct(panchayath_id) from users  where user_type_id = $user_type_id  and panchayath_id is not NULL )";
        $panchayath = DB::select( DB::raw( $sql ) );
        return response()->json( $panchayath );
    }

    public function getcenterpanchayathlimit( $taluk_id ) {
        $user_type_id = 0;
        if ( ( Auth::user()->user_type_id == 2 ) || ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) ) {
            $user_type_id = 12;
        } elseif ( ( Auth::user()->user_type_id == 3 ) || ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9) || ( Auth::user()->user_type_id == 11 ) ) {
            $user_type_id = 13;
        }
        $sql = "select id,panchayath_name from panchayath where parent = $taluk_id and  id not in (select distinct(panchayath_id) from users  where user_type_id = $user_type_id  and panchayath_id is not NULL )";
        $panchayath = DB::select( DB::raw( $sql ) );
        return response()->json( $panchayath );
    }

    public function userstatus( Request $request )
    {

        $userstatus = DB::table( 'users' )->where( 'id', $request->userid )->update( [
            'from_to_date'        => $request->from_to_date,
            'status'              => $request->status,
        ] );

        return redirect()->back()->with( 'success', 'Status Updated Successfully ... !' );
    }

    public function allusers()
    {
        $allusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'users.id as userID','wallet_users.wallet as balance')
        ->Join( 'district', 'district.id', '=', 'users.dist_id' )
        ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
        ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
        ->Join( 'wallet_users', 'wallet_users.username', '=', 'users.username' )
        ->orderBy( 'users.id', 'Asc' )->get();

        return view( 'users/allusers', compact( 'allusers' ) );
    }

    public function renewpayment( Request $request ) {
        $user_id = $request->user_id;
        $log_id = Auth::user()->id;
        if ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) ) {
            $referral_id = 2;
        } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) ) {
            $referral_id = 3;
        }
        $ad_info = $request->ad_info;
        $payment_amount = $request->payment_amount;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Income';
        $service_status = 'Out Payment';
        $message = 'User Activation In Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,message,service_entity) values ('$log_id','$log_id','$referral_id','$payment_amount','$ad_info', '$service_status','$time','$paydate','$message','nalavariyam')";
        DB::insert( DB::raw( $sql ) );

        $sql = "select username from users where id=$referral_id ";
        $result =  DB::select( DB::raw( $sql ));
        $refusername = $result[0]->username;

        $sql = "update wallet_users set wallet = wallet + $payment_amount,commission = commission + $payment_amount where username = '$refusername'";
        DB::update( DB::raw( $sql ) );

        $ad_info = 'Outgoing';
        $service_status = 'IN Payment';
        $message = 'User Activation Out Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,message,iscommission,service_entity) values ('$log_id','$referral_id','$log_id','$payment_amount','$ad_info', '$service_status','$time','$paydate','$message',1,'nalavariyam')";
        DB::insert( DB::raw( $sql ) );
        $from_to_date = Auth::user()->from_to_date;
        if ( Auth::user()->status == 'Inactive' ) {
            $from_to_date = date( 'Y-m-d', strtotime( '+ 365 days' ) );
        } else {
            $from_to_date = date( 'Y-m-d', strtotime( $from_to_date. ' + 365 days' ) );
        }
        $sql = "select username from users where id=$log_id ";
        $result =  DB::select( DB::raw( $sql ));
        $logusername = $result[0]->username;
        WalletHelper::debitWallet2($logusername,$payment_amount);
//$sql = "update users set wallet = wallet - $payment_amount where id = $log_id";
//DB::update( DB::raw( $sql ) );

        $sql = "update users set status='Active',from_to_date='$from_to_date' where id = $user_id";
        DB::update( DB::raw( $sql ) );

        $sql = "select user_type_id,full_name,username,pas,dist_id,taluk_id,phone,referral_id from users where id=$user_id ";
        $userapi =  DB::select( DB::raw( $sql ));
        if(count($userapi) > 0){
            $user_type_id = $userapi[0]->user_type_id;
            $full_name = $userapi[0]->full_name;
            $username = $userapi[0]->username;
            $password = $userapi[0]->pas;
            $dist_id = $userapi[0]->dist_id;
            $taluk_id = $userapi[0]->taluk_id;
            $phone = $userapi[0]->phone;
            $referral_id = $userapi[0]->referral_id;
        }

        if ( $user_type_id >= 6 && $user_type_id <= 13 ) {
            $API_KEY = env( 'API_KEY', '' );
            $SCHOLARSHIP_URL = env( 'SCHOLARSHIP_URL', '' );
            $RAMJIPAY_URL = env( 'RAMJIPAY_URL', '' );
            $full_name = $full_name;
            $username = $username;
            $password = $password;
            $dist_id = $dist_id;
            $taluk_id = $taluk_id;
            $phone = $phone;
            $referral_id = $referral_id;
            $ch = curl_init();
            $post_data = "key=$API_KEY&full_name=$full_name&username=$username&password=$password&dist_id=$dist_id&taluk_id=$taluk_id&phone=$phone&referral_id=$referral_id";
            $url = $SCHOLARSHIP_URL.'/api/createuser';

            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $server_output = curl_exec( $ch );
            curl_close( $ch );

        }

        return redirect( 'dashboard' );
    }

    public function userstatusupdate( $id, $usertype_id )
    {
        $balance =  WalletHelper::wallet_balance(Auth::user()->username);
        $sql = "select dist_id from users where id = $id";
        $result = DB::select( DB::raw( $sql ) );
        $center_dist_id = $result[ 0 ]->dist_id;
        $login_dist_id = Auth::user()->dist_id;
        $today = date( 'Y-m-d' );
        $user_status_id = $id;
        $sql = "select * from user_type where id = $usertype_id";
        $result = DB::select( DB::raw( $sql ) );
        $user_status_user_type = $result[ 0 ]->user_type;

        $user_type_id = Auth::user()->user_type_id;
        $sql = "select * from user_type where id = $user_type_id";
        $result = DB::select( DB::raw( $sql ) );
        $login_user_type = $result[ 0 ]->user_type;
        $user_payment = 0;
        $renew_payment = 0;
        $sql = "select * from user_renewal where renewal_by = '$login_user_type' and user_type = '$user_status_user_type'";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $user_payment = $result[ 0 ]->reg_amount;
            $renew_payment = $result[ 0 ]->renew_amount;
        }

        $dist_id = Auth::user()->dist_id;
        $referral_id = Auth::user()->referral_id;

        if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3){
            $sql = "Select * from `users` where `id` = 1";
        }else{
            $sql = "Select * from `users` where `id` = $referral_id";
        }
        $referral = DB::select( DB::raw( $sql ) )[ 0 ];

        $payment_amount = 0;
        $payment_message = '';
        $ad_info = '';
        $payment_pending = 0;

        $sql = "select status,from_to_date from users where id = $id";
        $userstatuse = DB::select( DB::raw( $sql ) );
        $status = $userstatuse[ 0 ]->status;
        $from_to_date = $userstatuse[ 0 ]->from_to_date;

        if ( $user_type_id > 3 && $user_type_id < 14 ) {
            if ( $status == 'Inactive' ) {
                $payment_amount = $user_payment;
                if ( $user_type_id == 6 || $user_type_id == 7 || $user_type_id == 8 || $user_type_id == 9 ) {
                    if ( $usertype_id == 12 || $usertype_id == 13 ) {
                        if ( $login_dist_id != $center_dist_id ) {
                            $payment_amount = $payment_amount + 250;
                        }
                    }
                }
                $payment_message = 'Please pay registration fee to avail offers and dicount';
                $payment_pending = 1;
                $ad_info = 'Registration';
            } else if ( $status == 'New' ) {
                $payment_amount = $user_payment;
                if ( $user_type_id == 6 || $user_type_id == 7 || $user_type_id == 8 || $user_type_id == 9 ) {
                    if ( $usertype_id == 12 || $usertype_id == 13 ) {
                        if ( $login_dist_id != $center_dist_id ) {
                            $payment_amount = $payment_amount + 250;
                        }
                    }
                }
                $payment_message = 'Please pay registration fee to avail offers and dicount';
                $payment_pending = 1;
                $ad_info = 'Registration';
            } else if ( $from_to_date < $today ) {
                $payment_amount = $renew_payment;
                $payment_message = 'Your account has been expired';
                $payment_pending = 2;
                $ad_info = 'Renewal';
            }
        }

        return view( 'users/user_status_update', compact( 'payment_amount', 'payment_message', 'payment_pending', 'referral', 'ad_info', 'user_status_id','balance' ) );

    }

    public function userstatuspayment_update( Request $request ) {
        $log_id = Auth::user()->id;

        if ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 12 ) ) {
            $referral_id = 2;
        } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 13 ) ) {
            $referral_id = 3;
        }
        $ad_info = $request->ad_info;
        $payment_amount = $request->payment_amount;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Income';
        $service_status = 'IN Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$log_id','$referral_id','$payment_amount','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
        DB::insert( DB::raw( $sql ));
        $sql = "select username from users where id=$referral_id ";
        $result =  DB::select( DB::raw( $sql ));
        $refusername = $result[0]->username;
        $sql = "update wallet_users set wallet = wallet + $payment_amount,commission = commission + $payment_amount where username = '$refusername'";
        DB::update( DB::raw( $sql ));
        $ad_info = $request->ad_info;
        $service_status = 'Out Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$referral_id','$log_id','$payment_amount','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
        DB::insert( DB::raw( $sql ) );
        $from_to_date = Auth::user()->from_to_date;
        if ( Auth::user()->status == 'Inactive' ) {
            $from_to_date = date( 'Y-m-d', strtotime( '+ 365 days' ) );
        } else {
            $from_to_date = date( 'Y-m-d', strtotime( $from_to_date. ' + 365 days' ) );
        }
        $sql = "select username from users where id=$log_id ";
        $result =  DB::select( DB::raw( $sql ));
        $logusername = $result[0]->username;
        WalletHelper::debitWallet2($logusername,$payment_amount);
        $sql = "update users set status='Active',from_to_date='$from_to_date' where id = $log_id";
        DB::update( DB::raw( $sql ) );

        $sql = "select user_type_id,full_name,username,pas,dist_id,taluk_id,phone,referral_id from users where id=$log_id ";
        $userapi =  DB::select( DB::raw( $sql ));
        if(count($userapi) > 0){
            $user_type_id = $userapi[0]->user_type_id;
            $full_name = $userapi[0]->full_name;
            $username = $userapi[0]->username;
            $password = $userapi[0]->pas;
            $dist_id = $userapi[0]->dist_id;
            $taluk_id = $userapi[0]->taluk_id;
            $phone = $userapi[0]->phone;
            $referral_id = $userapi[0]->referral_id;
        }

        if ( $user_type_id >= 6 && $user_type_id <= 13 ) {
            $API_KEY = env( 'API_KEY', '' );
            $SCHOLARSHIP_URL = env( 'SCHOLARSHIP_URL', '' );
            $RAMJIPAY_URL = env( 'RAMJIPAY_URL', '' );
            $full_name = $full_name;
            $username = $username;
            $password = $password;
            $dist_id = $dist_id;
            $taluk_id = $taluk_id;
            $phone = $phone;
            $referral_id = $referral_id;
            $ch = curl_init();
            $post_data = "key=$API_KEY&full_name=$full_name&username=$username&password=$password&dist_id=$dist_id&taluk_id=$taluk_id&phone=$phone&referral_id=$referral_id";
            $url = $SCHOLARSHIP_URL.'/api/createuser';

            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $server_output = curl_exec( $ch );
            curl_close( $ch );

        }
        return redirect( 'dashboard' );
    }

    public function logout() {
        Auth::guard()->logout();
        return redirect()->intended( '/' );
    }
}
