<?php

namespace App\Http\Controllers;

use Auth;
use App\WalletHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
 {
    public function __construct()
 {
        $this->middleware( 'auth' );
    }

    public function setdistrict(){

        $sql = "select dist_id,id from users where id in (select log_id from payments) order by id desc";
        $result = DB::select( DB::raw( $sql ));
        foreach($result as $res){
            echo $res->dist_id.'<br>';
            echo $res->id;
            $sql="update payments set dist_id='$res->dist_id' where log_id='$res->id' and dist_id is NULL and service_status = 'Img' and online_status_id = 'Completed'";
            DB::update($sql);
        }

    }

    public function dashboard()
 {  
        if ( Auth::user()->pas == '12345678' ) {

            return redirect( '/changepassword' );
        }

        $today = date( 'Y-m-d' );
        $login_user = Auth::user()->id;
        $referral_id = Auth::user()->referral_id;
        $msgcount = 0;
        $sql = "select count(*) as msgcount from messages where recvId=$login_user and status=0";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $msgcount = $result[ 0 ]->msgcount;
        }
        $user_type_id = Auth::user()->user_type_id;
        $dist_id = Auth::user()->dist_id;
        
        if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3) {
            $sql = "Select * from `users` where `id` = 1";
        }else{
            $sql = "Select * from `users` where `id` = $referral_id";
        }  
        $superadminreferral = DB::select( DB::raw( $sql ) )[ 0 ];

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
        $status = Auth::user()->status;
        if ( $user_type_id > 3 && $user_type_id < 14 ) {
            if ( $status == 'Inactive' ) {
                $payment_amount = $user_payment;
                $payment_message = 'Please pay registration fee to avail offers and dicount';
                $payment_pending = 1;
                $ad_info = 'Registration';
            } else if ( Auth::user()->from_to_date < $today ) {
                $payment_amount = $renew_payment;
                $payment_message = 'Your account has been expired';
                $payment_pending = 2;
                $ad_info = 'Renewal';
            }
        }

        $sql1 = '';
        $sql2 = '';
        $sql3 = '';
        $sql4 = '';
        $sql5 = '';
        $sql6 = '';
        $sql7 = '';
        $sql8 = '';
        $sql9 = '';
        $sql10 = '';

        $PrimaryUsers = '';
        $SpecialUsers = '';
        $District = '';
        $Taluk = '';
        $Block = '';
        $Panchayath = '';
        $Center = '';
        $Customers = '';
        $Members = '';
        $SpecialMembers = '';
        $bulkbuy = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $PrimaryUsers = "('2', '3')";
            $SpecialUsers = "('16', '17')";
            $District = "('4', '5')";
            $Taluk = "('6', '7')";
            $Block = "('10', '11')";
            $Panchayath = "('8', '9')";
            $Center = "('12', '13')";
            $Customers = "('14', '15')";
            $Members = "('18', '19')";
            $SpecialMembers = "('20', '21')";
        } elseif ( ( Auth::user()->user_type_id == 2 ) || ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) || ( Auth::user()->user_type_id == 16 ) ) {
            $PrimaryUsers = "('2')";
            $SpecialUsers = "('16')";
            $District = "('4')";
            $Taluk = "('6')";
            $Block = "('10')";
            $Panchayath = "('8')";
            $Center = "('12')";
            $Customers = "('14')";
            $Members = "('18')";
            $SpecialMembers = "('20')";
        } elseif ( ( Auth::user()->user_type_id == 3 ) || ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) || ( Auth::user()->user_type_id == 17 ) ) {
            $PrimaryUsers = "('3')";
            $SpecialUsers = "('17')";
            $District = "('5')";
            $Taluk = "('7')";
            $Block = "('11')";
            $Panchayath = "('9')";
            $Center = "('13')";
            $Customers = "('15')";
            $Members = "('19')";
            $SpecialMembers = "('21')";
        }

        if ( Auth::user()->user_type_id == 1 ) {
            $sql1 = "select count(*) as PrimaryUsers from users where user_type_id in $PrimaryUsers";
            $sql2 = " select count(*) as SpecialUsers from users where user_type_id in $SpecialUsers";
            $sql3 = " select count(*) as District from users where user_type_id in $District";
            $sql4 = " select count(*) as Taluk from users where user_type_id in $Taluk";
            $sql5 = " select count(*) as Block from users where user_type_id in $Block";
            $sql6 = " select count(*) as Panchayath from users where user_type_id in $Panchayath";
            $sql7 = " select count(*) as Center from users where user_type_id in $Center";
            $result = DB::select( DB::raw( $sql1 ) );
            if ( count( $result ) > 0 ) {
                $PrimaryUsers = $result[ 0 ]->PrimaryUsers;
            }
            $result = DB::select( DB::raw( $sql2 ) );
            if ( count( $result ) > 0 ) {
                $SpecialUsers = $result[ 0 ]->SpecialUsers;
            }
            $result = DB::select( DB::raw( $sql3 ) );
            if ( count( $result ) > 0 ) {
                $District = $result[ 0 ]->District;
            }
            $result = DB::select( DB::raw( $sql4 ) );
            if ( count( $result ) > 0 ) {
                $Taluk = $result[ 0 ]->Taluk;
            }
            $result = DB::select( DB::raw( $sql5 ) );
            if ( count( $result ) > 0 ) {
                $Block = $result[ 0 ]->Block;
            }
            $result = DB::select( DB::raw( $sql6 ) );
            if ( count( $result ) > 0 ) {
                $Panchayath = $result[ 0 ]->Panchayath;
            }
            $result = DB::select( DB::raw( $sql7 ) );
            if ( count( $result ) > 0 ) {
                $Center = $result[ 0 ]->Center;
            }
        }

        if ( Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3 ) {
            $sql2 = " select count(*) as SpecialUsers from users where user_type_id = $SpecialUsers";
            $sql3 = " select count(*) as District from users where user_type_id = $District";
            $sql4 = " select count(*) as Taluk from users where user_type_id = $Taluk";
            $sql5 = " select count(*) as Block from users where user_type_id = $Block";
            $sql6 = " select count(*) as Panchayath from users where user_type_id = $Panchayath";
            $sql7 = " select count(*) as Center from users where user_type_id = $Center";

            $result = DB::select( DB::raw( $sql2 ) );
            if ( count( $result ) > 0 ) {
                $SpecialUsers = $result[ 0 ]->SpecialUsers;
            }
            $result = DB::select( DB::raw( $sql3 ) );
            if ( count( $result ) > 0 ) {
                $District = $result[ 0 ]->District;
            }
            $result = DB::select( DB::raw( $sql4 ) );
            if ( count( $result ) > 0 ) {
                $Taluk = $result[ 0 ]->Taluk;
            }
            $result = DB::select( DB::raw( $sql5 ) );
            if ( count( $result ) > 0 ) {
                $Block = $result[ 0 ]->Block;
            }
            $result = DB::select( DB::raw( $sql6 ) );
            if ( count( $result ) > 0 ) {
                $Panchayath = $result[ 0 ]->Panchayath;
            }
            $result = DB::select( DB::raw( $sql7 ) );
            if ( count( $result ) > 0 ) {
                $Center = $result[ 0 ]->Center;
            }
        }

        if ( Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 5 ) {
            $referral_id = Auth::user()->id;
            $sql4 = " select count(*) as Taluk from users where user_type_id = $Taluk and referral_id = $referral_id";
            $sql5 = " select count(*) as Block from users where user_type_id = $Block and referral_id = $referral_id";
            $sql6 = " select count(*) as Panchayath from users where user_type_id = $Panchayath and referral_id = $referral_id";
            $sql7 = " select count(*) as Center from users where user_type_id = $Center and referral_id = $referral_id";
            $result = DB::select( DB::raw( $sql4 ) );
            if ( count( $result ) > 0 ) {
                $Taluk = $result[ 0 ]->Taluk;
            }
            $result = DB::select( DB::raw( $sql5 ) );
            if ( count( $result ) > 0 ) {
                $Block = $result[ 0 ]->Block;
            }
            $result = DB::select( DB::raw( $sql6 ) );
            if ( count( $result ) > 0 ) {
                $Panchayath = $result[ 0 ]->Panchayath;
            }
            $result = DB::select( DB::raw( $sql7 ) );
            if ( count( $result ) > 0 ) {
                $Center = $result[ 0 ]->Center;
            }
        }

        if ( Auth::user()->user_type_id == 6 || Auth::user()->user_type_id == 7 || Auth::user()->user_type_id == 10 || Auth::user()->user_type_id == 11 ) {
            $sql6 = " select count(*) as Panchayath from users where user_type_id = $Panchayath and referral_id = $login_user";
            $sql7 = " select count(*) as Center from users where user_type_id = $Center and referral_id = $login_user";

            $result = DB::select( DB::raw( $sql6 ) );
            if ( count( $result ) > 0 ) {
                $Panchayath = $result[ 0 ]->Panchayath;
            }
            $result = DB::select( DB::raw( $sql7 ) );
            if ( count( $result ) > 0 ) {
                $Center = $result[ 0 ]->Center;
            }
        }

        if ( Auth::user()->user_type_id == 8 || Auth::user()->user_type_id == 9 ) {
            $sql6 = " select count(*) as Panchayath from users where user_type_id = $Panchayath and referral_id = $login_user";
            $sql7 = " select count(*) as Center from users where user_type_id = $Center and referral_id = $login_user";
            $result = DB::select( DB::raw( $sql6 ) );
            if ( count( $result ) > 0 ) {
                $Panchayath = $result[ 0 ]->Panchayath;
            }
            $result = DB::select( DB::raw( $sql7 ) );
            if ( count( $result ) > 0 ) {
                $Center = $result[ 0 ]->Center;
            }
        }
        $referral_id = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        if ( Auth::user()->user_type_id == 1 ) {
            $sql8 = " select count(*) as Customers from customers where user_type_id in $Customers";
            $sql9 = " select count(*) as Members from customers where user_type_id in $Members";
            $sql10 = " select count(*) as SpecialMembers from customers where user_type_id in $SpecialMembers";

        } elseif ( Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3 ) {

            $sql8 = " select count(*) as Customers from customers where user_type_id = $Customers";
            $sql9 = " select count(*) as Members from customers where user_type_id = $Members";
            $sql10 = " select count(*) as SpecialMembers from customers where user_type_id = $SpecialMembers";

        } elseif ( Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 5 ) {

            $sql8 = " select count(*) as Customers from customers where user_type_id = $Customers and referral_id = $referral_id";
            $sql9 = " select count(*) as Members from customers where user_type_id = $Members and referral_id = $referral_id";
            $sql10 = " select count(*) as SpecialMembers from customers where user_type_id = $SpecialMembers and referral_id = $referral_id";

        } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 11 ) ) {
            $sql8 = " select count(*) as Customers from customers where user_type_id = $Customers and dist_id = $dist_id  and referral_id = $referral_id";
            $sql9 = " select count(*) as Members from customers where user_type_id = $Members and dist_id = $dist_id and referral_id = $referral_id";
            $sql10 = " select count(*) as SpecialMembers from customers where user_type_id = $SpecialMembers and dist_id = $dist_id and referral_id = $referral_id";

        } elseif ( Auth::user()->user_type_id == 8 || Auth::user()->user_type_id == 9  || Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13 ) {

            $sql8 = " select count(*) as Customers from customers where user_type_id = $Customers and referral_id = $referral_id";
            $sql9 = " select count(*) as Members from customers where user_type_id = $Members and referral_id = $referral_id";
            $sql10 = " select count(*) as SpecialMembers from customers where user_type_id = $SpecialMembers and referral_id = $referral_id";
        }

        $result = DB::select( DB::raw( $sql8 ) );
        if ( count( $result ) > 0 ) {
            $Customers = $result[ 0 ]->Customers;
        }
        $result = DB::select( DB::raw( $sql9 ) );
        if ( count( $result ) > 0 ) {
            $Members = $result[ 0 ]->Members;
        }
        $result = DB::select( DB::raw( $sql10 ) );
        if ( count( $result ) > 0 ) {
            $SpecialMembers = $result[ 0 ]->SpecialMembers;
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

        if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 ) || ( Auth::user()->id == 21 ) || ( Auth::user()->id == 4916 ) || ( Auth::user()->id == 3185 ) || ( Auth::user()->id == 65 ) || ( Auth::user()->id == 38 ) || ( Auth::user()->id == 11719 ) || ( Auth::user()->id == 97 )) {
            
        $sql = "select count(*) as pending from payments a,district b,users c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Pending'";
        $result = DB::select(DB::raw($sql));
        if (count($result) > 0) {
            $pending = $result[0]->pending;
        }

        } else {
            $log_id = Auth::user()->id;
            $sql = "select count(*) as pending from payments a,district b,customers c where a.dist_id=b.id and a.customer_id=c.id and a.service_status = 'Pending' and a.log_id = $log_id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $pending = $result[ 0 ]->pending;
            }
        }

      if ( ( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 ) ) {
        $sql = "select count(*) as rejected from payments a,district b,users c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Rejected'";
        $result = DB::select(DB::raw($sql));
        if (count($result) > 0) {
            $rejected = $result[0]->rejected;
        }
        $sql = "select count(*) as completed from payments a,district b,users c where a.dist_id=b.id and a.log_id=c.id and a.service_status = 'Img'";
        $result = DB::select(DB::raw($sql));
        if (count($result) > 0) {
            $completed = $result[0]->completed;
        }
  } else {
         $log_id = Auth::user()->id;
		$sql = "select count(*) as rejected from payments a,district b,customers c where a.dist_id=b.id and a.customer_id=c.id and a.service_status = 'Rejected' and a.log_id = $log_id";
		$result = DB::select( DB::raw( $sql ) );
		if ( count( $result ) > 0 ) {
			$rejected = $result[ 0 ]->rejected;
		}
		$sql = "select count(*) as completed from payments a,district b,customers c where a.dist_id=b.id and a.customer_id=c.id and a.service_status = 'Img' and a.log_id = $log_id";
		$result = DB::select( DB::raw( $sql ) );
		if ( count( $result ) > 0 ) {
			$completed = $result[ 0 ]->completed;
		}
  }
		
        $login_id = Auth::user()->id;
        $sql = "select sum(quantity) as bulkbuy from bulk_service where login_id=$login_id";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $bulkbuy = $result[ 0 ]->bulkbuy;
        }

        $login = Auth::user()->id;
        $sql = "select count(id) as RequestAmount from request_payment where status='Pending' and (from_id=$login or to_id = $login )";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $RequestAmount = $result[ 0 ]->RequestAmount;
        }
        $sql = "select count(*) as avilableposting from users_posting where status = 'Active'";
        $result = DB::select( DB::raw( $sql ) );
        $avilableposting = $result[ 0 ]->avilableposting;

        $Registeruser = 0;
        if(Auth::user()->user_type_id == 1){
        $sql = "select count(*) as Registeruser from users where status='New'";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $Registeruser = $result[ 0 ]->Registeruser;
        }
        }elseif(Auth::user()->user_type_id == 2){
            $sql = "select count(*) as Registeruser from users where status='New' and user_type_id = 12";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $Registeruser = $result[ 0 ]->Registeruser;
            }

        }elseif(Auth::user()->user_type_id == 3){
            $sql = "select count(*) as Registeruser from users where status='New' and user_type_id = 13";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $Registeruser = $result[ 0 ]->Registeruser;
            }

        }elseif(Auth::user()->user_type_id >= 4 && Auth::user()->user_type_id <= 11){
            $sql = "select count(*) as Registeruser from users where status='New' and referral_id = $login";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $Registeruser = $result[ 0 ]->Registeruser;
            }
        }

         $tailoringpending = 0;
        if(Auth::user()->user_type_id == 1){
        $sql = "select count(*) as tailoringpending from tailoring where payment_status='Pending'";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringpending = $result[ 0 ]->tailoringpending;
        }
       }

       $tailoringcompleted = 0;
        if(Auth::user()->user_type_id == 1){
        $sql = "select count(*) as tailoringcompleted from tailoring where payment_status='Completed'";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringcompleted = $result[ 0 ]->tailoringcompleted;
        }
        }

        $meetingsstatus = "('1', '2')";
	    $meetings = 0;
	    $user_id = Auth::user()->id;
	    $sql = "select * from meetings where user_id='$user_id' and status='Active'";
        $result = DB::select( DB::raw( $sql ) );

        if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 3)){
        $sql = "select count(*) as meetings from meetings";
		} elseif((Auth::user()->user_type_id == 4) || (Auth::user()->user_type_id == 5)) {
        $sql = "select count(*) as meetings from meetings where status in $meetingsstatus";
		} else {
        $sql = "select count(*) as meetings from meetings where status ='2'";
		}
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $meetings = $result[ 0 ]->meetings;
        }

    $balance = 0;
     $balance =  WalletHelper::wallet_balance(Auth::user()->username);

 /*
        $usertype[1] ="Super Admin";
        $usertype[2] ="President";
        $usertype[3] ="Secretary";
        $usertype[4] ="District President";
        $usertype[5] ="District Secretary";
        $usertype[6] ="Taluk President";
        $usertype[7] ="Taluk Secretary";
        $usertype[8] ="Panchayath President";
        $usertype[9] ="Panchayath Secretary";
        $usertype[10]="Block President";
        $usertype[11]="Block Secretary";
        $usertype[12]="Center";
        $usertype[13]="Center";
        $month = date("Y-m");
        $userid = Auth::user()->id;
        $dist_id = Auth::user()->dist_id;
        $user_type_id = Auth::user()->user_type_id; 
        $top_user_dist_monthly = array();
        $top_user_dist_overall = array();
        $top_user_state_monthly = array();
        $top_user_state_overall = array();
        $total = 0;
        //top user district level monthly
        $sql = "select a.id,full_name,user_type_id,user_photo,dist_id,taluk_id,panchayath_id ,b.district_name from users a,district b where a.dist_id=b.id and a.user_type_id = $user_type_id";
        if($user_type_id != 4 and $user_type_id != 5){
            $sql = $sql." and dist_id = $dist_id";
        }
        $sql = $sql." order by id";
        $users = DB::select( DB::raw( $sql ) );
        $users = json_decode(json_encode($users), true);
        foreach ($users as $key => $user) {
            $users[$key]["own"] = 0;
            $users[$key]["team"] = 0;
            $users[$key]["total"] = 0;
            $referral_id = $user["id"];
            $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$referral_id and substr(paydate,1,7)='$month'";
            $result = DB::select( DB::raw( $sql ) );
            if(count($result) > 0){
                $users[$key]["own"] = $result[0]->done;
            }
            $sql = "with recursive cte (id, full_name, referral_id,user_type_id, ord) as 
            (
              select id, full_name, referral_id,user_type_id, 1 as ord
              from  users
              where id = $referral_id
              union all
              select c.id, c.full_name, c.referral_id,c.user_type_id, t.ord+1
              from users c join cte t
              on c.referral_id = t.id 
            )
            select * from cte order by ord;";
            $i = 0;
            $result = DB::select( DB::raw( $sql ) );
            foreach ($result as $key2 => $res) {
                $team_id = $res->id;
                $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$team_id and substr(paydate,1,7)='$month'";
                $result2 = DB::select( DB::raw( $sql ) );
                if(count($result2) > 0){
                    $users[$key]["team"] = $users[$key]["team"] + $result2[0]->done;
                }
            }
            $users[$key]["total"] = $users[$key]["own"] + $users[$key]["team"];
            if($users[$key]["total"] > $total) {
                $total = $users[$key]["total"];
                $top_user_dist_monthly = $users[$key];
            }
        }

        //top user district level overall
        $top_user_dist_overall = $top_user_dist_monthly;
        $top_user_dist_overall["own"] = 0;
        $top_user_dist_overall["team"] = 0;
        $top_user_dist_overall["total"] = 0;
        $referral_id = $top_user_dist_overall["id"];
        $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$referral_id";
        $result = DB::select( DB::raw( $sql ) );
        if(count($result) > 0){
            $top_user_dist_overall["own"] = $result[0]->done;
        }
        $sql = "with recursive cte (id, full_name, referral_id,user_type_id, ord) as 
        (
          select id, full_name, referral_id,user_type_id, 1 as ord
          from  users
          where id = $referral_id
          union all
          select c.id, c.full_name, c.referral_id,c.user_type_id, t.ord+1
          from users c join cte t
          on c.referral_id = t.id 
        )
        select * from cte order by ord;";
        $result = DB::select( DB::raw( $sql ) );
        foreach ($result as $key2 => $res) {
            $team_id = $res->id;
            $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$team_id";
            $result2 = DB::select( DB::raw( $sql ) );
            if(count($result2) > 0){
                $top_user_dist_overall["team"] = $top_user_dist_overall["team"] + $result2[0]->done;
            }
        }
        $top_user_dist_overall["total"] = $top_user_dist_overall["own"] + $top_user_dist_overall["team"];

        //top user state level monthly
        $sql = "select a.id,full_name,user_type_id,user_photo,dist_id,taluk_id,panchayath_id,b.district_name from users a,district b where a.dist_id=b.id and a.user_type_id = $user_type_id";
        $sql = $sql." order by id";
        $users = DB::select( DB::raw( $sql ) );
        $users = json_decode(json_encode($users), true);
        $total = 0;
        foreach ($users as $key => $user) {
            $users[$key]["own"] = 0;
            $users[$key]["team"] = 0;
            $users[$key]["total"] = 0;
            $referral_id = $user["id"];
            $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$referral_id and substr(paydate,1,7)='$month'";
            $result = DB::select( DB::raw( $sql ) );
            if(count($result) > 0){
                $users[$key]["own"] = $result[0]->done;
            }
            $sql = "with recursive cte (id, full_name, referral_id,user_type_id, ord) as 
            (
              select id, full_name, referral_id,user_type_id, 1 as ord
              from  users
              where id = $referral_id
              union all
              select c.id, c.full_name, c.referral_id,c.user_type_id, t.ord+1
              from users c join cte t
              on c.referral_id = t.id 
            )
            select * from cte order by ord;";
            $result = DB::select( DB::raw( $sql ) );
            foreach ($result as $key2 => $res) {
                $team_id = $res->id;
                $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$team_id and substr(paydate,1,7)='$month'";
                $result2 = DB::select( DB::raw( $sql ) );
                if(count($result2) > 0){
                    $users[$key]["team"] = $users[$key]["team"] + $result2[0]->done;
                }
            }
            $users[$key]["total"] = $users[$key]["own"] + $users[$key]["team"];
            if($users[$key]["total"] > $total) {
                $total = $users[$key]["total"];
                $top_user_state_monthly = $users[$key];
            }
        }
        //top user state leveloverall
        $top_user_state_overall = $top_user_state_monthly;
        $top_user_state_overall["own"] = 0;
        $top_user_state_overall["team"] = 0;
        $top_user_state_overall["total"] = 0;
        $referral_id = $top_user_state_overall["id"];
        $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$referral_id";
        $result = DB::select( DB::raw( $sql ) );
        if(count($result) > 0){
            $top_user_state_overall["own"] = $result[0]->done;
        }
        $sql = "with recursive cte (id, full_name, referral_id,user_type_id, ord) as 
        (
          select id, full_name, referral_id,user_type_id, 1 as ord
          from  users
          where id = $referral_id
          union all
          select c.id, c.full_name, c.referral_id,c.user_type_id, t.ord+1
          from users c join cte t
          on c.referral_id = t.id 
        )
        select * from cte order by ord;";
        $result = DB::select( DB::raw( $sql ) );
        foreach ($result as $key2 => $res) {
            $team_id = $res->id;
            $sql = "select count(log_id) as done from payments where service_status='Img' and log_id=$team_id";
            $result2 = DB::select( DB::raw( $sql ) );
            if(count($result2) > 0){
                $top_user_state_overall["team"] = $top_user_state_overall["team"] + $result2[0]->done;
            }
        }
        $top_user_state_overall["total"] = $top_user_state_overall["own"] + $top_user_state_overall["team"];
        
       echo "<pre>";
        print_r($top_user_dist_monthly);
        print_r($top_user_dist_overall);
        print_r($top_user_state_monthly);
        print_r($top_user_state_overall);
        echo "</pre>";
        ,'top_user_dist_monthly','top_user_dist_overall','top_user_state_monthly','top_user_state_overall','user_type_name'
        die;*/
        
        $log_id = Auth::user()->id;
        $sql=" select count(log_id) as Auth_user_overall from payments where service_status='Img' and log_id= $log_id";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $Auth_user_overall = $result[ 0 ]->Auth_user_overall;
        }
        
        $month = date("Y-m");
        $sql=" select count(log_id) as Auth_user_monthly from payments where service_status='Img' and log_id= $log_id and paydate = $month";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $Auth_user_monthly = $result[ 0 ]->Auth_user_monthly;
        }
            
           $in_condtion = " where 1=1 ";
        if(Auth::user()->user_type_id == 2){
            $in_condtion = " where user_type_id in (2,4,6,8,10,12)";
        }else if(Auth::user()->user_type_id == 4){
            $in_condtion = " where user_type_id in (4,6,8,10,12)";
        }else if(Auth::user()->user_type_id == 6){
            $in_condtion = " where user_type_id in (6,8,10,12)";
        }else if(Auth::user()->user_type_id == 8){
            $in_condtion = " where user_type_id in (8,10,12)";
        }else if(Auth::user()->user_type_id == 10){
            $in_condtion = " where user_type_id in (10,12)";
        }else if(Auth::user()->user_type_id == 12){
            $in_condtion = " where user_type_id in (12)";
        }else if(Auth::user()->user_type_id == 3){
            $in_condtion = " where user_type_id in (3,5,7,9,11,13)";
        }else if(Auth::user()->user_type_id == 5){
            $in_condtion = " where user_type_id in (5,7,9,11,13)";
        }else if(Auth::user()->user_type_id == 7){
            $in_condtion = " where user_type_id in (7,9,11,13)";
        }else if(Auth::user()->user_type_id == 9){
            $in_condtion = " where user_type_id in (9,11,13)";
        }else if(Auth::user()->user_type_id == 11){
            $in_condtion = " where user_type_id in (11,13)";
        }else if(Auth::user()->user_type_id == 13){
            $in_condtion = " where user_type_id in (13)";
        }
        $sql=" select count(log_id) as Auth_team_overall from payments where service_status='Img' and log_id in (select user_type_id from users $in_condtion )";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $Auth_team_overall = $result[ 0 ]->Auth_team_overall;
        }
        $usertype[1] ="Super Admin";
        $usertype[2] ="President";
        $usertype[3] ="Secretary";
        $usertype[4] ="District President";
        $usertype[5] ="District Secretary";
        $usertype[6] ="Taluk President";
        $usertype[7] ="Taluk Secretary";
        $usertype[8] ="Sup Block President";
        $usertype[9] ="Sup Block Secretary";
        $usertype[10]="Block President";
        $usertype[11]="Block Secretary";
        $usertype[12]="Center";
        $usertype[13]="Center";
        $user_type_name = $usertype[Auth::user()->user_type_id]; 
        $onlinestatus_menu = DB::table( 'payments' )->select( 'online_status_id')->whereNotNull('online_status_id')->distinct('online_status_id')->orderBy( 'online_status_id', 'Asc' )->get();
        return view( 'dashboard', compact( 'notification', 'addscount', 'PrimaryUsers', 'SpecialUsers', 'District', 'Taluk', 'Block', 'Panchayath', 'Center', 'Customers', 'Members', 'SpecialMembers', 'pending', 'rejected', 'completed', 'bulkbuy', 'payment_amount', 'payment_message', 'payment_pending', 'superadminreferral', 'ad_info', 'msgcount', 'RequestAmount', 'avilableposting','Auth_user_overall','Auth_user_monthly','Auth_team_overall','user_type_name','Registeruser','tailoringpending','tailoringcompleted','balance','meetings','onlinestatus_menu') );
    }

    public function bgdark( $user_id ) {
        $id = Auth::user()->id;
        $sql = "update users set colour=$user_id where id = $id";

        DB::update( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

    public function removefavorites( $user_id ) {
        $sql = "delete from favorites where user_id=$user_id";
        $result = DB::delete( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

    public function registerusers() {
        $user_id = Auth::user()->id;
        if(Auth::user()->user_type_id == 1){
        $registerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name')
        ->Join( 'district', 'district.id', '=', 'users.dist_id' )
        ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
        ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id')
        ->where('users.status','New')
        ->orderBy( 'users.id', 'Asc' )->get();
        }elseif(Auth::user()->user_type_id == 2){
            $registerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->where('user_type_id',12)
            ->where('users.status','New')
            ->orderBy( 'users.id', 'Asc' )->get();

        }elseif(Auth::user()->user_type_id == 3){  
            $registerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->where('user_type_id',13)
            ->where('users.status','New')
            ->orderBy( 'users.id', 'Asc' )->get();


        }elseif(Auth::user()->user_type_id >= 4 && Auth::user()->user_type_id <= 11){
            $registerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->Join( 'panchayath', 'panchayath.id', '=', 'users.panchayath_id' )
            ->where('referral_id',$user_id)
            ->where('users.status','New')
            ->orderBy( 'users.id', 'Asc' )->get();

        }
        return view('registerusers',compact('registerusers'));
    }

}