<?php
namespace App\Http\Controllers;
use App\WalletHelper;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{


    public function services()
    {
        $viewservices = DB::table( 'service' )->orderBy( 'id', 'Asc' )->get();
        $district = DB::table( 'district' )->where( 'status', 'Active' )->orderBy( 'id', 'Asc' )->get();

        return view( 'service/viewservices', compact( 'viewservices','district' ) );
    }

    public function addservice( Request $request ) {
//dd($request->all());
        $from_date = "";
        $to_date = "";
        if($request->has('from_date')){
            $from_date = $request->from_date;
        }
        if($request->has('to_date')){
            $to_date = $request->to_date;
        }
        $adduser = DB::table( 'service' )->insert( [
            'service_name' => $request->service_name,
            'service_payment' => $request->service_payment,
            'status' => 'Active',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'servicetype' => $request->servicetype,

        ] );

        $last_insert_id = DB::getPdo()->lastInsertId();
        $fromimage = '';
        if ( $request->from_image != null ) {
            $fromimage = $last_insert_id . '.' . $request->file( 'from_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'fromimg' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'from_image' ][ 'tmp_name' ], $filepath . $fromimage );
        }
        $addimg = DB::table( 'service' )->where( 'id', $last_insert_id )->update( [
            'from_image' => $fromimage,

        ] );

        if ( $request->has( 'dist_id' ) ) {
            foreach ( $request->input( 'dist_id' ) as $key => $type ) {
                $name = 'check_'.$type;
                $pre = $request[ $name ];
                $pre = $pre == '2' ? 2 : 1;
                DB::table( 'service_details' )->insert( [
                    'service_id'       =>   $last_insert_id,
                    'district_id'       =>   $type,
                    'service_type'      =>   $pre
                ] );
            }
        }
        return redirect()->back()->with( 'success', 'Service Added Successfully ... !' );
    }

    public function editservice($id) {

        $viewservices = DB::table( 'service' )->where( 'id', $id )->orderBy( 'id', 'Asc' )->get();
        $viewservices = json_decode( json_encode( $viewservices ), true );
        foreach ( $viewservices as $key => $service ) {
            $viewservices[ $key ][ 'district' ] = array();
            $service_id = $service[ 'id' ];
            $sql = "select a.service_type,a.district_id,b.district_name from service_details a,district b where a.district_id = b.id and a.service_id=$service_id order by a.id Asc";
            $result = DB::select( $sql );

            $viewservices[ $key ][ 'type' ] = $result;
        }
        $viewservices = json_decode( json_encode( $viewservices ));
//dd($viewservices);
        $district = DB::table( 'district' )->where( 'status', 'Active' )->orderBy( 'id', 'Asc' )->get();

        return view( 'service/editservice', compact( 'viewservices','district' ) );
    }

    public function updateservice( Request $request ) {
        $from_date = "";
        $to_date = "";
        if($request->has('from_date')){
            $from_date = $request->from_date;
        }
        if($request->has('to_date')){
            $to_date = $request->to_date;
        }
        $adduser = DB::table( 'service' )->where( 'id', $request->service_id )->update( [
            'service_name' => $request->service_name,
            'service_payment' => $request->service_payment,
            'status' => $request->status,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'servicetype' => $request->servicetype,
        ] );

        if ( $request->has( 'dist_id' ) ) {
            DB::table( 'service_details' )->where( 'service_id', $request->service_id )->delete();
            foreach ( $request->input( 'dist_id' ) as $key => $type ) {
                $name = 'check_'.$type;
                $pre = $request[ $name ];
                $pre = $pre == '2' ? 2 : 1;
                DB::table( 'service_details' )->insert( [
                    'service_id'       =>   $request->service_id,
                    'district_id'       =>   $type,
                    'service_type'      =>   $pre
                ] );
            }
        }


        $service_id = $request->service_id;
        if ( $request->from_image != null ) {
            $fromimage = $service_id . '.' . $request->file( 'from_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'fromimg' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'from_image' ][ 'tmp_name' ], $filepath . $fromimage );
        }
        if ( $request->from_image == '' ) {
            return redirect()->back()->with( 'success', 'Service Updated Successfully ... !' );
        } else {
            $addimg = DB::table( 'service' )->where( 'id', $service_id )->update( [
                'from_image' => $fromimage,
            ] );
        }

        return redirect()->back()->with( 'success', 'Service Updated Successfully ... !' );
    }

    public function viewservices( $customer_id ) {
        $balance =  WalletHelper::wallet_balance(Auth::user()->username);
        $dist_id = Auth::user()->dist_id;
        $login_id = Auth::user()->id;
        $referral_id = Auth::user()->referral_id;
        $user_type = Auth::user()->user_type_id;
        $status = Auth::user()->status;
        $from_to_date = Auth::user()->from_to_date;
        $today = date( 'Y-m-d' );
        $additional_amount = 0;
        if ( $user_type > 3 && $user_type < 14 && ( $status == 'Inactive' || $from_to_date < $today ) ) {
            $additional_amount = 30;
        }
        $sql = "select * from customers where id = $customer_id";
        $result = DB::select( DB::raw( $sql ) );
        $result = $result[ 0 ];
        $cust_user_type_id  = $result->user_type_id;
        $cust_status  = $result->status;
        $cust_dist_id  = $result->dist_id;
        $cust_taluk_id = $result->taluk_id;
        $cust_panchayath_id = $result->panchayath_id;
        $user_dist_id  = Auth::user()->dist_id;
        $user_taluk_id  = Auth::user()->taluk_id;
        $user_panchayath_id  = Auth::user()->panchayath_id;
        $sql = "select * from user_type where id = $user_type";
        $usertype = DB::select( DB::raw( $sql ) );
        $user_discount = $usertype[ 0 ]->user_discount;
        $other_discount = $usertype[ 0 ]->other_discount;
        $discount = $user_discount;
        if ( $user_type == 6 || $user_type == 7 || $user_type == 10 || $user_type == 11 || $user_type == 8 || $user_type == 9 ) {
            if ( $cust_taluk_id != $user_taluk_id ) $discount = $other_discount;
        } else if ( $user_type == 12 || $user_type == 13 ) {
            if ( $cust_panchayath_id != $user_panchayath_id ) $discount = $other_discount;
        }
        if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3){
            $sql = "Select * from `users` where `id` = 1";
        }else{
            $sql = "Select * from `users` where `id` = $referral_id";
        }
        $referral = DB::select( DB::raw( $sql ) );
        $referral = $referral[ 0 ];

        $sql = "select a.*,c.district_name from service a,service_details b,district c where b.service_id=a.id and b.district_id=c.id and b.service_type = '1' and c.id='$dist_id' and (('$today' >= from_date and '$today' <= to_date) or from_date is NULL)";
        $services = DB::select( DB::raw( $sql ) );
        $services = json_decode( json_encode( $services ), true );
        foreach ( $services as $key1 => $service ) {
            $service_id = $service["id"];
            $payment = $service[ 'service_payment' ];
            $pay_amount = $payment - ( $payment/100 ) * $discount;
            $pay_amount = ceil ( $pay_amount / 5 ) *5;
            $pay_amount = $pay_amount + $additional_amount;

            if(($cust_user_type_id == 20 || $cust_user_type_id == 21) && $cust_status == "Active"){
                $services[ $key1 ][ 'pay_amount' ] = "0";
            }else{
                $services[ $key1 ][ 'pay_amount' ] = $pay_amount;
            }
            $sql = "select * from payments where service_id = '$service_id' and customer_id='$customer_id'";
            if($user_type != 1 && $user_type != 2 && $user_type != 3){
                $sql = $sql . " and log_id = $login_id";
            }
            $sql = $sql . " order by id desc limit 1";
            $result = DB::select( DB::raw( $sql ) );
            $service_status = '';
            $action = '';
            $output_image = '';
            if ( count( $result ) > 0 ) {
                $service_status = $result[ 0 ]->service_status;
                if ( $service_status == 'Paid' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $action = 'Create Form';
                        }
                    } else {
                        $action = 'Pending';
                    }

                } else if ( $service_status == 'Pending' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $action = 'Waiting';
                        } else {
                            $action = 'Pay Now';
                        }
                    } else {
                        $action = 'Pay Now';
                    }
                } else if ( $service_status == 'Rejected' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $action = 'Reject Form';
                        } else {
                            $action = 'Pay Now';
                        }
                    } else {
                        $action = 'Pay Now';
                    }
                } else if ( $service_status == 'Img' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $output_image = $result[ 0 ]->from_image;
                            $action = 'Output';
                        } else {
                            $action = 'Pay Now';
                        }
                    } else {
                        $action = 'Pay Now';
                    }

                }
            } else {
                $action = 'Pay Now';
            }
            $services[ $key1 ][ 'service_status' ] = $service_status;
            $services[ $key1 ][ 'action' ] = $action;
            $services[ $key1 ][ 'output_image' ] = $output_image;
        }
        $services = json_decode( json_encode( $services ) );
        $sql = "select id as customer_id,user_type_id as customer_user_type_id,dist_id,taluk_id,panchayath_id from customers where id=$customer_id";
        $customer = DB::select( DB::raw( $sql ) );
        $customer = $customer[ 0 ];


        $sql = "select user_discount from user_type where id = $user_type";
        $usertype = DB::select(DB::raw($sql));
        $discount = $usertype[0]->user_discount;

        $sql = "select a.*,c.district_name from service a,service_details b,district c where b.service_id=a.id and b.district_id=c.id and c.id= '$dist_id' and b.service_type = '2'";
        $bulkservice = DB::select( DB::raw( $sql ) );

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

    $viewcustomers = array();
    $referral_id = Auth::user()->id;
    $dist_id = Auth::user()->dist_id;
    if ( Auth::user()->user_type_id == 1 ) {
      $user_type_id = array( '14', '15' );
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->wherein( 'customers.user_type_id', $user_type_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( Auth::user()->user_type_id == 2 ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( Auth::user()->user_type_id == 3 ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();
    } elseif ( Auth::user()->user_type_id == 4 ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( Auth::user()->user_type_id == 5 ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 12 ) ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 13 ) ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();
    }
    $authdistrict_id = Auth::user()->dist_id;
    $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
    $authdistrictown = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->first();
    $managedistrict = DB::table( 'district' )->get();
	
    $CompletedCount = DB::table( 'payments' )->where( 'log_id', '=', $referral_id )->where( 'online_status_id', '=', 'Completed' )->where( 'service_status', '=', 'Img' )->count();
    $ResubmitCount = DB::table( 'payments' )->where( 'log_id', '=', $referral_id )->where( 'online_status_id', '=', 'Resubmit' )->count();

        return view( 'service/services', compact( 'services', 'usertype', 'customer', 'referral','balance','bulkservice','viewcustomers', 'authdistrict', 'managedistrict','authdistrictown','CompletedCount' ,'ResubmitCount' ) );
    }


    public function upload_offline_form( Request $request ) {
        $service_id = $request->form_service_id;
        $customer_id = $request->customer_id;
        $log_id = Auth::user()->id;
        $dist_id  = Auth::user()->dist_id ;
        $taluk_id = Auth::user()->taluk_id;
        $panchayath_id = Auth::user()->panchayath_id;
        if($panchayath_id == ""){
            $panchayath_id = 0;
        }
        if($taluk_id == ""){
            $taluk_id = 0;
        }
        $user_type_id = Auth::user()->user_type_id;
        $paydate = date( 'Y-m-d' );
        $service_status = 'Img';
        $online_status_id='Completed';
        $time = date( 'H:i:s' );
        $fileName="";
        $targetDir = 'upload/output/';
        if ( !empty( $_FILES[ 'photo' ][ 'name' ] ) ) {
            $fileType = pathinfo( $_FILES[ 'photo' ][ 'name' ], PATHINFO_EXTENSION );
            $fileName = 'outputimage_' . floor( microtime( true ) * 1000 ).'.'.$fileType;
            $targetFilePath1 = $targetDir . $fileName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath1);
        }
        $sql = "insert into payments (customer_id,service_id,service_status,log_id,dist_id,taluk_id,panchayath_id,user_type_id,paydate,time,online_status_id,from_image) values ('$customer_id','$service_id','$service_status','$log_id','$dist_id','$taluk_id',$panchayath_id,'$user_type_id','$paydate','$time','$online_status_id','$fileName')";
        DB::insert( DB::raw( $sql ) );
        $sql="update bulk_service_usage set used=used+1 where user_id=$log_id and service_id=$service_id";
        DB::update($sql);
        return redirect( "viewservices/$customer_id" );
    }

    public function servicepayment( Request $request ) {
        $service_id = $request->service_id;
        $customer_id = $request->customer_id;
        $customer_user_type_id = $request->customer_user_type_id;
        $amount = $request->pay_amount;
        $log_id = Auth::user()->id;
        $referral_id = Auth::user()->referral_id;
        $dist_id  = Auth::user()->dist_id ;
        $taluk_id = Auth::user()->taluk_id;
        $panchayath_id = Auth::user()->panchayath_id;
        if($panchayath_id == ""){
            $panchayath_id = 0;
        }
        if($taluk_id == ""){
            $taluk_id = 0;
        }
        $user_type_id = Auth::user()->user_type_id;
        $paydate = date( 'Y-m-d' );
        $service_status = 'Paid';
        $time = date( 'H:i:s' );
        $sql = "insert into payments (amount,customer_id,service_id,service_status,log_id,dist_id,taluk_id,panchayath_id,user_type_id,paydate,time) values ('$amount','$customer_id','$service_id','$service_status','$log_id','$dist_id','$taluk_id',$panchayath_id,'$user_type_id','$paydate','$time')";
        DB::insert( DB::raw( $sql ) );
        $pay_id = DB::getPdo()->lastInsertId();
        $sql = "select username from users where id=$log_id ";
        $result =  DB::select( DB::raw( $sql ));
        $logusername = $result[0]->username;
        WalletHelper::debitWallet2($logusername,$amount);
//$sql = "update users set wallet = wallet - $amount where id = $log_id";
//DB::update(DB::raw($sql));
        $sql = "with recursive cte (id,full_name, user_type_id, referral_id) as (
        select     id,
        full_name,
        user_type_id,
        referral_id
        from       users
        where      id = $referral_id
        union all
        select     p.id,
        p.full_name,
        p.user_type_id,
        p.referral_id
        from       users p
        inner join cte
        on p.id = cte.referral_id
        )
        select * from cte;";

        $result = DB::select( DB::raw( $sql ) );
        $time = date( 'H:i:s' );
        $count = count( $result );
        if ( $count > 0 )
            $sql2 = "select user_type_id from users where id=$referral_id";
        $result2 =  DB::select( DB::raw( $sql2 ));
        $usertype = $result2[0]->user_type_id;
        if($count == 2 && ($usertype == 4 || $usertype == 5)){
            if(Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13){
                $amount = $amount / 3;
                $sql1 = "select id,full_name,user_type_id,referral_id from users where id=1 ";
                $result1 =  DB::select( DB::raw( $sql1 ));
                $result1 = json_decode( json_encode( $result1 ),true );
                $result = json_decode( json_encode( $result ),true );
                $result = array_merge($result, $result1);
                $result = json_decode( json_encode( $result ));
            }else{
                $amount = $amount/$count;
            }
        } else{
            $amount = $amount/$count;
        }
        foreach ( $result as $row ) {

            $to_id = $row->id;
            $ad_info = 'Income';
            $ad_info2 = 'ServicePayment';
            $service_status = 'Out Payment';
            $sql = "insert into payment (log_id,from_id,to_id,customer_id,service_id,pay_id,amount,ad_info,service_status,time,paydate,ad_info2,service_entity) values ('$log_id','$log_id','$to_id', '$customer_id','$service_id','$pay_id','$amount','$ad_info', '$service_status','$time','$paydate','$ad_info2','nalavariyam')";
            DB::insert( DB::raw( $sql ) );
            $sql = "select username from users where id=$to_id ";
            $result =  DB::select( DB::raw( $sql ));
            $tousername = $result[0]->username;
            $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$tousername'";
            DB::update( DB::raw( $sql ) );
            $ad_info = 'Application';
            $service_status = 'IN Payment';
            $sql = "insert into payment (log_id,from_id,to_id,customer_id,service_id,pay_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id', '$customer_id','$service_id','$pay_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
            DB::insert( DB::raw( $sql ) );
        }
        return redirect( "viewservices/$customer_id" );
    }

    public function createapplication( Request $request ) {
        define ( 'SITE_ROOT', realpath( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
        $service_id = $request->imservice_id;
        $customer_id = $request->imcustomer_id;
        $customer_user_type_id = $request->imcustomer_user_type_id;
        $user_type_id  = 0;
        if ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) || ( Auth::user()->user_type_id == 16 ) ) {
            $user_type_id = '4';
        } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) || ( Auth::user()->user_type_id == 17 ) ) {
            $user_type_id = '5';
        }
        $user_id = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $sql = "select * from service where id = $service_id";

        $result = DB::select( DB::raw( $sql ) );
        $marge_right = $result[ 0 ]->marge_right;

        $marge_bottom = $result[ 0 ]->marge_bottom;

        $targetDir = 'upload/output/';
