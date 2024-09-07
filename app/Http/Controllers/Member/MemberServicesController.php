<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Session;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberServicesController extends Controller
 {

    public function memberservices() {
        $customer_id = Session::get( 'customer_id' );
        $login_id = Session::get( 'customer_id' );
        $referral_id = Session::get( 'referral_id' );
        $user_type = Session::get( 'user_type' );
        $status = Session::get( 'status' );
        $today = date( 'Y-m-d' );
        $additional_amount = 0;
        $sql = "select * from customers where id = $customer_id";
        $result = DB::select( DB::raw( $sql ) );
        $result = $result[ 0 ];
        $cust_dist_id  = $result->dist_id;
        $cust_taluk_id = $result->taluk_id;
        $cust_panchayath_id = $result->panchayath_id;
        $user_dist_id  = Session::get( 'user_dist_id' );
        $user_taluk_id  = Session::get( 'user_taluk_id' );
        $user_panchayath_id  = Session::get( 'user_panchayath_id' );
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
        $sql = "select id,full_name,phone,upi,payment_qr_oode from users where id=$referral_id";
        $referral = DB::select( DB::raw( $sql ) );
        $referral = $referral[ 0 ];
        $services = DB::table( 'service' )->orderBy( 'id', 'Asc' )->get();
        $services = json_decode( json_encode( $services ), true );
        foreach ( $services as $key1 => $service ) {
            $service_id = $service[ 'id' ];
            $payment = $service[ 'service_payment' ];
            $pay_amount = $payment - ( $payment/100 ) * $discount;
            $pay_amount = ceil ( $pay_amount / 5 ) *5;
            $pay_amount = $pay_amount + $additional_amount;
            $services[ $key1 ][ 'pay_amount' ] = $pay_amount;
            $sql = "Select * from payments where log_id = $login_id  and service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
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
                            if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                            }else{
                                $action = 'Pay Now';
                            }
                        }
                    } else {
                        if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                        }else{
                            $action = 'Pay Now';
                        }
                    }
                } else if ( $service_status == 'Rejected' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $action = 'Reject Form';
                        } else {
                            if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                            }else{
                                $action = 'Pay Now';
                            }
                        }
                    } else {
                        if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                        }else{
                            $action = 'Pay Now';
                        }
                    }
                } else if ( $service_status == 'Img' ) {
                    $sql = "Select * from payments where service_id = '$service_id' and customer_id='$customer_id' order by id desc limit 1 ";
                    $result = DB::select( DB::raw( $sql ) );
                    if ( count( $result ) > 0 ) {
                        if ( $result[ 0 ]->service_id == $service_id ) {
                            $output_image = $result[ 0 ]->from_image;
                            $action = 'Output';
                        } else {
                            if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                            }else{
                                $action = 'Pay Now';
                            }
                        }
                    } else {
                        if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                                $action = 'Create Form';
                        }else{
                            $action = 'Pay Now';
                        }
                    }

                }
            } else {
                if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active"){
                    $action = 'Create Form';
                }else{
                    $action = 'Pay Now';
                }
            }
            $services[ $key1 ][ 'service_status' ] = $service_status;
            $services[ $key1 ][ 'action' ] = $action;
            $services[ $key1 ][ 'output_image' ] = $output_image;
        }
        $services = json_decode( json_encode( $services ) );
        $sql = "select id as customer_id,user_type_id as customer_user_type_id,dist_id,taluk_id,panchayath_id from customers where id=$customer_id";
        $customer = DB::select( DB::raw( $sql ) );
        $customer = $customer[ 0 ];
        return view( 'member/memberservice/memberservices', compact( 'services', 'usertype', 'customer', 'referral' ) );
    }

    public function addservice( Request $request ) {
        $adduser = DB::table( 'service' )->insert( [
            'service_name' => $request->service_name,
            'service_payment' => $request->service_payment,
            'status' => 'Active',
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
        return redirect()->back()->with( 'success', 'Service Added Successfully ... !' );
    }

    public function editservice( Request $request ) {
        $adduser = DB::table( 'service' )->where( 'id', $request->service_id )->update( [
            'service_name' => $request->service_name,
            'service_payment' => $request->service_payment,
            'status' => $request->status
        ] );

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

    public function memservicepayment( Request $request ) {
        $service_id = $request->service_id;
        $customer_id = $request->customer_id;
        $customer_user_type_id = $request->customer_user_type_id;
        $dist_id = $request->dist_id;
        $taluk_id = $request->taluk_id;
        $panchayath_id = $request->panchayath_id;
        $amount = $request->pay_amount;
        $log_id = Session::get( 'customer_id' );
        $referral_id = Session::get( 'referral_id' );
        $paydate = date( 'Y-m-d' );
        $service_status = 'Paid';
        $time = date( 'H:i:s' );
        $sql = "insert into payments (amount,customer_id,service_id,service_status,log_id,paydate,time) values ('$amount','$customer_id','$service_id','$service_status','$log_id','$paydate','$time')";
        DB::insert( DB::raw( $sql ) );
        $pay_id = DB::getPdo()->lastInsertId();
        $sql = "update customers set wallet = wallet - $amount where id = $log_id";
        DB::update( DB::raw( $sql ) );
        $sql = "with recursive cte (id,full_name, user_type, referral_id) as (
        select     id,
        full_name,
        user_type,
        referral_id
        from       customers
        where      id = $referral_id
        union all
        select     p.id,
        p.full_name,
        p.user_type,
        p.referral_id
        from       customers p
        inner join cte
        on p.id = cte.referral_id
        )
        select * from cte;";

        $result = DB::select( DB::raw( $sql ) );
        $time = date( 'H:i:s' );
        $count = count( $result );
        if ( $count > 0 ) $amount = $amount/$count;
        foreach ( $result as $row ) {

            $to_id = $row->id;
            $ad_info = 'Income';
            $ad_info2 = 'ServicePayment';
            $service_status = 'Out Payment';
            $sql = "insert into payment (log_id,from_id,to_id,customer_id,service_id,pay_id,amount,ad_info,service_status,time,paydate,ad_info2) values ('$log_id','$log_id','$to_id', '$customer_id','$service_id','$pay_id','$amount','$ad_info', '$service_status','$time','$paydate','$ad_info2')";
            DB::insert( DB::raw( $sql ) );
            $sql = "update customers set wallet = wallet + $amount where id = $to_id";
            DB::update( DB::raw( $sql ) );
            $ad_info = 'Application';
            $service_status = 'IN Payment';
            $sql = "insert into payment (log_id,from_id,to_id,customer_id,service_id,pay_id,amount,ad_info,service_status,time,paydate) values ('$log_id','$to_id','$log_id', '$customer_id','$service_id','$pay_id','$amount','$ad_info', '$service_status','$time','$paydate')";
            DB::insert( DB::raw( $sql ) );
        }
        return redirect( 'member/memberservice/memberservices' );
    }

    public function memcreateapplication( Request $request ) {
        define ( 'SITE_ROOT', realpath( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
        $service_id = $request->imservice_id;
        $customer_id = $request->imcustomer_id;
        $customer_user_type_id = $request->imcustomer_user_type_id;
        $user_type_id  = 0;
        if ( ( Session::get( 'user_type' ) == 18 ) || ( Session::get( 'user_type' ) == 20 ) ) {
            $user_type_id = '4';
        } elseif ( ( Session::get( 'user_type' ) == 19 ) || ( Session::get( 'user_type' ) == 21 ) ) {
            $user_type_id = '5';
        }
        $user_id = Session::get( 'customer_id' );
        $dist_id = Session::get( 'user_dist_id' );
        $sql = "select * from service where id = $service_id";

        $result = DB::select( DB::raw( $sql ) );
        $marge_right = $result[ 0 ]->marge_right;

        $marge_bottom = $result[ 0 ]->marge_bottom;

        $targetDir = 'upload/output/';
        $sql = "select signature2 from users where dist_id = $dist_id and user_type_id = $user_type_id";
        $result = DB::select( DB::raw( $sql ) );
        $watermarkImagePath = 'upload/off/'.$result[ 0 ]->signature2;
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
                        $result = DB::select( DB::raw( $sql ) );
                        $time = date( 'H:i:s' );
                        if(count($result) > 0){
                            $payments_id = $result[ 0 ]->id;
                            $sql = "update payments set from_image='$fileName',service_id='$service_id',customer_id='$customer_id',customer_user_type_id='$customer_user_type_id',log_id='$user_id',service_status='Pending',dist_id='$dist_id',time='$time' where id=$payments_id";
                            DB::update( DB::raw( $sql ) );
                        }else{
                            $paydate = date( 'Y-m-d' );
                            $sql = "insert into payments (amount,customer_id,service_id,service_status,log_id,paydate,time,dist_id) values ('0','$customer_id','$service_id','Pending','$user_id','$paydate','$time','$dist_id')";
                            DB::insert( DB::raw( $sql ) );
                        }

                        if ( ( Session::get( 'user_type' ) == 18 ) || ( Session::get( 'user_type' ) == 20 ) ) {

                            $District = '4';
                            $Special = '16';

                        }
                        if ( ( Session::get( 'user_type' ) == 19 ) || ( Session::get( 'user_type' ) == 21 ) ) {

                            $District = '5';
                            $Special = '17';
                        }
                        $distID = Session::get( 'user_dist_id' );

                        $registrationIds = array();
                        $sql = "Select device_id from users where user_type_id ='$District' and dist_id='$distID'";
                        $result = DB::select( DB::raw( $sql ) );
                        foreach ( $result as $res ) {
                            $registrationIds[] = $res->device_id;
                        }


                        $url = 'https://fcm.googleapis.com/fcm/send';
                        //'to' for single user
                        //'registration_ids' for multiple customers
                        $weburl =  '';
                        //base_url( 'payments/pending' );
                        $message = 'Service: 1, Service Status: Pending';

                        $title = 'Nalavariyam';
                        $body = $message;
                        $icon = 'Nalavariyam';
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
                                'sessionorization: key=AAAABIWWI_c:APA91bGf79FDnwnPw1FgpFkVlryHBvf3F1hhi0uwfRPuZRV7jEKu4Hggezwbl61FBxpkeauYs13Gbmsu5xzZxQcGVKRs7k8LJOUZoUI7fw2QkZGBrzNW_r7192r6DrzV2X269LEzz27M',
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
        return redirect( 'memberservices' );

    }

    public function memberpending()
 {
        $log_id = Session::get( 'customer_id' );
        $user_type = Session::get( 'user_type' );
        $dist_id = Session::get( 'dist_id' );
        $service_Rejected = '';
        $service_Img = '';
        $service_Pending = 'Pending';

        if ( $user_type == 18 || $user_type == 19 ) {

            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Pending, )->orderBy( 'payments.id', 'Asc' )->get();

        } elseif ( $user_type == 20 || $user_type == 21 ) {

            $dist_id = Session::get( 'dist_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Pending, )->where( 'payments.dist_id', $dist_id )->orderBy( 'payments.id', 'Asc' )->get();

        } else {

            $log_id = Session::get( 'customer_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Pending, )->where( 'payments.log_id', $log_id )->orderBy( 'payments.id', 'Asc' )->get();
            //echo $servicestatus;
            die;
        }
        return view( 'member/memberservice/memberstatus', compact( 'servicestatus', 'service_Pending' ,'user_type' ) );
    }

    public function memberstatuscompleted( $from, $to )
 {
        $log_id = Session::get( 'customer_id' );
        $user_type = Session::get( 'user_type' );
        $dist_id = Session::get( 'dist_id' );
        $service_Rejected = '';
        $service_Img = 'Img';
        $service_Pending = '';
        if ( $user_type == 18 || $user_type == 19 ) {
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

        } elseif ( $user_type == 20 || $user_type == 21 ) {

            $dist_id = Session::get( 'dist_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )->where( 'payments.dist_id', $dist_id )->where( 'paydate', '>=', $from )->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();

        } else {

            $log_id = Session::get( 'customer_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'service.service_payment', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Img )->where( 'payments.log_id', $log_id )->where( 'paydate', '>=', $from )
            ->where( 'paydate', '<=', $to )->orderBy( 'payments.id', 'Asc' )->get();
            //echo $servicestatus;
            die;
        }
        return view( 'member/memberservice/memberstatuscompleted', compact( 'servicestatus', 'service_Rejected', 'service_Img', 'service_Pending', 'from', 'to' ) );
    }

    public function memberrejected()
 {
        $log_id = Session::get( 'customer_id' );
        $user_type = Session::get( 'user_type' );
        $dist_id = Session::get( 'dist_id' );
        $service_Rejected = 'Rejected';
        $service_Img = '';
        $service_Pending = '';

        if ( $user_type == 18 || $user_type == 19 ) {
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Rejected )->orderBy( 'payments.id', 'Asc' )->get();

        } elseif ( $user_type == 20 || $user_type == 21 ) {

            $dist_id = Session::get( 'dist_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Rejected )->where( 'payments.dist_id', $dist_id )->orderBy( 'payments.id', 'Asc' )->get();

        } else {

            $log_id = Session::get( 'customer_id' );
            $servicestatus = DB::table( 'payments' )->select( 'payments.*', 'district.*', 'customers.phone', 'service.service_name', 'payments.id as userID' )
            ->Join( 'district', 'district.id', '=', 'payments.dist_id' )
            ->Join( 'customers', 'customers.id', '=', 'payments.log_id' )
            ->Join( 'service', 'service.id', '=', 'payments.service_id' )
            ->where( 'payments.service_status', $service_Rejected )->where( 'payments.log_id', $log_id )->orderBy( 'payments.id', 'Asc' )->get();

        }
        return view( 'member/memberservice/memberstatus', compact( 'servicestatus', 'service_Rejected', 'service_Img', 'service_Pending' ) );
    }

    public function memberserviceupdatestatus( Request $request ) {
        $from = date( 'Y-m-d', strtotime( '-6 days' ) );
        $to =  date( 'Y-m-d' );
        $service_status = $request->service_status;

        $updatestatus = DB::table( 'payments' )->where( 'id', $request->service_id )->update( [
            'service_status' => $service_status,
            'reason' => $request->reason,
        ] );
        if ( $service_status == 'Img' ) {
            return redirect( 'pending' );
        } elseif ( $service_status == 'Rejected' ) {
            return redirect( 'pending' );
        } elseif ( $service_status == 'Pending' ) {
            return redirect( 'pending' );
        }
    }

    public function membercompletedbill( Request $request ) {
        $from = date( 'Y-m-d', strtotime( '-6 days' ) );
        $to =  date( 'Y-m-d' );
        $membercompletedbill = DB::table( 'payments' )->where( 'id', $request->payment_id )->update( [
            'adsional_amount' => $request->adsional_amount,
            'reference_id'    => $request->reference_id,
            'bill'            => 2,
        ] );

        return redirect( "memberstatuscompleted/$from/$to" );
    }

    public function receipt( $cust_id, $id ) {
        $loginid = session::get()->id;
        $sql = "Select * from customers where id = $loginid order by id desc limit 1";
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

    public function memberprofile()
 {
        $userid = Session::get( 'customer_id' );

        $member = DB::table( 'customers' )->where( 'id', '=', $userid )->get();
        $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
        return view( 'member/profile/memberprofile', compact( 'member', 'managedistrict' ) );
    }

    public function updatememberprofile( Request $request ) {
        $userid = Session::get( 'customer_id' );

        $updatememberprofile = DB::table( 'customers' )->where( 'id', $userid )->update( [
            'full_name'  => $request->full_name,
            'aadhaar_no' => $request->aadhaar_no,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'gender'     => $request->gender,
            'permanent_address_1' => $request->permanent_address_1,
            'upi'        => $request->upi,
        ] );

        $profile = '';
        if ( $request->member_photo != null ) {
            $profile = $userid.'.'.$request->file( 'member_photo' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'member_photo'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'member_photo' ][ 'tmp_name' ], $filepath.$profile );
            $sql = "update customers set member_photo='$profile' where id = $userid";
            DB::update( DB::raw( $sql ) );
        }

        $signature = '';
        if ( $request->member_signature != null ) {
            $signature = $userid.'.'.$request->file( 'member_signature' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'member_signature'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'member_signature' ][ 'tmp_name' ], $filepath.$signature );
            $sql = "update customers set member_signature='$signature' where id = $userid";
            DB::update( DB::raw( $sql ) );
        }
        return redirect( 'memberdashboard' )->with( 'success', 'Update Member Successfully ... !' );
    }

    public function memberchangepassword()
 {
        $userid = Session::get("customer_id");

        return view( 'member/profile/memberchangepassword' );
    }

    public function memberupdatepassword( Request $request ) {
        $userid = Session::get("customer_id");
        $old_password = trim( $request->get( 'oldpassword' ) );
        $currentPassword = Session::get('password');
        if ( Hash::check( $old_password, $currentPassword ) ) {
            $new_password = trim( $request->get( 'new_password' ) );
            $confirm_password = trim( $request->get( 'confirm_password' ) );
            if ( $new_password != $confirm_password ) {
                return redirect( 'memberchangepassword' )->with( 'error', 'Passwords does not match' );
            } elseif ( $new_password == '12345678' ) {
                return redirect( 'memberchangepassword' )->with( 'error', 'You cannot use the passord 12345678' );
            } else {
                $updatepass = DB::table( 'customers' )->where( 'id', '=', $userid )->update( [
                    'password' => Hash::make( $new_password ),
                    'pas'      => $request->new_password,
                ] );
                return redirect( 'memberdashboard' )->with( 'success', 'Passwords Change Succesfully' );
            }
        } else {
            return redirect( 'memberchangepassword' )->with( 'error', 'Sorry, your current password was not recognised' );
        }
    }
    
    public function membernotification()
    {

      if((Session::get("user_type") == '18') || Session::get("user_type") == '19' || Session::get("user_type") == '20' || Session::get("user_type") == '21'){ 
   
      } else {
       return redirect( 'memberdashboard' );
       }

        $notification = DB::table('notification')->orderBy('id', 'Asc')->get();
        return view('notification/index', compact('notification'));
    }

    public function memberlogout(){
        Session::flush();
        return redirect()->intended('/');
    }
}