<?php
namespace App\Http\Controllers;
use Auth;
use App\WalletHelper;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulkServicesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function bulkbuy()
  {
    $status = "Pending";
    $login_id = Auth::user()->id;
    $dist_id = Auth::user()->dist_id;
    $user_type_id = Auth::user()->user_type_id;
    $referral_id = Auth::user()->referral_id;
    $sql = "select user_discount from user_type where id = $user_type_id";
    $usertype = DB::select(DB::raw($sql));
    $discount = $usertype[0]->user_discount;
    $sql="select id,full_name,phone,upi,payment_qr_oode from users where id = 1";
    $referral = DB::select(DB::raw($sql));
    $referral = $referral[0];
    $sql = "select a.*,c.district_name from service a,service_details b,district c where b.service_id=a.id and b.district_id=c.id and c.id= '$dist_id' and b.service_type = '2'";
    $bulkservice = DB::select(DB::raw($sql));
    $bulkservice = json_decode(json_encode($bulkservice), true);
    foreach ($bulkservice as $key => $service) {
      $used=1;
      $service_id = $service["id"];
      $sql="select * from bulk_service_usage where total > used and service_id=$service_id and user_id=$login_id";
      $unused=DB::select($sql);
      if(count($unused)>0){
        $used=0;
      }
      $payment = $service["service_payment"];
      $pay_amount = $payment - ($payment/100) * $discount;
      $pay_amount = ceil ($pay_amount / 5) *5;
      $bulkservice[$key]["pay_amount"] = $pay_amount;
      $bulkservice[$key]["used"] = $used;
    }
    $bulkservice = json_decode(json_encode($bulkservice));
    $balance =  WalletHelper::wallet_balance(Auth::user()->username);
    return view('service/bulk_service', compact('bulkservice','referral','balance'));
  }

  public function savebulkbuy(Request $request){
	  
    $customer_id = $request->bulk_customer_id;
    $added_date = date("Y-m-d H:i:s");
    $login_id = Auth::user()->id;
    $user_type_id = Auth::user()->user_type_id;
    $referral_id = Auth::user()->referral_id;
    $dist_id = Auth::user()->dist_id;
    $level2_user_id = 0;
    $level1_user_id = 0;
    if($user_type_id == 4 || $user_type_id == 6 || $user_type_id == 8 || $user_type_id == 10 || $user_type_id == 12){
      $sql = "select id from users where user_type_id = 4 and dist_id=$dist_id";
      $result = DB::select(DB::raw($sql));
      $level2_user_id = $result[0]->id;
      $sql = "select id from users where user_type_id = 2";
      $result = DB::select(DB::raw($sql));
      $level1_user_id = $result[0]->id;
    }
    if($user_type_id == 5 || $user_type_id == 7 || $user_type_id == 9 || $user_type_id == 11 || $user_type_id == 13){
      $sql = "select id from users where user_type_id = 5 and dist_id=$dist_id";
      $result = DB::select(DB::raw($sql));
      $level2_user_id = $result[0]->id;
      $sql = "select id from users where user_type_id = 3";
      $result = DB::select(DB::raw($sql));
      $level1_user_id = $result[0]->id;
    }
    $status = "Pending";
    foreach($request->all() as $key => $quantity){
      if(str_contains($key,'services_')){
        $temp = explode("_",$key);
        $service_id = $temp[1];
        $amount = $temp[2];
        if($quantity != ""){
          DB::table('bulk_service')->insert([
            'service_id'               =>   $service_id,
            'quantity'                 =>   $quantity,
            'amount'                   =>   $amount,
            'added_datetime'           =>   $added_date,
            'login_id'                 =>   $login_id,
            'user_type_id'             =>   $user_type_id,
            'district_id'              =>   $dist_id,
            'status'                   =>   $status,
          ]);
          $sql="select * from bulk_service_usage where service_id=$service_id and user_id=$login_id";
          $result=DB::select($sql);
          if(count($result)>0){
            $sql="update bulk_service_usage set total=total+$quantity where service_id=$service_id and user_id=$login_id";
            DB::update($sql);
          }else{
            $sql="insert into bulk_service_usage (user_id,service_id,total) values ($login_id,$service_id,$quantity)";
            DB::insert($sql);
          }
        }
      }
    }
    $total = 0;
    $sql = "select sum(amount*quantity) as total from bulk_service where login_id=$login_id and status in ('Pending')";
    $result = DB::select(DB::raw($sql));
    if(count($result) > 0){
      $total = $result[0]->total;
    } 
    $commission = 0;
    $to_userids[0]= 1;
    if($user_type_id == 4 || $user_type_id == 5){
      $to_userids[1]= $referral_id;
      $commission = $total/2;
    }else{
      $to_userids[1]= $referral_id;
      $to_userids[2]= $level1_user_id;
      $commission = $total/3;
    }
    $sql = "update bulk_service set status='Paid' where login_id=$login_id and status in ('Pending')";
    DB::update(DB::raw($sql));

    $superadmin_amount = 0;
    $sql = "select sum(amount*quantity) as total from bulk_service where login_id=$login_id and status in ('Paid')";
    $result = DB::select(DB::raw($sql));
    if(count($result) > 0){
      $admin_amount = $result[0]->total;
    }
    if($user_type_id == 4 || $user_type_id == 5){
      $superadmin_amount = $admin_amount / 2;
    }else{
      $superadmin_amount = $admin_amount / 3;
    }
    $sql = "update bulk_service set superadmin_amount=$superadmin_amount where login_id=$login_id and status in ('Paid')";
    DB::update(DB::raw($sql));
    $paydate = date('Y-m-d');
    $time = date("H:i:s");
    foreach($to_userids as $to_userid){
      $ad_info = "Bulk Service";
      $service_status = "Out Payment";
      $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$login_id','$login_id','$to_userid','$commission','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
      DB::insert(DB::raw($sql));
      $sql = "select username from users where id=$to_userid ";
      $result =  DB::select( DB::raw( $sql ));
      $tousername = $result[0]->username;
      $sql = "update wallet_users set wallet = wallet + $commission,commission = commission + $commission where username = '$tousername'";
      DB::update(DB::raw($sql));
      $ad_info = "Bulk Service";
      $service_status = "In Payment";
      $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$login_id','$to_userid','$login_id','$commission','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
      DB::insert(DB::raw($sql));
      $sql = "select username from users where id=$login_id ";
      $result =  DB::select( DB::raw( $sql ));
      $logusername = $result[0]->username;
      WalletHelper::debitWallet2($logusername,$commission);
    }
    if($request->delivery_amount != ""){
      $amount = $request->delivery_amount;
      $to_userid = 1;
      $ad_info = "Bulk Service Delivery Amount";
      $service_status = "Out Payment";
      $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$login_id','$login_id','$to_userid','$amount','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
      DB::insert(DB::raw($sql));

      $sql = "select username from users where id=1";
      $result =  DB::select( DB::raw( $sql ));
      $tousername = $result[0]->username;
      $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$tousername'";
      DB::update(DB::raw($sql));

      $ad_info = "Bulk Service Delivery Amount";
      $service_status = "In Payment";
      $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$login_id','$to_userid','$login_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
      DB::insert(DB::raw($sql));
      $sql = "select username from users where id=$login_id ";
      $result =  DB::select( DB::raw( $sql ));
      $logusername = $result[0]->username;
      WalletHelper::debitWallet2($logusername,$amount);
    }
    return redirect( "viewservices/$customer_id" );
  }

  public function bulkorders()
  {
    $login_id = Auth::user()->id;
    $user_type_id = Auth::user()->user_type_id;
    $dist_id = Auth::user()->dist_id;
    if($user_type_id == 1 || $user_type_id == 2 || $user_type_id == 3 || $user_type_id == 4 || $user_type_id == 5 ){
      $sql = "";
      if($user_type_id == 1){
        $sql ="select a.*,b.district_name from users a,district b where a.dist_id=b.id and a.id in (select distinct login_id from bulk_service where status='Paid')";
      }elseif($user_type_id == 2 || $user_type_id == 3 || $user_type_id == 4 || $user_type_id == 5){
        $sql ="select a.*,b.district_name from users a,district b where a.dist_id=b.id and a.id in (select distinct login_id from bulk_service where status='Paid' and user_type_id in (4,5,6,7,8,9,10,11,12,13))";
      }
      $bulkorders = DB::select(DB::raw($sql));
      return view('service/bulkorders', compact('bulkorders'));
    }else{
      echo "<h1>Access Denied</h1>";
    }
  }

  public function viewbulkorders($user_id){
    $sql = "select a.*,b.service_name from bulk_service a,service b where a.service_id=b.id and a.status='Paid' and a.login_id = $user_id";
    $bulkorders = DB::select(DB::raw($sql));
    $sql ="select a.*,b.district_name from users a,district b where a.dist_id=b.id and a.id=$user_id";
    $user = DB::select(DB::raw($sql))[0];
    return view('service/viewbulkorders', compact('bulkorders','user'));
  }

  public function updatebulkstatus(Request $request){
    $user_id = $request->user_id;
    $to_id = Auth::user()->id;
    $paydate = date('Y-m-d');
    $time = date("H:i:s");
    $from_id = 1;
    $commission = 0;
    $sql = "select * from bulk_service where status='Paid' and login_id = $user_id and superadmin_amount > 0 order by id desc limit 1";
    $bulkorders = DB::select(DB::raw($sql));
    foreach($bulkorders as $order){
      $commission = $order->superadmin_amount;
    }
    $ad_info = "Bulk Service";
    $service_status = "Out Payment";
    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$from_id','$from_id','$to_id','$commission','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
    DB::insert(DB::raw($sql));
    $sql = "select username from users where id=$to_id ";
    $result =  DB::select( DB::raw( $sql ));
    $tousername = $result[0]->username;
    $sql = "update wallet_users set wallet = wallet + $commission,commission = commission + $commission where username = '$tousername'";
    DB::update(DB::raw($sql));
    $ad_info = "Bulk Service";
    $service_status = "In Payment";
    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$to_id','$from_id','$commission','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
    DB::insert(DB::raw($sql));
    $sql = "select username from users where id=$from_id ";
    $result =  DB::select( DB::raw( $sql ));
    $frmusername = $result[0]->username;
    WalletHelper::debitWallet2($frmusername,$commission);
//$sql = "update users set wallet = wallet - $commission where id = $from_id";
//DB::update(DB::raw($sql));
    if($request->delivery_amount != 0){
      $amount = $request->delivery_amount;
      $ad_info = "Bulk Service Delivery Amount";
      $service_status = "Out Payment";
       $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$from_id','$from_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
    DB::insert(DB::raw($sql));
    $sql = "select username from users where id=$to_id ";
    $result =  DB::select( DB::raw( $sql ));
    $tousername = $result[0]->username;
    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$tousername'";
    DB::update(DB::raw($sql));
    $ad_info = "Bulk Service Delivery Amount";
    $service_status = "In Payment";
    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$to_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
    DB::insert(DB::raw($sql));
    $sql = "select username from users where id=$from_id ";
    $result =  DB::select( DB::raw( $sql ));
    $frmusername = $result[0]->username;
    WalletHelper::debitWallet2($frmusername,$amount);
    }
    $status = $request->status;
    $sql = "update bulk_service set status='$status' where login_id=$user_id";
    DB::update(DB::raw($sql));
    return redirect("bulkorders");
  }

  public function pendingbulkservice(){
    $dist_id = Auth::user()->dist_id;
    $user_id = Auth::user()->id;
    $user_type_id = Auth::user()->user_type_id;
    $sql = "";
    if($user_type_id == 1){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.status='Paid'";
    }elseif($user_type_id == 2  || $user_type_id == 3 || $user_type_id == 4 || $user_type_id == 5){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.status='Paid'";
    }elseif($user_type_id > 5 || $user_type_id < 14){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.district_id=$dist_id and a.login_id=$user_id and a.status='Paid'";
    }
    $pending = DB::select(DB::raw($sql));
    return view('service/pendingbulkservice',compact('pending'));
  }

  public function deliveredbulkservice(){
    $dist_id = Auth::user()->dist_id;
    $user_id = Auth::user()->id;
    $user_type_id = Auth::user()->user_type_id;
    $sql = "";
    if($user_type_id == 1){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.status='Delivered'";
    }elseif($user_type_id == 2  || $user_type_id == 3 || $user_type_id == 4 || $user_type_id == 5){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.status='Delivered'";
    }elseif($user_type_id > 5 || $user_type_id < 14){
      $sql = "select a.*,b.service_name,c.district_name from bulk_service a,service b,district c where a.service_id=b.id and a.district_id=c.id and a.district_id=$dist_id and a.login_id=$user_id and a.status='Delivered'";
    }
    $pending = DB::select(DB::raw($sql));
    return view('service/deliveredbulkservice',compact('pending'));
  }

  public function bulkrequestamount( Request $request ) {
    $from_id = Auth::user()->id;
    $to_id = $request->to_id;
    $confirm = DB::table( 'request_payment' )->insert( [
        'from_id'  => $from_id,
        'to_id'    => $request->to_id,
        'amount'   => $request->payamount,
        'status'   => 'Pending',
        'req_date' => date( 'Y-m-d' ),
        'req_time' => date( 'Y-m-d H:i:s' ),
    ] );
    $insertid = DB::getPdo()->lastInsertId();

    $bulk_image = '';
    if ( $request->req_image != null ) {
        $bulk_image = $insertid . '.' . $request->file( 'req_image' )->extension();
        $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'paidimage' . DIRECTORY_SEPARATOR );
        move_uploaded_file( $_FILES[ 'req_image' ][ 'tmp_name' ], $filepath . $bulk_image );
    }

    $image = DB::table( 'request_payment' )->where( 'id', $insertid )->update( [
        'req_image' => $bulk_image,
    ] );

    return redirect()->back()->with( 'success', 'Bulk Service Request Amount Successfully ... !' );
}
}