//$sql = "select signature2 from users where dist_id = $dist_id and user_type_id = $user_type_id";

        $sql = "SELECT signature_name FROM dist_signature
        WHERE dist_id = $dist_id and signature_date in (SELECT max(signature_date) FROM dist_signature where dist_id = $dist_id)";
//echo $sql;die;
        $result = DB::select( DB::raw( $sql ) );
        if(count($result) == 1){
            $signature_name = $result[ 0 ]->signature_name;
        }elseif(count($result) == 2){
            $sql1 = "select signature_name from dist_signature where dist_id = $dist_id and user_type_id = $user_type_id";
            $result1 = DB::select( DB::raw( $sql1 ) );

            $signature_name = $result1[ 0 ]->signature_name;
        }
        $watermarkImagePath = 'upload/off/'.$signature_name;

//echo $watermarkImagePath;die;
        $statusMsg = '';
        if ( !empty( $_FILES[ 'photo' ][ 'name' ] ) ) {

            $fileType = pathinfo( $_FILES[ 'photo' ][ 'name' ], PATHINFO_EXTENSION );

            $fileName = 'outputimage_' . floor( microtime( true ) * 1000 ).'.'.$fileType;

            $targetFilePath1 = $targetDir . $fileName;

            $allowTypes = array( 'jpg', 'png', 'jpeg' );

            if ( in_array( $fileType, $allowTypes ) ) {

                if ( move_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ], $targetFilePath1 ) ) {

                    $watermarkImg = imagecreatefrompng( $watermarkImagePath );

                    switch( $fileType ) {

                        case 'jpg':
                        $im = imagecreatefromjpeg( $targetFilePath1 );

                        break;

                        case 'jpeg':
                        $im = imagecreatefromjpeg( $targetFilePath1 );

                        break;

                        case 'png':
                        $im = imagecreatefrompng( $targetFilePath1 );

                        break;

                        default:
                        $im = imagecreatefromjpeg( $targetFilePath1 );

                    }

                    $sx = imagesx( $watermarkImg );

                    $sy = imagesy( $watermarkImg );

                    imagecopy( $im, $watermarkImg, imagesx( $im ) - $sx - $marge_right, imagesy( $im ) - $sy - $marge_bottom, 0, 0, imagesx( $watermarkImg ), imagesy( $watermarkImg ) );

                    imagejpeg( $im, $targetFilePath1 );

                    imagedestroy( $im );
                    if ( file_exists( $targetFilePath1 ) ) {
                        $sql = "select * from payments where customer_id = $customer_id  and service_status in ('Paid','Rejected') order by id limit 1 ";
	//echo $sql; die;
                        $result = DB::select( DB::raw( $sql ) );
                        $payments_id = $result[ 0 ]->id;
                        $time = date( 'H:i:s' );
                        $sql = "update payments set from_image='$fileName',service_id='$service_id',customer_id='$customer_id',customer_user_type_id='$customer_user_type_id',log_id='$user_id',service_status='Pending',dist_id='$dist_id',time='$time' where id=$payments_id";
                        DB::update( DB::raw( $sql ) );

                        if ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) ) {

                            $District = '4';
                            $Special = '16';

                        }
                        if ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) ) {

                            $District = '5';
                            $Special = '17';
                        }
                        $distID = Auth::user()->dist_id;

                        $sql = "Select device_id from users where user_type_id ='$District' and dist_id='$distID'";
                        $result = DB::select( DB::raw( $sql ) );
                        foreach ( $result as $res ) {
                            $registrationIds[] = $res->device_id;
                        }

                        $sql2 = 'Select device_id from users where user_type_id in (16,17)';
                        $result = DB::select( DB::raw( $sql2 ) );
                        foreach ( $result as $res ) {
                            $registrationIds[] = $res->device_id;
                        }

                        $sql3 = "Select device_id from users where id ='1'";
                        $result = DB::select( DB::raw( $sql3 ) );
                        foreach ( $result as $res ) {
                            $registrationIds[] = $res->device_id;
                        }

                        $url = 'https://fcm.googleapis.com/fcm/send';
    //'to' for single user
    //'registration_ids' for multiple users
                        $weburl =  '';
    //base_url( 'payments/pending' );
                        $message = 'Service: 1, Service Status: Pending';

                        $title = 'Nalavaryam';
                        $body = $message;
                        $icon = 'Nalavaryam';
                        $click_action = $weburl;

                        if ( isset( $title ) && !empty( $title ) )
                        {
                            $fields = array(
                                'registration_ids'=>$registrationIds,
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
        //print_r( $result );
                            curl_close( $ch );

        //print_r( $registrationIds );
        //die();
                        }

                    }

                }
            }
        }
        return redirect( "viewservices/$customer_id" );

    }

    public function pending()
    {
        $service_Rejected = '';
        $service_Img = '';
        $service_Pending = 'Pending';

        if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 ) || ( Auth::user()->id == 21 ) || ( Auth::user()->id == 4916 ) || ( Auth::user()->id == 3185 ) || ( Auth::user()->id == 65 ) || ( Auth::user()->id == 38 ) || ( Auth::user()->id == 11719 ) || ( Auth::user()->id == 97 )) {

            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.district_name', 'users.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Pending )->orderBy( 'payments.id', 'desc' )->get();
