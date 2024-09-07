<?php
namespace App\Http\Controllers;
use App\WalletHelper;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Response;

class MeetingsController extends Controller {
    public function __construct() {
        $this->middleware( 'auth' );
    }

    public function meetings() {
        $District = "('4', '5')";
        $sql = " select * from users where user_type_id in $District";
        $DistrictUser = DB::select( DB::raw( $sql ) );

        $New = DB::table( 'meetings' )->select( 'meetings.*', 'district.district_name', 'users.full_name' )
        ->Join( 'district', 'district.id', '=', 'meetings.district_id' )
        ->Join( 'users', 'users.id', '=', 'meetings.user_id' )
        ->where( 'meetings.status', 1 )
        ->orderBy( 'meetings.id', 'Asc' )->get();

        $Live = DB::table( 'meetings' )->select( 'meetings.*', 'district.district_name', 'users.full_name' )
        ->Join( 'district', 'district.id', '=', 'meetings.district_id' )
        ->Join( 'users', 'users.id', '=', 'meetings.user_id' )
        ->where( 'meetings.status', 2 )
        ->orderBy( 'meetings.id', 'Asc' )->get();
		
		$paiduser = array();
        $user_id = Auth::user()->id;
        $j=0;
         $sql = "select meeting_id from meeting_participated where user_id = $user_id";
            $result = DB::select(DB::raw($sql));
            foreach($result as $res){
                $paiduser[$j] = $res->meeting_id;
                $j++;
            }

        $Completed = DB::table( 'meetings' )->select( 'meetings.*', 'district.district_name', 'users.full_name' )
        ->Join( 'district', 'district.id', '=', 'meetings.district_id' )
        ->Join( 'users', 'users.id', '=', 'meetings.user_id' )
        ->where( 'meetings.status', 3 )
        ->orderBy( 'meetings.id', 'Asc' )->get();

        $Rejected = DB::table( 'meetings' )->select( 'meetings.*', 'district.district_name', 'users.full_name' )
        ->Join( 'district', 'district.id', '=', 'meetings.district_id' )
        ->Join( 'users', 'users.id', '=', 'meetings.user_id' )
        ->where( 'meetings.status', 4 )
        ->orderBy( 'meetings.id', 'Asc' )->get();

        $Districts = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        //dd( $Districts );
        $balance =  WalletHelper::wallet_balance( Auth::user()->username );
        $referral_id = Auth::user()->referral_id;
        if ( Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3 ) {
            $sql = 'Select * from `users` where `id` = 1';
        } else {
            $sql = "Select * from `users` where `id` = $referral_id";
        }
        $referral = DB::select( DB::raw( $sql ) )[ 0 ];
        $Users = DB::table( 'users' )->orderBy( 'id', 'Asc' )->get();
		
        $Newactive = DB::table( 'meetings' )->select( 'meetings.*', 'district.district_name', 'users.full_name' )
        ->Join( 'district', 'district.id', '=', 'meetings.district_id' )
        ->Join( 'users', 'users.id', '=', 'meetings.user_id' )
        ->where( 'meetings.status', 2 )
        ->orderBy( 'meetings.id', 'Asc' )->limit(1)->get();
		
        return view( 'meeting/index', compact( 'New', 'Live', 'Completed', 'Rejected', 'DistrictUser', 'Districts', 'balance', 'referral', 'Users','paiduser','Newactive' ) );
    }

    public function addmeeting( Request $request )
    {
        //dd( $request->all() );
        $addmeeting = DB::table( 'meetings' )->insert( [
            'district_id'   => $request->district_id,
            'user_id'       => $request->user_id,
            'meeting_name'  => $request->meeting_name,
            'amount'        => $request->amount,
            'address'       => $request->address,
            'metting_date'  => $request->metting_date,
            'status'        => 1,
        ] );
        return redirect( 'meetings' )->with( 'success', 'Meeting Added Successfully' );
    }

