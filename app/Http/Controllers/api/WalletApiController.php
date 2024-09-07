<?php
namespace App\Http\Controllers\api;
use App\WalletHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;

class WalletApiController extends Controller {

    public function recharge_investment_interest($apiKey,$username,$amount) {
        $API_KEY = env( 'API_KEY', '' );
        $response = array();
        $message = '';
        $to_id=0;
        $from_id=1;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Ramjipay Investment Interest';
        $sql = "SELECT * FROM wallet_users where username='$username'";
        $result = DB::select( $sql );
        if ( count( $result ) > 0 ) {
            $to_id = $result[ 0 ]->id;
        }
        if ( $API_KEY == $apiKey ) {
            $from_id=1;
            $service_status = 'Out Payment';
            WalletHelper::debitWallet2('RJ01N001', $amount );
            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$from_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','Investment')";
            DB::insert( DB::raw( $sql ) );
            $service_status = 'In Payment';
            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$to_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','Investment')";
            DB::insert( DB::raw( $sql ) );
            $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
            DB::update( DB::raw( $sql ) );
            $message = 'success';
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        echo json_encode( $response );
    }

    public function recharge_investment_history($apiKey,$username,$amount) {
        $API_KEY = env( 'API_KEY', '' );
        $response = array();
        $message = '';
        $to_id=0;
        $from_id=1;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info = 'Ramjipay Investment';
        
        $sql = "SELECT * FROM wallet_users where username='$username'";
        $result = DB::select( $sql );
        if ( count( $result ) > 0 ) {
            $to_id = $result[ 0 ]->id;
        }
        if ( $API_KEY == $apiKey ) {
            $from_id=1;
            $service_status = 'Out Payment';
            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$from_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','Investment')";
            DB::insert( DB::raw( $sql ) );
            $service_status = 'In Payment';
            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$to_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','Investment')";
            DB::insert( DB::raw( $sql ) );
            $message = 'success';
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        echo json_encode( $response );
    }

    public function get_applicationmobile($key){
        $message = 'success';
        $response = array();
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $today = date("Y-m-d");
            $sql="select id,app_no,mobile_no from payments where app_no is not NULL and online_status_id != 'Approved' and (online_status_date <> '$today' or online_status_date is NULL)";
            //$sql="select id,app_no,mobile_no from payments where app_no is not NULL order by id asc limit 5";
            $i=0;
            $result=DB::select($sql);
            foreach($result as $res){
                $response[$i]["id"]=$res->id;
                $response[$i]["app_no"]=$res->app_no;
                $response[$i]["mobile_no"]=$res->mobile_no;
                $i++;
            }
            echo json_encode($response);
        } else {
            $message = 'Access Denied';
            $response[ 'message' ] = $message;
            return response()->json( $response );
        }
    }

    public function updategovtstatus($key,$app_no,$status,$reason){
        $message = 'success';
        $today = date("Y-m-d");
        $response = array();
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $sql="update payments set online_status_id='$status',reason = '$reason',online_status_date = '$today' where app_no='$app_no'";
            DB::update($sql);
            $response[ 'message' ] = $message;
            $response[ 'status' ] = $status;
            $response[ 'online_status_date' ] = $today;
            $response[ 'app_no' ] = $app_no;
            $response[ 'reason' ] = $reason;
            return response()->json( $response );
        } else {
            $message = 'Access Denied';
            $response[ 'message' ] = $message;
            return response()->json( $response );
        }
    }