// echo $servicestatus;die;
// echo'<pre>';print_r( $servicestatus );echo'</pre>';die;
        } else {

            $log_id = Auth::user()->id;
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.district_name', 'customers.phone', 'customers.full_name', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Pending )->where( 'payments.log_id', $log_id )->orderBy( 'payments.id', 'desc' )->get();

        }
        $servicestatus = json_decode(json_encode($servicestatus),true);
        foreach($servicestatus as $key => $serv){
            $utype = $serv["customer_user_type_id"];
            $customer_id = $serv["customer_id"];
            $servicestatus[$key]['full_name'] = "";
            $servicestatus[$key]['phone2'] = "";
            $servicestatus[$key]['registeration_no'] = "";
            if($utype == 18 || $utype == 19 || $utype == 20 || $utype == 21){
                $sql = "select full_name,phone,registeration_no from customers where id=$customer_id";
                $res = DB::select($sql);
                if(count($res)>0){
                    $servicestatus[$key]['full_name'] = $res[0]->full_name;
                    $servicestatus[$key]['phone2'] = $res[0]->phone;
                    $servicestatus[$key]['registeration_no'] = $res[0]->registeration_no;
                }
            }
        }
        $servicestatus = json_decode(json_encode($servicestatus),false);
        $remarks = DB::table( 'remarks' )->orderBy( 'id', 'Asc' )->get();

        return view( 'service/status', compact( 'servicestatus', 'service_Pending','remarks' ) );
    }


    public function onlinestatus( $status ,$from, $to  )
    {
        $user_id = Auth::user()->id;
        $service_Rejected = '';
        $service_Img = 'Img';
        $service_Pending = '';
        if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 )) {

            $onlinestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone as usersphone', 'service.service_name', 'service.service_payment', 'customers.phone as customersphone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', $status )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )
            ->orderBy( 'payments.id', 'Asc' )->get();
//echo $completed;die;
        } else {
            $log_id = Auth::user()->id;
            $onlinestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone as usersphone', 'customers.full_name_tamil', 'customers.id as customersID', 'customers.phone as customersphone', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', $status )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )
            ->orderBy( 'payments.id', 'Asc' )->get();
        }
        $online_status = DB::table( 'online_status' )->orderBy( 'id', 'asc' )->get();
