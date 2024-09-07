<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberDashboardController extends Controller
 {

    public function memberdashboard()
 {
        $today = date( 'Y-m-d' );
        $login_user = Session::get( 'customer_id' );
        $msgcount = 0;
        $sql = "select count(*) as msgcount from messages where recvId=$login_user and status=0";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $msgcount = $result[ 0 ]->msgcount;
        }
        $user_type_id = Session::get( 'user_type' );
        $dist_id = Session::get( 'dist_id' );

        $sql = "select * from user_type where id = $user_type_id";
        $result = DB::select( DB::raw( $sql ) );
        $user_type = $result[ 0 ]->user_type;
        $user_payment = 0;
        $renew_payment = 0;
        $sql = "select * from user_renewal where renewal_by = '$user_type' and user_type = '$user_type'";

        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $user_payment = $result[ 0 ]->reg_amount;
            $renew_payment = $result[ 0 ]->renew_amount;
        }
        $payment_amount = 0;
        $payment_message = '';
        $ad_info = '';
        $payment_pending = 0;
        $status = Session::get( 'status' );
        if ( $user_type_id > 18 && $user_type_id < 19 ) {
            if ( $status == 'Inactive' ) {
                $payment_amount = $user_payment;
                $payment_message = 'Please pay registration fee to avail offers and dicount';
                $payment_pending = 1;
                $ad_info = 'Registration';
            } else if ( Session::get( 'from_to_date' ) < $today ) {
                $payment_amount = $renew_payment;
                $payment_message = 'Your account has been expired';
                $payment_pending = 2;
                $ad_info = 'Renewal';
            }
        }

        $notification = 0;
        $addscount = 0;
        $pending = 0;
        $rejected = 0;
        $completed = 0;
        $sql = 'select count(*) as notification from  notification';
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $notification = $result[ 0 ]->notification;
        }

        $sql = ' select count(*) as addscount from  advertisement';
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $addscount = $result[ 0 ]->addscount;
        }

        if ( ( Session::get( 'user_type' ) == 18 ) || ( Session::get( 'user_type' ) == 19 ) || ( Session::get( 'user_type' ) == 20 ) || ( Session::get( 'user_type' ) == 21 ) ) {

            $log_id = Session::get( 'customer_id' );

            $sql = "select count(*) as pending from payments a,district b,customers c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Pending' and a.log_id = $log_id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $pending = $result[ 0 ]->pending;
            }

            $sql = "select count(*) as rejected from payments a,district b,customers c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Rejected' and a.log_id = $log_id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $rejected = $result[ 0 ]->rejected;
            }

            $sql = "select count(*) as completed from payments a,district b,customers c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Img' and a.log_id = $log_id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $completed = $result[ 0 ]->completed;
            }

            $sql = ' select count(*) as servicecount from  service';
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $servicecount = $result[ 0 ]->servicecount;
            }
        }

        $login = Session::get( 'customer_id' );
        $sql = "select count(id) as RequestAmount from request_payment where status='Pending' and (from_id=$login or to_id = $login )";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $RequestAmount = $result[ 0 ]->RequestAmount;
        }
        return view( 'member/memberdashboard', compact( 'notification', 'addscount', 'pending', 'rejected', 'completed', 'payment_amount', 'payment_message', 'payment_pending', 'ad_info', 'msgcount', 'RequestAmount', 'servicecount' ) );
    }

    public function bgdark( $customer_id ) {
        $id = Session::get( 'customer_id' );
        $sql = "update customers set colour=$customer_id where id = $id";
        DB::update( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

    public function removefavorites( $customer_id ) {
        $sql = "delete from favorites where customer_id=$customer_id";
        $result = DB::delete( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

}