    public function update_old_balance(){
        $sql="select id,username,wallet from wallet_users limit 200";
        $result = DB::select($sql);
        foreach($result as $res){
            $id=$res->id;
            $wallet=$res->wallet;
            echo $id.":".$wallet."<br>";
            $paydate = date('Y-m-d');
            $time = date("H:i:s");
            $ad_info = "Opening Balance";
            $service_status = "In Payment";
            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,old_balance) values ('1','1','$id','0','$ad_info', '$service_status','$time','$paydate',$wallet)";
            echo $sql."<br>";
            DB::insert(DB::raw($sql));
        }
    }

    public function checkemailverified( $username, $key ) {
        $message = 'success';
        $verified = 0;
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $sql = "select isverified from wallet_users where username='$username' and isverified=1";
            $result = DB::select( $sql );
            if ( count( $result )>0 ) {
                $verified = 1;
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        $response[ 'verified' ] = $verified;
        return response()->json( $response );
    }

    public function update_email_aadhaar_phone( $username, $email, $aadhaar_no, $phone, $key ) {
        $message = 'success';
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $sql = "update wallet_users set email='$email',aadhaar_no='$aadhaar_no',phone='$phone' where username='$username'";
            DB::update( $sql );
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function get_email_aadhaar_phone($key,$username) {
        $message = 'success';
        $aadhaar_no = "";
        $email = "";
        $phone = "";
        $isverified=0;
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $sql = "select * from wallet_users where username='$username'";
            $result = DB::select($sql);
            if(count($result)>0){
                $aadhaar_no = $result[0]->aadhaar_no;
                $email = $result[0]->email;
                $phone = $result[0]->phone;
                $isverified = $result[0]->isverified;
            }
        } else {
            $message = 'Access Denied';
        }
        $response['message'] = $message;
        $response['aadhaar_no'] = $aadhaar_no;
        $response['email'] = $email;
        $response['phone'] = $phone;
        $response['isverified'] = $isverified;
        return response()->json( $response );
    }

    public function verifyemail( $username, $key ) {
        $message = 'success';
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $sql = "update wallet_users set isverified=1 where username='$username'";
            DB::update( $sql );
            $sql = "update users set emailverified=1 where username='$username'";
            DB::update( $sql );
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function checkusers( $email, $key ) {
        $message = '';
        $checkflag = '';
        $response = array();
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {

            $sql = "select * from wallet_users where email = '$email'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $username = $result[ 0 ]->username;
                $checkflag = 'true';
            } else {
                $maxid = 0;
                $response = array();
                $sql = 'select max(id) as maxid from wallet_users';
                $result = DB::select( $sql );
                if ( count( $result ) > 0 ) {
                    $maxid = $result[ 0 ]->maxid;
                }
                $maxid = $maxid+1;
                $maxid = str_pad( $maxid, 5, '0', STR_PAD_LEFT );
                $uniqueId = rand( 111111111, 999999999 );
                $username = 'RJN' . $maxid . $uniqueId;
                $sql = "insert into wallet_users (username,email) values ('$username','$email')";
                DB::insert( $sql );
                $checkflag = 'false';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = 'success';
        $response[ 'username' ] = $username;
        $response[ 'checkflag' ] = $checkflag;
        return response()->json( $response );
    }

    public function generate_username( $key ) {
        $message = '';
        $API_KEY = env( 'API_KEY', '' );
        if ( $key == $API_KEY ) {
            $maxid = 0;
            $response = array();
            $sql = 'select max(id) as maxid from wallet_users';
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $maxid = $result[ 0 ]->maxid;
            }
            $maxid = $maxid+1;
            $maxid = str_pad( $maxid, 5, '0', STR_PAD_LEFT );
            $uniqueId = rand( 111111111, 999999999 );
            $username = 'RJN' . $maxid . $uniqueId;
            $sql = "insert into wallet_users (username) values ('$username')";
            DB::insert( $sql );
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = 'success';
        $response[ 'username' ] = $username;
        return response()->json( $response );
    }

    public function wallet_balance( $username, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $balance  = 0;
        $message = '';
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'balance' ] = $balance;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function wallet_commission( $username, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $balance  = 0;
        $message = '';
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->commission;
                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'balance' ] = $balance;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function balance( $username, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $balance  = 0;
        $message = '';
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'balance' ] = $balance;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function ramjipay_lic_payment( $username, $admin_user_name, $center_user_name, $superadmin_amount, $admin_amount, $superadmin_commission, $admin_commission, $center_commission, $key ) {
        $total_amount = $superadmin_amount+$admin_amount+$superadmin_commission+$admin_commission+$center_commission;
        $API_KEY = env( 'API_KEY', '' );
        $customer_id = 0;
        $superadmin_id = 1;
        $admin_id = 0;
        $center_id = 0;
        $message = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $customer_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM wallet_users where username='$admin_user_name'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM wallet_users where username='$center_user_name'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $center_id = $result[ 0 ]->id;
            }
            if ( $customer_id != 0 ) {
                if ( $balance >= $total_amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'LIC Payment';
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $total_amount );
                    if ( $superadmin_amount != 0 ) {
                        $service_status = 'Out Payment';
                        $ad_info="LIC Premium payment";
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$superadmin_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$superadmin_id','$customer_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $sql = "update wallet_users set wallet = wallet + $superadmin_amount,commission = commission + $superadmin_amount where id = $superadmin_id";
                        DB::update( DB::raw( $sql ) );
                    }
                    if ( $admin_amount != 0 ) {
                        $service_status = 'Out Payment';
                        $ad_info="LIC Premium payment";
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$admin_id','$customer_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where id = $admin_id";
                        DB::update( DB::raw( $sql ) );
                    }
                    if ( $superadmin_commission != 0 ) {
                        $service_status = 'Out Payment';
                        $ad_info="LIC Commission";
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$superadmin_id','$superadmin_commission','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$superadmin_id','$customer_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $sql = "update wallet_users set wallet = wallet + $superadmin_amount,commission = commission + $superadmin_amount where id = $superadmin_id";
                        DB::update( DB::raw( $sql ) );
                    }
                    if ( $admin_commission != 0 ) {
                        $service_status = 'Out Payment';
                        $ad_info="LIC Commission";
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$admin_id','$admin_commission','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$admin_id','$customer_id','$admin_commission','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $sql = "update wallet_users set wallet = wallet + $admin_commission,commission = commission + $admin_commission where id = $admin_id";
                        DB::update( DB::raw( $sql ) );
                    }
                    if ( $center_commission != 0 ) {
                        $service_status = 'Out Payment';
                        $ad_info="LIC Commission";
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$center_id','$center_commission','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$center_id','$customer_id','$center_commission','$ad_info', '$service_status','$time','$paydate','LIC')";
                        DB::insert( DB::raw( $sql ) );
                        $sql = "update wallet_users set wallet = wallet + $center_commission,commission = commission + $center_commission where id = $center_id";
                        DB::update( DB::raw( $sql ) );
                    }
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function recharge_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'Recharge Payment';
                    $service_status = 'Out Payment';
                    //WalletHelper::debitWallet2( $username, $amount );
                    $sql = "update wallet_users set wallet = wallet - $amount,commission = commission - $amount where username = '$username'";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'recharge')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function eservice_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->commission;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'E-Service Payment';
                    $service_status = 'Out Payment';
                    //WalletHelper::debitWallet2( $username, $amount );
                    $sql = "update wallet_users set wallet = wallet - $amount,commission = commission - $amount where username = '$username'";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'recharge')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function eservice_credit_commission($admin_username,$referral_username,$admin_amount,$referral_amount,$key ) {
        $API_KEY = env( 'API_KEY', '' );
        $admin_username = trim( $admin_username );
        $referral_username = trim( $referral_username );
        $to_id = 1;
        $admin_id = 0;
        $referral_user_id = 0;
        $message = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT id FROM wallet_users where username='$admin_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            $sql = "SELECT id FROM wallet_users where username='$referral_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $referral_user_id = $result[ 0 ]->id;
            }
            if ( $admin_id != 0 || $referral_user_id !=0) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'E-services Payment';
                $service_status = 'Out Payment';
                WalletHelper::debitWallet2( 'RJ01N001', $admin_amount );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$to_id','$to_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );
                $service_status = 'In Payment';
                $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where username = '$admin_username'";
                DB::update( DB::raw( $sql ) );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$admin_id','$admin_id','$to_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );

                $ad_info = 'E-services Commission from referred User';
                $service_status = 'Out Payment';
                WalletHelper::debitWallet2( 'RJ01N001', $referral_amount );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$to_id','$to_id','$referral_user_id','$referral_amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );
                $service_status = 'In Payment';
                $sql = "update wallet_users set wallet = wallet + $referral_amount,commission = commission + $referral_amount where username = '$referral_username'";
                DB::update( DB::raw( $sql ) );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$referral_user_id','$referral_user_id','$to_id','$referral_amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );

                $message = 'success';

            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function recharge_refund_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'Recharge Refund';
                $service_status = 'Out Payment';
                WalletHelper::debitWallet2( 'RJ01N001', $amount );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );
                $service_status = 'In Payment';
                $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$username'";
                DB::update( DB::raw( $sql ) );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate','recharge')";
                DB::insert( DB::raw( $sql ) );
                $message = 'success';

            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function recharge_commission( Request $request ) {
        $API_KEY = env( 'API_KEY', '' );
        $apiKey = $request->get( 'key' );
        $user = $request->get( 'user' );
        //$amount = $request->get( 'amount' );
        $commission = $request->get( 'commission' );
        $response = array();
        $message = '';
        $ref_id = 0;
        $rechargeuser_id = 0;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $ad_info1 = 'Recharge Commission';
        $ad_info = 'Recharge Payment';
        $service_status = 'Out Payment';
        $service_status1 = 'In Payment';
        $sql = "SELECT * FROM wallet_users where username='$user'";
        $result = DB::select( $sql );
        if ( count( $result ) > 0 ) {
            $rechargeuser_id = $result[ 0 ]->id;
        }
        if ( $API_KEY == $apiKey ) {
            foreach ( $commission as $com ) {
                $username = $com[ 'username' ];
                $amount = round( $com[ 'amount' ], 2 );
                $sql = "SELECT * FROM wallet_users where username='$username'";
                $result = DB::select( $sql );
                if ( count( $result ) > 0 ) {
                    $ref_id = $result[ 0 ]->id;
                }
                $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$username'";
                DB::update( DB::raw( $sql ) );

                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$rechargeuser_id','$ref_id','$rechargeuser_id','$amount','$ad_info1','$service_status1','$time','$paydate',1,'recharge')";
                DB::insert( DB::raw( $sql ) );
            }
            $message = 'success';
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        echo json_encode( $response );
    }

    public function getaddress( Request $request ) {
        $API_KEY = env( 'API_KEY', '' );
        $apiKey = $request->get( 'key' );
        if ( $API_KEY == $apiKey ) {
            $tailoring = $request->get( 'tailoring' );
            foreach ( $tailoring as $key => $value ) {
                $username = $value[ 'username' ];
                $sql = "SELECT permanent_address_1 FROM users where username='$username'";
                $result = DB::select( $sql );
                if ( count( $result ) > 0 ) {
                    $tailoring[ $key ][ 'address' ] = $result[ 0 ]->permanent_address_1;
                } else {
                    $message = 'Username not found';
                }
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'tailoring' ] = $tailoring;
        return response()->json( $response );
    }

    public function scholarship_activate_student( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "ScholarShip activate student $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function scholarship_accept_student( $username, $student_id, $sup_amount, $ref_amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $ref_id = 0;
        $message = '';
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $ref_id = $result[ 0 ]->id;
            }
            if ( $ref_id != 0 ) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'ScholarShip accept student N'.$student_id;
                $service_status = 'In Payment';
                $sql = "update wallet_users set wallet = wallet + $ref_amount,commission = commission + $ref_amount where username = '$username'";
                DB::update( DB::raw( $sql ) );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$to_id','$ref_id','$to_id','$ref_amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                DB::insert( DB::raw( $sql ) );
                $sql = "update wallet_users set wallet = wallet + $sup_amount,commission = commission + $sup_amount where id = $to_id";
                DB::update( DB::raw( $sql ) );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$to_id','$to_id','$to_id','$sup_amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                DB::insert( DB::raw( $sql ) );
                $message = 'success';
            } else {
                $message = 'Referral username not found in nalvariyam';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function scholarship_tailoring_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "Tailoring payment $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function scholarship_tailoring_credit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $superadmin_id = 1;
        $referral_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        $referral_username1 = '';
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $referral_id1 = $result[ 0 ]->referral_id;
                $sql2 = "SELECT * FROM users where id='$referral_id1'";
                $result2 = DB::select( $sql2 );
                if ( count( $result2 ) > 0 ) {
                    $referral_username1 = $result2[ 0 ]->username;
                }
                $sql3 = "SELECT * FROM wallet_users where username='$referral_username1'";
                $result3 = DB::select( $sql3 );
                if ( count( $result3 ) > 0 ) {
                    $referral_id = $result3[ 0 ]->id;
                }
            }

            if ( $referral_id != 0 ) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'Tailoring Commission';
                $service_status = 'Out Payment';
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$referral_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
                DB::insert( DB::raw( $sql ) );
                WalletHelper::debitWallet2( 'RJ01N001', $amount );
                $service_status = 'IN Payment';
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$referral_id','$superadmin_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                DB::insert( DB::raw( $sql ) );
                $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$referral_username1'";
                DB::update( DB::raw( $sql ) );
                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        $response[ 'referral_username' ] = $referral_username1;
        return response()->json( $response );
    }

    //Matrimony Activate member

    public function matrimony_activate_member( $usertype, $username, $adminuser_name, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $superadmin_id = 1;
        $superadmin_username = 'RJ01NOO1';
        $admin_id = 0;
        $customer_id = 0;
        $total_amount = 500;
        $superadmin_amount = 200;
        $admin_amount = 300;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $customer_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM wallet_users where username='$adminuser_name'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $admin_id = $result[ 0 ]->id;
            }
            if ( $admin_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "Matrimony activate Member $username";
                    $service_status = 'Out Payment';
                    if ( $usertype == 'Admin' ) {
                        WalletHelper::debitWallet2( $adminuser_name, $superadmin_amount );
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$admin_id','$admin_id','$superadmin_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate','matrimony')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "update wallet_users set wallet = wallet + $superadmin_amount,commission = commission + $superadmin_amount where id = $superadmin_id";
                        DB::update( DB::raw( $sql ) );
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$admin_id','$superadmin_id','$admin_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate',1,'matrimony')";
                        DB::insert( DB::raw( $sql ) );
                        $message = 'success';
                    } else if ( $usertype == 'Customer' ) {
                        WalletHelper::debitWallet2( $username, $total_amount );
                        $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$customer_id','$customer_id','$superadmin_id','$total_amount','$ad_info', '$service_status','$time','$paydate','matrimony')";
                        DB::insert( DB::raw( $sql ) );
                        $service_status = 'In Payment';
                        $sql = "update wallet_users set wallet = wallet + $total_amount,commission = commission + $total_amount where id = $superadmin_id";
                        DB::update( DB::raw( $sql ) );
                        if($adminuser_name == ""){
                            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$customer_id','$superadmin_id','$customer_id','$total_amount','$ad_info', '$service_status','$time','$paydate',1,'matrimony')";
                            DB::insert( DB::raw( $sql ) );
                            $sql = "update wallet_users set wallet = wallet + $total_amount,commission = commission + $total_amount where id = $superadmin_id";
                            DB::update( DB::raw( $sql ) );
                        }else{
                            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$customer_id','$superadmin_id','$customer_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate',1,'matrimony')";
                            DB::insert( DB::raw( $sql ) );
                            $sql = "update wallet_users set wallet = wallet + $superadmin_amount,commission = commission + $superadmin_amount where id = $superadmin_id";
                            DB::update( DB::raw( $sql ) );
                            $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$customer_id','$admin_id','$customer_id','$admin_amount','$ad_info', '$service_status','$time','$paydate',1,'matrimony')";
                            DB::insert( DB::raw( $sql ) );
                            $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where id = $admin_id";
                            DB::update( DB::raw( $sql ) );
                        }

                        $message = 'success';
                    } else {
                        $message = 'Insufficient fund in wallet';
                    }
                } else {
                    $message = 'Username not found';
                }
            } else {
                $message = 'Access Denied';
            }
            $response[ 'username' ] = $username;
            $response[ 'message' ] = $message;
            return response()->json( $response );
        }
    }

    public function debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "LIC premium payment $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    //$sql = "update users set wallet = wallet - $amount where id = $log_id";
                    //DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','lic')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'lic')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //Voter ID debit money from center wallet

    public function voterid_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "Voter ID service payment $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //Voter ID credit money to admin and superadmin wallet

    public function voterid_credit_wallet( $admin_username, $admin_amount, $referral_username, $referral_amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $superadmin_id = 1;
        $admin_id = 0;
        $referral_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$admin_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM wallet_users where username='$referral_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $referral_id = $result[ 0 ]->id;
            }
            if ( $referral_id != 0 ) {
                if ( $admin_id != 0 ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'Voter ID service payment';
                    $service_status = 'Out Payment';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','voterid')";
                    DB::insert( DB::raw( $sql ) );
                    WalletHelper::debitWallet2( 'RJ01N001', $admin_amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$referral_id','$referral_amount','$ad_info', '$service_status','$time','$paydate','voterid')";
                    DB::insert( DB::raw( $sql ) );
                    WalletHelper::debitWallet2( 'RJ01N001', $referral_amount );
                    $service_status = 'IN Payment';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$admin_id','$superadmin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate',1,'voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where username = '$admin_username'";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$referral_id','$superadmin_id','$referral_amount','$ad_info', '$service_status','$time','$paydate',1,'voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $referral_amount,commission = commission + $referral_amount where username = '$referral_username'";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Username not found';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //Voter ID debit money from center wallet

    public function voterid_activate_center( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "Voter ID activate center $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'voterid')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //LIC debit money from center wallet

    public function lic_activate_center( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "LIC activate center $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    //$sql = "update users set wallet = wallet - $amount where id = $log_id";
                    //DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','lic')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'lic')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function lic_debit_wallet_and_pay_commission( $username, $adminusername, $amount, $commission, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $admin_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM users where username='$adminusername'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 && $admin_id != 0 ) {
                if ( $balance >= $amount ) {
                    $admin_amount = $amount * ( $commission/100 );
                    $superadmin_amount = $amount - $admin_amount;
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "LIC premium payment $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $superadmin_amount );
                    //$sql = "update users set wallet = wallet - $superadmin_amount where id = $log_id";
                    //DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate','lic')";
                    DB::insert( DB::raw( $sql ) );
                    WalletHelper::debitWallet2( $admin_username, $admin_amount );
                    //$sql = "update users set wallet = wallet - $admin_amount where id = $log_id";
                    //DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','lic')";
                    DB::insert( DB::raw( $sql ) );

                    $service_status = 'In Payment';
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$superadmin_amount','$ad_info', '$service_status','$time','$paydate',1,'lic')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $superadmin_amount,commission = commission + $superadmin_amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$admin_id','$log_id','$admin_amount','$ad_info', '$service_status','$time','$paydate',1,'lic')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where username = '$adminusername'";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //PILGRIM debit money from center wallet

    public function pilgrim_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
                $full_name = $result[ 0 ]->full_name;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'Pligrim service payment';
                    $service_status = 'Out Payment';
                    $sql = "update users set wallet = wallet - $amount where id = $log_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update users set wallet = wallet + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //PILGRIM credit money to admin and superadmin wallet

    public function pilgrim_credit_wallet( $admin_username, $admin_amount, $referral_username, $referral_amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $superadmin_id = 1;
        $admin_id = 0;
        $referral_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM users where username='$admin_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM users where username='$referral_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $referral_id = $result[ 0 ]->id;
            }
            if ( $referral_id != 0 ) {
                if ( $admin_id != 0 ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'Pilgrim service payment';
                    $service_status = 'Out Payment';
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$superadmin_id','$superadmin_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update users set wallet = wallet - $admin_amount where id = $superadmin_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$superadmin_id','$superadmin_id','$referral_id','$referral_amount','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update users set wallet = wallet - $referral_amount where id = $superadmin_id";
                    DB::update( DB::raw( $sql ) );
                    $service_status = 'IN Payment';
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$superadmin_id','$admin_id','$superadmin_id','$superadmin_id','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update users set wallet = wallet + $admin_amount where id = $admin_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$superadmin_id','$referral_id','$superadmin_id','$referral_amount','$ad_info', '$service_status','$time','$paydate')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update users set wallet = wallet + $referral_amount where id = $referral_id";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Username not found';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //Pan Card debit money from center wallet

    public function pancard_debit_wallet( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "PAN Card service payment $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'amount' ] = $amount;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //PAN Card credit money to admin and superadmin wallet

    public function pancard_credit_wallet( $admin_username, $admin_amount, $referral_username, $referral_amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $superadmin_id = 1;
        $admin_id = 0;
        $referral_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$admin_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $admin_id = $result[ 0 ]->id;
            }
            $sql = "SELECT * FROM wallet_users where username='$referral_username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $referral_id = $result[ 0 ]->id;
            }
            if ( $referral_id != 0 ) {
                if ( $admin_id != 0 ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = 'PAN Card service payment';
                    $service_status = 'Out Payment';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$admin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate','pancard')";
                    DB::insert( DB::raw( $sql ) );
                    WalletHelper::debitWallet2( 'RJ01N001', $admin_amount );
                    //$sql = "update users set wallet = wallet - $admin_amount where id = $superadmin_id";
                    //DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$referral_id','$referral_amount','$ad_info', '$service_status','$time','$paydate','pancard')";
                    DB::insert( DB::raw( $sql ) );
                    WalletHelper::debitWallet2( 'RJ01N001', $referral_amount );
                    $service_status = 'IN Payment';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$admin_id','$superadmin_id','$admin_amount','$ad_info', '$service_status','$time','$paydate',1,'pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $admin_amount,commission = commission + $admin_amount where username = '$admin_username'";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$referral_id','$superadmin_id','$referral_amount','$ad_info', '$service_status','$time','$paydate',1,'pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $sql = "update wallet_users set wallet = wallet + $referral_amount,commission = commission + $referral_amount where username = '$referral_username'";
                    DB::update( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Username not found';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    //Pan Card debit money from center wallet

    public function pancard_activate_center( $username, $amount, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $to_id = 1;
        $log_id = 0;
        $message = '';
        $full_name = '';
        $balance = 0;
        $response = array();
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                if ( $balance >= $amount ) {
                    $paydate = date( 'Y-m-d' );
                    $time = date( 'H:i:s' );
                    $ad_info = "PAN Card activate center $username";
                    $service_status = 'Out Payment';
                    WalletHelper::debitWallet2( $username, $amount );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $service_status = 'In Payment';
                    $sql = "update users set wallet = wallet + $amount,commission = commission + $amount where id = $to_id";
                    DB::update( DB::raw( $sql ) );
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'pancard')";
                    DB::insert( DB::raw( $sql ) );
                    $message = 'success';
                } else {
                    $message = 'Insufficient fund in wallet';
                }
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function approve_amount( $username, $amount, $context, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $message = '';
        $from_id = 1;
        $log_id = 0;
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'Fund Transfer'.' '.$context;
                $service_status = 'Out Payment';
                WalletHelper::debitWallet2( 'RJ01N001', $amount );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$from_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate','$context')";
                DB::insert( DB::raw( $sql ) );

                $service_status = 'In Payment';
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$log_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','$context')";
                DB::insert( DB::raw( $sql ) );

                $sql = "update wallet_users set wallet=wallet+$amount,deposit=deposit+$amount where username='$username'";
                DB::update( $sql );
                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }

        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function recharge_approve_amount( $username, $amount, $context, $refusername, $refcom, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $message = '';
        $from_id = 1;
        $log_id = 0;
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $balance = $result[ 0 ]->wallet;
                $log_id = $result[ 0 ]->id;
            }
            if ( $log_id != 0 ) {
                $paydate = date( 'Y-m-d' );
                $time = date( 'H:i:s' );
                $ad_info = 'Fund Transfer'.' '.$context;
                $service_status = 'Out Payment';
                WalletHelper::debitWallet2( 'RJ01N001', $amount );
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$from_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate','$context')";
                DB::insert( DB::raw( $sql ) );

                $service_status = 'In Payment';
                $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$log_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','$context')";
                DB::insert( DB::raw( $sql ) );

                $sql = "update wallet_users set wallet=wallet+$amount,commission=commission+$amount where username='$username'";
                DB::update( $sql );

                if ( $refcom == 1 ) {
                    $sql = "SELECT * FROM wallet_users where username='$refusername'";
                    $result = DB::select( $sql );
                    if ( count( $result ) > 0 ) {
                        $reflog_id = $result[ 0 ]->id;
                    }
                    $amount = 5;
                    $service_status = 'In Payment';
                    $ad_info = 'First TopUp Commission from referred user';
                    $sql = "insert into transaction_history (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$from_id','$reflog_id','$from_id','$amount','$ad_info', '$service_status','$time','$paydate','$context')";
                    DB::insert( DB::raw( $sql ) );

                    $sql = "update wallet_users set wallet=wallet+$amount,commission=commission+$amount where username='$refusername'";
                    DB::update( $sql );
                }

                $message = 'success';
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }

        $response[ 'username' ] = $username;
        $response[ 'message' ] = $message;
        return response()->json( $response );
    }

    public function totalwallet_history( $username, $usertype, $from, $to, $key ) {
        $API_KEY = env( 'API_KEY', '' );
        $username = trim( $username );
        $response = array();
        $wallet = array();
        $wallet2 = array();
        $message = '';
        $balance = 0;
        if ( $key == $API_KEY ) {
            $sql = "SELECT * FROM wallet_users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $log_id = $result[ 0 ]->id;
                $balance = $result[ 0 ]->wallet;
                $message = 'success';
                $sql = "select * from transaction_history where paydate >= '$from' and paydate <= '$to'";
                $sql = $sql ."  and from_id = $log_id";
                $sql = $sql .'  order by id desc';
                $wallet = DB::select( $sql );
            } else {
                $message = 'Username not found';
            }
            $sql = "SELECT * FROM users where username='$username'";
            $result = DB::select( $sql );
            if ( count( $result ) > 0 ) {
                $log_id = $result[ 0 ]->id;
                $message = 'success';
                $sql = "select * from payment where paydate >= '$from' and paydate <= '$to'";
                $sql = $sql ."  and from_id = $log_id and service_entity = 'nalavariyam'";
                $sql = $sql .'  order by id desc';
                $wallet2 = DB::select( $sql );
            } else {
                $message = 'Username not found';
            }
        } else {
            $message = 'Access Denied';
        }
        $wallet = json_decode( json_encode( $wallet ), true );
        $wallet2 = json_decode( json_encode( $wallet2 ), true );
        $wallet = array_merge( $wallet, $wallet2 );
        //dd( $wallet );
        $response[ 'username' ] = $username;
        $response[ 'wallet' ] = $wallet;
        $response[ 'message' ] = $message;
        $response[ 'balance' ] = $balance;
        return response()->json( $response );
    }

}