//print_r($online_status);die;

        $onlinestatus_menu = DB::table( 'payments' )->select( 'online_status_id')->whereNotNull('online_status_id')->distinct('online_status_id')
        ->orderBy( 'online_status_id', 'Asc' )->get();

        return view( 'service/onlinestatus', compact( 'onlinestatus', 'service_Rejected', 'service_Img', 'service_Pending','online_status','from','to','status','onlinestatus_menu') );
    }



    public function completed( $from, $to )
    {
        $user_id = Auth::user()->id;
        $service_Rejected = '';
        $service_Img = 'Img';
        $service_Pending = '';
        if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 )) {

            $completed = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Completed' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();
//echo $completed;die;
            $custom1 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Applied' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom2 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Vao Approved' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom3 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Resubmit' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom4 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Clarification Replied' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom5 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Forward' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom6 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Approved' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom7 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name', 'service.service_payment', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Rejected' )
            ->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

        } else {
            $log_id = Auth::user()->id;
            $completed = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Completed' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom1 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Applied' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom2 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Vao Approved' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom3 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Resubmit' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom4 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Clarification Replied' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom5 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Forward' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom6 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Approved' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

            $custom7 = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name_tamil', 'customers.id as customersID', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )
            ->where( 'payments.online_status_id', 'Rejected' )
            ->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();
        }

        $online_status = DB::table( 'online_status' )->orderBy( 'id', 'asc' )->get();
