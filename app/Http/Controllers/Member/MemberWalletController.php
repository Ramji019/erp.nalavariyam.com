<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Session;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberWalletController extends Controller
 {
 
    public function index( $from, $to)
 {
        $login = Session::get("customer_id");
        $user_id = Session::get("customer_id");
        $referral_id = Session::get("referral_id");
        $user_type_id = Session::get("user_type_id");
        $wallet = Session::get("wallet");

            $wallet = DB::table( 'payment' )->where( 'from_id', $login )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'paydate', 'Desc' )->get();
			
        $sql = '';
        if ( $user_type_id == 18 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( $user_type_id == 19 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( $user_type_id == 20 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( $user_type_id == 21 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else {
            $referral_id = Session::get("referral_id");
            $sql = "Select * from `customers` where `id` = $referral_id order by `id` desc limit 1 ";
        }
        $referencedata = DB::select( DB::raw( $sql ) );

        if ( $user_type_id == 18 ) {
            $sql = 'Select * from `customers`';
        } else if ( $user_type_id == 18 || $user_type_id == 19 || $user_type_id == 20 || $user_type_id == 21 ){
            $assigned_user_id = Session::get("customer_id");
            $sql = "select * from customers where assigned_user_id= $assigned_user_id";
        } else {
            $sql = "Select * from `customers` where `referral_id` = $user_id";
        }
        $userpayment = DB::select( DB::raw( $sql ) );
		
		
        $sql = "select status from request_payment where from_id=$login and status='Pending'";
        $paymentrequest =  DB::select( DB::raw( $sql ));
        $status ="";
        if(count($paymentrequest) > 0){
        $status = $paymentrequest[0]->status;
        }
		
        return view( 'member/memberwallet/index', compact( 'wallet', 'referencedata', 'userpayment', 'from', 'to', 'status' ) );
    }
	
    public function memberallwallet( $from, $to)
 {
    $login = Session::get("customer_id");
    $user_id = Session::get("customer_id");
        if ( Session::get("user_type_id") ) {
            $walle = DB::table( 'payment' )->orderBy( 'paydate', 'Desc' )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->get();
        }
		
        return view( 'wallet/allwallet', compact( 'wallet', 'from', 'to' ) );
    } 

    public function superadminaddwallet( Request $request )
 {      
        $from = date('Y-m-d' ,strtotime('-1 days'));
        $to =  date('Y-m-d');
        $amount = $request->fundamount;
        $login_id = Auth::user()->id;
        $date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Fund Transfer';
        $service_status = 'IN Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$login_id','$login_id','$login_id','$amount','$ad_info', '$service_status','$time','$date')";
        DB::insert( DB::raw( $sql ) );
        $sql = "update users set wallet = wallet + $amount where id = 1";
        DB::update( DB::raw( $sql ) );
        return redirect( "wallet/$from/$to" );

    }

    public function addwallet( Request $request )
 {
        $from = date('Y-m-d' ,strtotime('-1 days'));
        $to =  date('Y-m-d');
        $to_user = $request->user_id;
        $amount = $request->transfer_payment;
        $login_id = Auth::user()->id;
        $date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Fund Transfer';
        $ad_info2 = "FundTransfer";
        $service_status = 'Out Payment';
        $message = 'Fund Transfer';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,ad_info2,message) values ('$login_id','$login_id','$to_user','$amount','$ad_info', '$service_status','$time','$date','$ad_info2','$message')";
        DB::insert( DB::raw( $sql ) );
        $insertid = DB::getPdo()->lastInsertId();
        $sql = "update payment set pay_id = $insertid where id = $insertid";
        DB::update( DB::raw( $sql ) );
        $sql = "update users set wallet = wallet + $amount where id = $to_user";
        DB::update( DB::raw( $sql ) );
        $service_status = 'IN Payment';
        $ad_info2 = "FundTransfer";
        $message = "Fund Transfer";
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,pay_id,ad_info2,message) values ('$login_id','$to_user','$login_id','$amount','$ad_info', '$service_status','$time','$date','$insertid','$ad_info2','$message')";
        DB::insert( DB::raw( $sql ) );
        $sql = "update users set wallet = wallet - $amount where id = $login_id";
        DB::update( DB::raw( $sql ) );
        return redirect( "wallet/$from/$to" );

    }

    public function servicepaymentdelete( $payid ) {
        $from = date('Y-m-d' ,strtotime('-1 days'));
        $to =  date('Y-m-d');
        $sql = "select * from payment where pay_id='$payid' and ad_info2='ServicePayment'";
		$result =  DB::select( DB::raw( $sql ));
        $service_status = $result[0]->service_status;
		$amount = $result[0]->amount;
        $from_user = $result[0]->from_id;
        $to_user = $result[0]->to_id;

        $sql1 = "select sum(amount) as sumamount from payment where pay_id='$payid' and ad_info2='ServicePayment'";

        $result =  DB::select( DB::raw( $sql1 ));
          $sumamount = $result[0]->sumamount;

          $sql = "update users set wallet = wallet + $sumamount where id = $from_user";
          DB::update( DB::raw( $sql ) );
          $sql = "update users set wallet = wallet - $amount where id = $to_user";
          DB::update( DB::raw( $sql ) );
          $sql = "delete from payment where pay_id=$payid";
          DB::delete( DB::raw( $sql ) );
          $sql = "delete from payments where id=$payid";
          DB::delete( DB::raw( $sql ) );
        return redirect( "wallet/$from/$to" )->with( 'success', 'Payment Deleted Successfully' );
    }
	
    public function transferpaymentdelete( $payid ) {
        $from = date('Y-m-d' ,strtotime('-1 days'));
        $to =  date('Y-m-d');
        $sql = "select * from payment where pay_id='$payid' and ad_info2='FundTransfer'";
        $result =  DB::select( DB::raw( $sql ));
          $service_status = $result[0]->service_status;
          $amount = $result[0]->amount;
          $from_user = $result[0]->from_id;
          $to_user = $result[0]->to_id;
          $sql = "update users set wallet = wallet + $amount where id = $from_user";
          DB::update( DB::raw( $sql ) );
          $sql = "update users set wallet = wallet - $amount where id = $to_user";
          DB::update( DB::raw( $sql ) );
          $sql = "delete from payment where pay_id=$payid";
          DB::delete( DB::raw( $sql ) );
        return redirect( "wallet/$from/$to" )->with( 'success', 'Payment Deleted Successfully' );
    }


    public function memberamount(Request $request) {
		
        $amount = $request->amount;
        $login_id = Session::get("customer_id");
        $device_id = "";
         if ( $user_type == 18 || $user_type == 19) {
             $to_user = 1;
             $device_token = DB::table( 'customers' )->where( 'id', '=', $to_user )->get();
             $device_id = $device_token[0]->device_id;
		} else {
             $to_user = Session::get("referral_id");
             $device_token = DB::table( 'customers' )->where( 'id', '=', $to_user )->get();
             $device_id = $device_token[0]->device_id;
	    }
		
        $date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Fund Transfer';
        $ad_info2 = "FundTransfer";
        $service_status = 'RequestAmount';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,ad_info2) values ('$login_id','$login_id','$to_user','$amount','$ad_info', '$service_status','$time','$date','$ad_info2')";
        DB::insert( DB::raw( $sql ) );

		 $insertid = DB::getPdo()->lastInsertId();
		$paid_image ="";
    if($request->paid_image != null){
     $paid_image = $insertid.'.'.$request->file('paid_image')->extension(); 
     $filepath = public_path('upload'.DIRECTORY_SEPARATOR.'paidimage'.DIRECTORY_SEPARATOR);
     move_uploaded_file($_FILES['paid_image']['tmp_name'], $filepath.$paid_image);
     $sql = "update payment set paid_image='$paid_image' where id = $insertid";
     DB::update(DB::raw($sql));
   }
   $url = 'https://fcm.googleapis.com/fcm/send';
   //'to' for single user
   //'registration_ids' for multiple users
   $weburl =  '';
   //base_url( 'payments/pending' );
   $message = "You Have a Request of Amount"." ". $amount;

   $title = 'Nalavaryam';
   $body = $message;
   $icon = 'Nalavaryam';
   $click_action = $weburl;

   if ( isset( $title ) && !empty( $title ) )
{
       $fields = array(
           'to'=>$device_id,
           'notification'=>array(
               'body'=>$body,
               'title'=>$title,
               'icon'=>$icon,
               'click_action'=>$click_action
           )
       );
       //print_r( $fields );
       //exit;

       $headers = array(
           'Authorization: key=AAAABIWWI_c:APA91bGf79FDnwnPw1FgpFkVlryHBvf3F1hhi0uwfRPuZRV7jEKu4Hggezwbl61FBxpkeauYs13Gbmsu5xzZxQcGVKRs7k8LJOUZoUI7fw2QkZGBrzNW_r7192r6DrzV2X269LEzz27M',
           'Content-Type:application/json'
       );

       $ch = curl_init();
       curl_setopt( $ch, CURLOPT_URL, $url );
       curl_setopt( $ch, CURLOPT_POST, true );
       curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
       curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
       curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
       $result = curl_exec( $ch );
       curl_close( $ch );

       //print_r( $registrationIds );
   }
		
        return redirect( "memberrequestamount" )->with( 'success', 'Request Member Amount Successfully' );
    }
	
	  public function memberrequestamount()
 {
        $login = Session::get("customer_id");
        $user_id = Session::get("customer_id");
        $user_type_id = Session::get("user_type_id");
        $service_status = 'RequestAmount';
		$sql = "select * from request_payment where from_id=$login or to_id = $login order by `status` desc";
        $paymentrequest =  DB::select( DB::raw( $sql ));
		
	 $sql = '';
        if ( $user_type_id == 18) {
            $sql = "Select * from `customers` where `user_type_id` = '1' order by `id` desc limit 1 ";
        } else if ( $user_type_id == 19 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( $user_type_id == 19 ) {
            $sql = "Select * from `customers` where `id` = '1' order by `id` desc limit 1 ";
        } else {
            $referral_id = Session::get("referral_id");
            $sql = "Select * from `customers` where `id` = $referral_id order by `id` desc limit 1 ";
        }
        $referencedata = DB::select( DB::raw( $sql ) );

        return view( 'member.memberwallet.memberrequestamount', compact( 'paymentrequest','referencedata') );
    }
	
	 public function memberrequestamount_approve(Request $request) {
		
        $amount = $request->amount;
	    $from_id = $request->from_id;
	    $row_id = $request->row_id;
        $login_id = Session::get("customer_id");
        $date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $status = 'Approved';
        $sql = "update request_payment set status = '$status' where id = $row_id";
        DB::update( DB::raw( $sql ) );
		$service_status = 'Out Payment';
		$ad_info = 'Fund Transfer';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,pay_id) values ('$login_id','$login_id','$from_id','$amount','$ad_info', '$service_status','$time','$date','$row_id')";
        DB::insert( DB::raw( $sql ) );
        $sql = "update customers set wallet = wallet + $amount where id = $from_id";
        DB::update( DB::raw( $sql ) );
        $service_status = 'IN Payment';
		$ad_info = 'Fund Transfer';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,pay_id) values ('$login_id','$from_id','$login_id','$amount','$ad_info', '$service_status','$time','$date','$row_id')";
        DB::insert( DB::raw( $sql ) );
        $sql = "update customers set wallet = wallet - $amount where id = $login_id";
        DB::update( DB::raw( $sql ) );

        $device_id = "";
        $device_token = DB::table( 'customers' )->where( 'id', '=', $from_id )->get();
        $device_id = $device_token[0]->device_id;

		$url = 'https://fcm.googleapis.com/fcm/send';
   //'to' for single user
   //'registration_ids' for multiple users
   $weburl =  '';
   //base_url( 'payments/pending' );
   $message = "You Have Received Amount"." ". $amount." . ".'Please Check Your Wallet.';

   $title = 'Nalavaryam';
   $body = $message;
   $icon = 'Nalavaryam';
   $click_action = $weburl;

   if ( isset( $title ) && !empty( $title ) )
{
       $fields = array(
           'to'=>$device_id,
           'notification'=>array(
               'body'=>$body,
               'title'=>$title,
               'icon'=>$icon,
               'click_action'=>$click_action
           )
       );
       //print_r( $fields );
       //exit;

       $headers = array(
           'Authorization: key=AAAABIWWI_c:APA91bGf79FDnwnPw1FgpFkVlryHBvf3F1hhi0uwfRPuZRV7jEKu4Hggezwbl61FBxpkeauYs13Gbmsu5xzZxQcGVKRs7k8LJOUZoUI7fw2QkZGBrzNW_r7192r6DrzV2X269LEzz27M',
           'Content-Type:application/json'
       );

       $ch = curl_init();
       curl_setopt( $ch, CURLOPT_URL, $url );
       curl_setopt( $ch, CURLOPT_POST, true );
       curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
       curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
       curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
       $result = curl_exec( $ch );
       curl_close( $ch );

       //print_r( $registrationIds );
   }
        return redirect( "memberrequestamount" )->with( 'success', 'Request Amount  Successfully' );
    }

    public function memberpaymentrequest(Request $request){
        $from_id = session::get("customer_id");
        $confirm = DB::table('request_payment')->insert([
          'from_id' => $from_id,
          'to_id' => $request->to_id,
          'amount' => $request->amount,
          'status' => 'Pending',
          'req_date' => date("Y-m-d"),
          'req_time' => date("Y-m-d H:i:s"),
        ]);
        $insertid = DB::getPdo()->lastInsertId();

        $paid_image = "";
        if ($request->paid_image != null) {
          $paid_image = $insertid.'.'.$request->file('paid_image')->extension();
          $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'paidimage' . DIRECTORY_SEPARATOR);
          move_uploaded_file($_FILES['paid_image']['tmp_name'], $filepath . $paid_image);
      }
      $image = DB::table('request_payment')->where('id', $insertid)->update([
          'req_image' => $paid_image,
        ]);
  
          return redirect( "memberrequestamount" );
      }
}