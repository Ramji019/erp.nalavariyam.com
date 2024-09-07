<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\WalletHelper;


class TailoringController extends Controller
{

      public function __construct()
 {

        $this->middleware( 'auth' );
    }

	public function tailoring()
    {
    	if(Auth::user()->user_type_id == 1){
			$tailoring = DB::table('tailoring')->orderBy('payment_status', 'Desc')->get();
		}else{
			$tailoring = DB::table('tailoring')->where('user_id',Auth::user()->id)->orderBy('id', 'Asc')->get();
		}
		$tailoring = json_decode( json_encode( $tailoring ), true );
        foreach ( $tailoring as $key => $ser ) {
            $userid = $ser[ 'user_id' ];
            $sql = "select permanent_address_1 from users where id = $userid";
            $result = DB::select( DB::raw( $sql ) );
            $tailoring[ $key ][ 'address' ] = $result;
          
        }
        $tailoring = json_decode( json_encode( $tailoring ) );
        //echo "<pre>";print_r($tailoring);echo"</pre>";die;

    	return view('tailoring/index',compact('tailoring'));
    }
	
	public function addtailoring(Request $request)
	{
		DB::table('tailoring')->insert([
		'name' => $request->name,
		'phone_number'=> $request->phone_number,
		'address_1' => $request->address_1,
		'address_2' => $request->address_2,
		'taluk' => $request->taluk,
		'district' => $request->district,
		'pin_code' => $request->pin_code,
		'aadhar_number' => $request->aadhar_number,
		'status'=>'Active',
		'payment_status'=>'New',
		'user_id'=>Auth::user()->id,
		]);
		  $insert_id = DB::getPdo()->lastInsertId();
        $profile_image = '';

        if ( $request->profile_image != null ) {
            $profile_image = $insert_id . '.' . $request->file( 'profile_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoringprofile' . DIRECTORY_SEPARATOR);
            move_uploaded_file( $_FILES[ 'profile_image' ][ 'tmp_name' ], $filepath . $profile_image );
        }
        DB::table( 'tailoring' )->where( 'id', $insert_id )->update( [
            'profile_image' => $profile_image,
        ] );

		return redirect()->back()->with('Success','Add Successfully....!');
	}


	public function tailoringpayment_update( Request $request ) {
        $log_id = Auth::user()->id;
        $to_id = 1;
        $ad_info = "Tailoring Certificate Payment";
        $payment_amount = $request->payment_amount;
        $customerid = $request->customerid;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $service_status = 'IN Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission) values ('$log_id','$to_id','$log_id','$payment_amount','$ad_info', '$service_status','$time','$paydate',1)";
        DB::insert( DB::raw( $sql ));
        $sql = "update users set wallet = wallet + $payment_amount,commission = commission + $payment_amount where id = $to_id";
        DB::update( DB::raw( $sql ));  
        $service_status = 'Out Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$log_id','$log_id','$to_id','$payment_amount','$ad_info', '$service_status','$time','$paydate')";
        DB::insert( DB::raw( $sql ) );
         WalletHelper::debitWallet($log_id,$payment_amount);
  		  $sql = "update tailoring set payment_status = 'Pending' where id = $customerid";
        DB::update( DB::raw( $sql )); 
        return redirect( 'tailoring' );
    }

    public function approve_certificate(Request $request)
	{
		$payment_status = $request->payment_status;
		DB::table('tailoring')->where('id', $request->customerid)->update([
			'payment_status' => $payment_status,
			'reason' => $request->reason,
		]);
		if($payment_status == "Completed"){
		$log_id = 1;
        $to_id = $request->userid;
        $ad_info = "Tailoring Certificate Payment";
        $payment_amount = 50;
        $paydate = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $service_status = 'IN Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission) values ('$to_id','$to_id','$to_id','$payment_amount','$ad_info', '$service_status','$time','$paydate',1)";
        DB::insert( DB::raw( $sql ));
        $sql = "update users set wallet = wallet + $payment_amount,commission = commission + $payment_amount where id = $to_id";
        DB::update( DB::raw( $sql ));  
        $service_status = 'Out Payment';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate) values ('$log_id','$to_id','$log_id','$payment_amount','$ad_info', '$service_status','$time','$paydate')";
        DB::insert( DB::raw( $sql ) );
        WalletHelper::debitWallet($log_id,$payment_amount);
		}
		
		return redirect()->back()->with('Success','Update Successfully....!');
		
	}

	public function resubmit_certificate(Request $request)
	{
		DB::table('tailoring')->where('id', $request->customerid)->update([
		'name' => $request->name,
		'address_1' => $request->address_1,
		'address_2' => $request->address_2,
		'taluk' => $request->taluk,
		'district' => $request->district,
		'payment_status'=>'Pending',
		]);

        if ( $request->profile_image != null ) {
            $profile_image = $request->customerid . '.' . $request->file( 'profile_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoringprofile' . DIRECTORY_SEPARATOR);
            move_uploaded_file( $_FILES[ 'profile_image' ][ 'tmp_name' ], $filepath . $profile_image );
               DB::table( 'tailoring' )->where( 'id', $request->customerid )->update( [
            'profile_image' => $profile_image,
        ] );
        }
     

		return redirect()->back()->with('Success','Add Successfully....!');
	}

	
	public function updatetailoring(Request $request)
	{
		DB::table('tailoring')->where('id', $request->tailoring_id)->update([
			'name' => $request->name,
			'status' => $request->status,
		]);
		
		return redirect()->back()->with('Success','Update Successfully....!');
		
	}
	
	public function deletetailoring($id)
	{
		$deleteimage = DB::table('tailoring')->where('id', $id)->delete();
		return redirect('tailoring')->with('success', 'delete Successfully.....!');
	}
	
	
} 