//print_r($online_status);die;
        $onlinestatus_menu = DB::table( 'payments' )->select( 'online_status_id')->whereNotNull('online_status_id')->distinct('online_status_id')->orderBy( 'online_status_id', 'Asc' )->get();
        return view( 'service/statuscompleted', compact( 'completed','custom1','custom2','custom3','custom4','custom5','custom6','custom7', 'service_Rejected', 'service_Img', 'service_Pending', 'from', 'to','online_status','onlinestatus_menu') );
    }

    public function updatecompleteddetails( Request $request ) {
//dd($request->all());
        $updatestatus = DB::table( 'payments' )->where( 'id', $request->payments_id )->update( [
            'app_no' => $request->app_no,
            'mobile_no' => $request->mobile_no,
            'reason' => $request->online_reason,
            'online_status_id' => $request->online_status_id,
        ] );

        return redirect()->back();
    }

    public function rejected()
    {
        $service_Rejected = 'Rejected';
        $service_Img = '';
        $service_Pending = '';

//if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 ) || ( Auth::user()->id == 21 ) || ( Auth::user()->id == 32 ) || ( Auth::user()->id == 4916 ) || ( Auth::user()->id == 65 ) || ( Auth::user()->id == 41 ) || ( Auth::user()->id == 97) || (Auth::user()->id == 11719) || (Auth::user()->id == 3185) ) {
        if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 )) {

            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'users.phone', 'service.service_name','remarks.remark_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'users', 'users.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'remarks', 'remarks.id', '=', 'payments.reason' )
            ->where( 'payments.service_status', $service_Rejected )->orderBy( 'payments.id', 'Asc' )->get();

        } else {

            $log_id = Auth::user()->id;
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'customers.full_name', 'service.service_name','remarks.remark_name','payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.customer_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->Join( 'remarks', 'remarks.id', '=', 'payments.reason' )
            ->where( 'payments.service_status', $service_Rejected )->where( 'payments.log_id', $log_id )->orderBy( 'payments.id', 'Asc' )->get();

        }

        return view( 'service/status', compact( 'servicestatus', 'service_Rejected', 'service_Img', 'service_Pending' ) );
    }

    public function serviceupdatestatus( Request $request ) {
        $from = date( 'Y-m-d', strtotime( '-6 days' ) );
        $to =  date( 'Y-m-d' );
        $service_status = $request->service_status;

        $updatestatus = DB::table( 'payments' )->where( 'id', $request->service_id )->update( [
            'service_status' => $service_status,
            'reason' => $request->reason,
        ] );
        if($service_status == "Img"){
            $updatestatus = DB::table( 'payments' )->where( 'id', $request->service_id )->update( [
                'online_status_id' => 'Completed',
            ] );
        }
        if ( $service_status == 'Img' ) {
            return redirect( 'pending' );
        } elseif ( $service_status == 'Rejected' ) {
            return redirect( 'pending' );
        } elseif ( $service_status == 'Pending' ) {
            return redirect( 'pending' );
        }
    }

    public function completedbill( Request $request ) {
        $from = date( 'Y-m-d', strtotime( '-6 days' ) );
        $to =  date( 'Y-m-d' );
        $completedbill = DB::table( 'payments' )->where( 'id', $request->payment_id )->update( [
            'adsional_amount' => $request->adsional_amount,
            'reference_id'    => $request->reference_id,
            'bill'            => 2,
        ] );

        return redirect( "completed/$from/$to" );
    }

    public function receipt( $cust_id, $id ) {
        $loginid = Auth::user()->id;
        $sql = "Select * from users where id = $loginid order by id desc limit 1";
        $loginuser = DB::select( DB::raw( $sql ) );
        $user_name = $loginuser[ 0 ]->full_name;
        $user_address = $loginuser[ 0 ]->permanent_address_1;
        $user_phone = $loginuser[ 0 ]->phone;

        $sql1 = "Select * from customers where id = $cust_id order by id desc limit 1";
        $customerdata = DB::select( DB::raw( $sql1 ) );
        $customer_name = $customerdata[ 0 ]->full_name_tamil;
        $customer_phone = $customerdata[ 0 ]->phone;
        $customer_address  = $customerdata[ 0 ]->permanent_address_1;

        $sql2 = "Select * from payments where id= $id order BY id DESC LIMIT 1";

        $customerpayments = DB::select( DB::raw( $sql2 ) );
        $customer_id = $customerpayments[ 0 ]->id;
        $customer_amount = $customerpayments[ 0 ]->amount;
        $customer_ad_amount = $customerpayments[ 0 ]->adsional_amount;
        $customer_reference_id = $customerpayments[ 0 ]->reference_id;
        $customer_service_id = $customerpayments[ 0 ]->service_id;

        $sql3 = "Select * from service where id= $customer_service_id order BY id DESC LIMIT 1";

        $customerpayments = DB::select( DB::raw( $sql3 ) );
        $service_name = $customerpayments[ 0 ]->service_name;

        $total = $customer_amount + $customer_ad_amount;
        $number = round( $total );
        $no = floor( $number );
        $point = round( $number - $no, 2 ) * 100;
        $hundred = null;
        $digits_1 = strlen( $no );
        $i = 0;
        $str = array();
        $words = array( '0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety' );
        $digits = array( '', 'hundred', 'thousand', 'lakh', 'crore' );
        while ( $i < $digits_1 ) {
            $divider = ( $i == 2 ) ? 10 : 100;
            $number = floor( $no % $divider );
            $no = floor( $no / $divider );
            $i += ( $divider == 10 ) ? 1 : 2;
            if ( $number ) {
                $plural = ( ( $counter = count( $str ) ) && $number > 9 ) ? 's' : null;
                $hundred = ( $counter == 1 && $str[ 0 ] ) ? ' and ' : null;
                $str [] = ( $number < 21 ) ? $words[ $number ] .
                ' ' . $digits[ $counter ] . $plural . ' ' . $hundred
                :
                $words[ floor( $number / 10 ) * 10 ]
                . ' ' . $words[ $number % 10 ] . ' '
                . $digits[ $counter ] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse( $str );
        $getamount = implode( '', $str );
        $points = ( $point ) ?
        '.' . $words[ $point / 10 ] . ' ' .
        $words[ $point = $point % 10 ] : '';
        $getamount . 'Rupees';

        return view( 'service/receipt', compact( 'customer_name', 'customer_phone', 'customer_address', 'user_name', 'user_address', 'user_phone', 'customer_id', 'customer_amount', 'customer_ad_amount', 'customer_reference_id', 'service_name', 'getamount' ) );
    }
}