    public function updatemeeting ( Request $request ) {
        $updatemeeting  = DB::table( 'meetings' )->where( 'id', $request->row_id )->update( [
            'district_id'   => $request->district_id,
            'user_id'       => $request->user_id,
            'meeting_name'  => $request->meeting_name,
            'amount'        => $request->amount,
            'address'       => $request->address,
            'metting_date'  => $request->metting_date,
            'status'        => $request->status,
        ] );
        return redirect()->back()->with( 'success', 'Update Meeting Successfully ... !' );
    }

    public function deletemeeting( $id ) {
        $sql = "delete from meetings where id=$id";
        DB::delete( DB::raw( $sql ) );
        return redirect( 'meetings' )->with( 'success', 'Meeting Deleted Successfully' );
    }

    public function addparticipated ( Request $request ) {

        DB::table( 'meeting_participated' )->insert( [
            'user_id'   => $request->user_id,
            'meeting_id'=> $request->meeting_id,
            'date'      => $date = date( 'Y-m-d H:i:s' ),

        ] );
        return redirect()->back()->with( 'success', 'Update Meeting Successfully ... !' );
    }

    public function meetingparticipated ( $id ) {

        $Participated = DB::table( 'meeting_participated' )->select( 'meeting_participated.*', 'users.full_name', 'users.phone' )
        ->Join( 'users', 'users.id', '=', 'meeting_participated.user_id' )
        ->where( 'meeting_participated.meeting_id', $id )->get();

        $Users = DB::table( 'users' )->orderBy( 'id', 'Asc' )->get();

        return view( 'meeting/participated', compact( 'Participated', 'Users', 'id' ) );
    }

    public function meetingpayment( Request $request )
    {
        $login_id = Auth::user()->id;
        $loginusername = Auth::user()->username;
        $meeting_id = $request->meeting_id;
        $to_id = $request->coundect_id;
        $amounts = $request->amount;
        $from_id = $request->user_id;
        $pay_date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $adminamount = $amounts / 4;
        $amount = $adminamount * 3;
        $sql = "select * from users where id=$to_id";
        $userapi =  DB::select( DB::raw( $sql ) );
        if ( count( $userapi ) > 0 ) {
            $username = $userapi[ 0 ]->username;
        }
        //$sql = "update wallet_users set wallet = wallet + $payment_amount,commission = commission + $payment_amount where username = '$refusername'";

        $sql = "update wallet_users set wallet = wallet + $adminamount,commission = commission + $adminamount where username = 'RJ01N001'";
        DB::update( DB::raw( $sql ) );
        $ad_info = 'Meeting Fee';
        $service_status = 'IN Payment';
        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$login_id','$login_id','1','$adminamount','$ad_info', '$service_status','$time','$pay_date',1,'nalavariyam')";
        DB::insert( DB::raw( $sql ) );

        $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$username'";
        DB::update( DB::raw( $sql ) );
         $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$login_id','$login_id','$to_id','$amount','$ad_info', '$service_status','$time','$pay_date',1,'nalavariyam')";
        DB::insert( DB::raw( $sql ) );

        WalletHelper::debitWallet2($loginusername,$amounts);
         $service_status = 'Out Payment';
        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$login_id','$to_id','$login_id','$amounts','$ad_info', '$service_status','$time','$pay_date','nalavariyam')";
        DB::insert( DB::raw( $sql ) );

       /* $sql = "update wallet_users set wallet = wallet - $amount where username = '$loginusername'";
        DB::update( DB::raw( $sql ) );*/

        $sql = "insert into meeting_participated (user_id,pay_id,pay_date,date,amount,status,meeting_id) values ('$from_id','$login_id','$pay_date','$time','$amount','1','$meeting_id')";
        DB::insert( DB::raw( $sql ) );

        return redirect( 'meetings' )->with( 'success', 'Meeting Added Successfully' );
    }

    public function updatestatus( Request $request ) {

        DB::table( 'meeting_participated' )->where( 'id', $request->parti_id )->update( [
            'status'          =>   '2',
        ] );
        return redirect()->back()->with( 'success', 'Update Status Successfully ... !' );
    }
}
