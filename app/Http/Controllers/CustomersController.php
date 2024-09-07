<?php
namespace App\Http\Controllers;
use App\WalletHelper;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Response;

class CustomersController extends Controller
{
  public function __construct()
  {
    $this->middleware( 'auth' );
  }

  public function allcustomers()
  {
    $allcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->Join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->Join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->orderBy( 'customers.id', 'Asc' )->get();

    return view( 'customers/all', compact( 'allcustomers' ) );
  }
  
    public function performers( $from, $to)
  {
   $in_condtion = " where user_type_id in (4,5,6,7,8,9,10,11,12,13)";
    if(Auth::user()->user_type_id == 1){
    $sql=" select log_id, count(log_id) as service_count from payments where service_status='Img' and paydate >= '$from' and paydate <= '$to' and log_id in (select id from users $in_condtion )  group by log_id order by service_count desc";
	} else {
		$userid= Auth::user()->id;

    $sql=" select log_id,count(log_id) as service_count from payments where service_status='Img' and paydate >= '$from' and paydate <= '$to' and log_id in (select id from users  where referral_id = $userid )  group by log_id order by service_count desc";
	
    }
    $services = DB::select($sql);
    $services = json_decode( json_encode( $services ), true );
    foreach ( $services as $key => $service ) {
        $log_id = $service[ 'log_id' ];
        $sql = "select c.group_name,a.full_name,a.user_photo,a.phone, a.id as userid,b.district_name from users a,district b,user_type c where a.dist_id=b.id and a.user_type_id = c.id and a.id=$log_id";
        $result = DB::select( $sql );
        if ( count( $result ) > 0 ) {
            $services[ $key ][ 'group_name' ] = $result[0]->group_name;
            $services[ $key ][ 'district_name' ] = $result[0]->district_name;
            $services[ $key ][ 'userid' ] = $result[0]->userid;
            $services[ $key ][ 'full_name' ] = $result[0]->full_name;
            $services[ $key ][ 'user_photo' ] = $result[0]->user_photo;
            $services[ $key ][ 'phone' ] = $result[0]->phone;
        }
    }
    $services = json_decode( json_encode( $services ) );
    return view( 'customers/performers',compact('services', 'from', 'to') );
  }


  public function topperformers()
  {
    $in_condtion = " where 1=1 ";
    if(Auth::user()->user_type_id == 2){
            $in_condtion = " where user_type_id in (2,4,6,8,10,12)";
    }else if(Auth::user()->user_type_id == 4){
        $in_condtion = " where user_type_id in (4,6,8,10,12)";
    }else if(Auth::user()->user_type_id == 6){
        $in_condtion = " where user_type_id in (6,8,12)";
    }else if(Auth::user()->user_type_id == 8){
        $in_condtion = " where user_type_id in (8,12)";
    }else if(Auth::user()->user_type_id == 10){
        $in_condtion = " where user_type_id in (10,8,12)";
    }else if(Auth::user()->user_type_id == 12){
        $in_condtion = " where user_type_id in (12)";
    }else if(Auth::user()->user_type_id == 3){
        $in_condtion = " where user_type_id in (3,5,7,9,11,13)";
    }else if(Auth::user()->user_type_id == 5){
        $in_condtion = " where user_type_id in (5,7,9,11,13)";
    }else if(Auth::user()->user_type_id == 7){
        $in_condtion = " where user_type_id in (7,9,13)";
    }else if(Auth::user()->user_type_id == 9){
        $in_condtion = " where user_type_id in (9,13)";
    }else if(Auth::user()->user_type_id == 11){
        $in_condtion = " where user_type_id in (11,9,13)";
    }else if(Auth::user()->user_type_id == 13){
        $in_condtion = " where user_type_id in (13)";
    }
    $sql=" select log_id,count(log_id) as service_count from payments where service_status='Img' and log_id in (select id from users $in_condtion )  group by log_id order by service_count desc";
    $services = DB::select($sql);
    $services = json_decode( json_encode( $services ), true );
    foreach ( $services as $key => $service ) {
        $log_id = $service[ 'log_id' ];
        $sql = "select username,full_name,user_photo from users where id=$log_id";
        $result = DB::select( $sql );
        if ( count( $result ) > 0 ) {
            $services[ $key ][ 'username' ] = $result[0]->username;
            $services[ $key ][ 'full_name' ] = $result[0]->full_name;
            $services[ $key ][ 'user_photo' ] = $result[0]->user_photo;
        }
    }
    $services = json_decode( json_encode( $services ) );
    return view( 'customers/topperformers',compact('services') );
  }

  public function customers()
  {
    $viewcustomers = array();
    $referral_id = Auth::user()->id;
    $dist_id = Auth::user()->dist_id;
    if ( Auth::user()->user_type_id == 1 ) {
      $user_type_id = array( '14', '15' );
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->wherein( 'customers.user_type_id', $user_type_id )->orderBy( 'customers.id', 'Asc' )->paginate(10);

    } elseif ( Auth::user()->user_type_id == 2 ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->paginate(10);

    } elseif ( Auth::user()->user_type_id == 3 ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->paginate(10);
    } elseif ( Auth::user()->user_type_id == 4 ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->paginate(10);

    } elseif ( Auth::user()->user_type_id == 5 ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->paginate(10);

    } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 12 ) ) {

      $user_type_ids = '14';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->paginate(10);

    } elseif ( ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 13 ) ) {
      $user_type_ids = '15';
      $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->paginate(10);
    }

  foreach ( $viewcustomers as $key => $member ) {
    $customer_id = $member->id;
    $sql2 = "select * from customer_documents where customer_id=$customer_id order by id desc";
    $result2 = DB::select( DB::raw( $sql2 ) );
    $viewcustomers[ $key ]->documents = $result2;
  }
    $authdistrict_id = Auth::user()->dist_id;
    $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
    $authdistrictown = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->first();
    $managedistrict = DB::table( 'district' )->get();

    return view( 'customers/index', compact( 'viewcustomers', 'authdistrict', 'managedistrict','authdistrictown' ) );
  }

  function fetch_data( Request $request ){
    $userid = Auth::user()->id;
    $referral_id = Auth::user()->id;
    if ( $request->ajax() ) {
     $query1 = $request->get( 'query' );
     $perpage = $request->get( 'perpage' );
     $sortby = $request->get( 'sortby' );
     $sortorder = $request->get( 'sortorder' );
     $search1 = str_replace( ' ', '%', $query1 );
     if ( Auth::user()->user_type_id == 1 ) {
        $user_type_id = array( '14', '15' );
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->wherein( 'customers.user_type_id', $user_type_id )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );

      } elseif ( Auth::user()->user_type_id == 2 ) {

        $user_type_ids = '14';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids ) ->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );

      } elseif ( Auth::user()->user_type_id == 3 ) {
        $user_type_ids = '15';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );
      } elseif ( Auth::user()->user_type_id == 4 ) {

        $user_type_ids = '14';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );

      } elseif ( Auth::user()->user_type_id == 5 ) {
        $user_type_ids = '15';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );

      } elseif ( ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 12 ) ) {

        $user_type_ids = '14';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );

      } elseif ( ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 13 ) ) {
        $user_type_ids = '15';
        $viewcustomers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'customers.id as userID' )
        ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
        ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->where(function($query) use($search1){
            $query->Where( 'customers.phone', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.username', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.full_name_tamil', 'like', '%'.$search1.'%' )
        ->orWhere( 'district.district_name', 'like', '%'.$search1.'%' )
        ->orWhere( 'customers.id', 'like', '%'.$search1.'%' );
        })->orderBy( 'customers.id' , $sortorder)
        ->paginate( $perpage );
      }

    foreach ( $viewcustomers as $key => $member ) {
      $customer_id = $member->id;
      $sql2 = "select * from customer_documents where customer_id=$customer_id order by id desc";
      $result2 = DB::select( DB::raw( $sql2 ) );
      $viewcustomers[ $key ]->documents = $result2;
    }
      $authdistrict_id = Auth::user()->dist_id;
      $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
      $authdistrictown = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->first();
      $managedistrict = DB::table( 'district' )->get();

     return view( 'customers/customerpaginate', compact( 'viewcustomers' ))->render();
   }
 }

  public function addcustomer( Request $request )
  {
    $user_id = Auth::user()->id;
    $dist_id = $request->dist_id;
   /* $sql = "Select * from district where id = $dist_id order by id";
    $result = DB::select( DB::raw( $sql ) );
    if ( count( $result ) > 0 ) {
      $districtid = $result[ 0 ]->districtid;
    }
    $uniqueId = rand( 111111111, 999999999 );
    $username = 'RJ' . $districtid . 'N' . $uniqueId;*/
    $addcustomer = DB::table( 'customers' )->insert( [
      'full_name_tamil' => $request->full_name_tamil,
      'dist_id' => $dist_id,
      'taluk_id' => $request->taluk_id,
      'referral_id' => $user_id,
      'aadhaar_no' => $request->aadhaar_no,
      'phone' => $request->phone,
      'user_type_id' => $request->user_type_id,
      'status' => 'Active',
      'member_photo' => 'user.jpg',
      'log_id' => $user_id
    ]);

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
        $sql="insert into wallet_users (username) values ('$username')";
        DB::insert($sql);
         $sql = "update customers set username='$username' where id = $insertid";
        DB::update( DB::raw( $sql ) );

    return redirect()->back()->with( 'success', 'Customer added Successfully ... !' );
  }

  public function addowncustomer( Request $request )
  {
    $user_id = Auth::user()->id;
    $dist_id = $request->dist_id;
    DB::table( 'customers' )->insert( [
      'full_name_tamil' => $request->full_name,
      'dist_id' => $dist_id,
      'referral_id' => $user_id,
      'phone' => $request->phone,
      'application_no' => $request->application_no,
      'service_type' => $request->service_name,
      'user_type_id' => $request->user_type_id,
      'status' => 'Active',
      'member_photo' => 'user.jpg',
      'log_id' => $user_id
    ]);

    return redirect()->back()->with( 'success', 'Add Own Customer Successfully ... !' );
  }

  public function customeraadhar( Request $request )
  {
    $aadhar = trim( $request->aadhar );
    $id = trim( $request->id );
    if ( $id == 0 ) {
      $sql = "SELECT * FROM customers where aadhaar_no='$aadhar'";
    } else {
      $sql = "SELECT * FROM customers where aadhaar_no='$aadhar' and id <> $id";
    }
    $customers = DB::select( DB::raw( $sql ) );
    if ( count( $customers ) > 0 ) {
      return response()->json( array( 'exists' => true ) );
    } else {
      return response()->json( array( 'exists' => false ) );
    }
  }

  public function customerphone( Request $request )
  {
    $phone = trim( $request->phone );
    $id = trim( $request->id );
    if ( $id == 0 ) {
      $sql = "SELECT * FROM customers where phone='$phone'";
    } else {
      $sql = "SELECT * FROM customers where phone='$phone' and id <> $id";
    }
    $customers = DB::select( DB::raw( $sql ) );
    if ( count( $customers ) > 0 ) {
      return response()->json( array( 'exists' => true ) );
    } else {
      return response()->json( array( 'exists' => false ) );
    }
  }

  public function customerregister( Request $request )
  {
    $register = trim( $request->register );
    $id = trim( $request->id );
    if ( $id == 0 ) {
      $sql = "SELECT * FROM customers where registeration_no='$register'";
    } else {
      $sql = "SELECT * FROM customers where registeration_no='$register' and id <> $id";
    }
    $customers = DB::select( DB::raw( $sql ) );
    if ( count( $customers ) > 0 ) {
      return response()->json( array( 'exists' => true ) );
    } else {
      return response()->json( array( 'exists' => false ) );
    }
  }

  public function editcustomers( $id )
  {
    $customers = DB::table( 'customers' )->where( 'id', '=', $id )->get();
    $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
    return view( 'customers/editcustomers', compact( 'customers', 'managedistrict' ) );
  }

  public function updatecustomers( Request $request )
  {
    $updatecustomers = DB::table( 'customers' )->where( 'id', $request->id )->update( [
      'full_name_tamil' => $request->full_name_tamil,
      'dist_id' => $request->dist_id,
      'aadhaar_no' => $request->aadhaar_no,
      'phone' => $request->phone,
      'gender' => $request->gender,
      'permanent_address_1' => $request->permanent_address_1,
    ] );
    return redirect( 'customers' );
  }

  public function members()
  {
    $viewmembers = array();
    $referral_id = Auth::user()->id;
    if ( Auth::user()->user_type_id == 1 ) {

      $user_type_id = array( '18', '19' );
      $viewmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->Join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
      ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
      ->wherein( 'customers.user_type_id', $user_type_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( Auth::user()->user_type_id == 2 ) {

      $user_type_ids = '18';
      $viewmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
      ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( Auth::user()->user_type_id == 3 ) {

      $user_type_ids = '19';
      $viewmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
      ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();
    } elseif ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) ) {

      $user_type_ids = '18';
      $viewmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
      ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

    } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) ) {

      $user_type_ids = '19';
      $viewmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
      ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
      ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
      ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
      ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();
    }

    $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
    $authdistrict_id = Auth::user()->dist_id;
    $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
    $work_two = DB::table( 'work_two' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
    $viewmembers = json_decode( json_encode( $viewmembers ), true );
    foreach ( $viewmembers as $key => $member ) {
      $customer_id = $member[ 'id' ];
      $sql2 = "select * from customer_documents where customer_id=$customer_id order by id desc";
      $result2 = DB::select( DB::raw( $sql2 ) );
      $viewmembers[ $key ][ 'documents' ] = $result2;
    }
    $viewmembers = json_decode( json_encode( $viewmembers ) );

    $referral = array();
    $sql = '';
    if ( Auth::user()->user_type_id == 2 ||
      Auth::user()->user_type_id == 3 ||
      Auth::user()->user_type_id == 4 ||
      Auth::user()->user_type_id == 5 ||
      Auth::user()->user_type_id == 6 ||
      Auth::user()->user_type_id == 7 ||
      Auth::user()->user_type_id == 8 ||
      Auth::user()->user_type_id == 9 ||
      Auth::user()->user_type_id == 10 ||
      Auth::user()->user_type_id == 11 ) {
      if ( Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 6 || Auth::user()->user_type_id == 8 || Auth::user()->user_type_id == 10 ) {
        $sql = 'select id,username,full_name from users where user_type_id in (2,4,6,8,10,12)';
      }
      if ( Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5 || Auth::user()->user_type_id == 7
        || Auth::user()->user_type_id == 9 || Auth::user()->user_type_id == 11 ) {
        $sql = 'select id,username,full_name from users where user_type_id in (3,5,7,9,11,13)';
    }
    $referral = DB::select( DB::raw( $sql ) );

    $referral = json_decode( json_encode( $referral ), true );
  }
  return view( 'customers/members', compact( 'viewmembers', 'managedistrict', 'work_two', 'authdistrict', 'referral' ) );
}

public function specialmembers()
{
  $specialmembers = array();
  $referral_id = Auth::user()->id;
  if ( Auth::user()->user_type_id == 1 ) {

    $user_type_id = array( '20', '21' );
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->wherein( 'customers.user_type_id', $user_type_id )->orderBy( 'customers.id', 'Asc' )->get();

  } elseif ( Auth::user()->user_type_id == 2 ) {

    $user_type_ids = '20';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();

  } elseif ( Auth::user()->user_type_id == 3 ) {

    $user_type_ids = '21';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->orderBy( 'customers.id', 'Asc' )->get();

  } elseif ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) ) {

    $user_type_ids = '20';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

  } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) ) {

    $user_type_ids = '21';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();
  }

  $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
  $authdistrict_id = Auth::user()->dist_id;
  $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
  $work_two = DB::table( 'work_two' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
  $specialmembers = json_decode( json_encode( $specialmembers ), true );
  foreach ( $specialmembers as $key => $member ) {
    $customer_id = $member[ 'id' ];
    $sql2 = "select * from customer_documents where customer_id=$customer_id order by id desc";
    $result2 = DB::select( DB::raw( $sql2 ) );
    $specialmembers[ $key ][ 'documents' ] = $result2;
  }
  $specialmembers = json_decode( json_encode( $specialmembers ) );
  return view( 'customers/specialmembers', compact( 'specialmembers', 'managedistrict', 'work_two', 'authdistrict' ) );
}

public function idcard( $id ) {
        //246x156 ID CARD SIZE
  $referral_id = Auth::user()->id;
  $sql = "select referral_id,dist_id from customers where id=$id";
  $result = DB::select( $sql );
  $ref_id = $result[ 0 ]->referral_id;
  $cust_dist_id = $result[ 0 ]->dist_id;
  $sql = "select district_name from district where id=$cust_dist_id";
  $result = DB::select( $sql );
  $cust_dist_name = $result[ 0 ]->district_name;

  $sql = "select * from users where id=$ref_id";
  $result = DB::select( $sql );
  $district_user = $result[ 0 ]->full_name;
  $district_user_tamil = trim( $result[ 0 ]->full_name_tamil );
  $district_address = $result[ 0 ]->permanent_address_1;
  $district_address_tamil = trim( $result[ 0 ]->p_address_1_tamil );
  $district_phone = $result[ 0 ]->phone;
  $district_name_array[ 1 ] = 'Super Admin';
  $district_name_array[ 2 ] = 'President';
  $district_name_array[ 3 ] = 'Secretary';
  $district_name_array[ 4 ] = 'District President';
  $district_name_array[ 5 ] = 'District Secretary';
  $district_name_array[ 6 ] = 'Taluk President';
  $district_name_array[ 7 ] = 'Taluk Secretary';
  $district_name_array[ 8 ] = 'Panchayath President';
  $district_name_array[ 9 ] = 'Panchayath Secretary';
  $district_name_array[ 10 ] = 'Block President';
  $district_name_array[ 11 ] = 'Block Secretary';
  $district_name_array[ 12 ] = 'Center President';
  $district_name_array[ 13 ] = 'Center Secretary';
  $district_name = $district_name_array[ $result[ 0 ]->user_type_id ];
  $signature_name = 'Secretary';
  $signature = DB::table( 'users' )->select( 'signature2' )->where( 'id', '=', 3 )->orderBy( 'id', 'Asc' )->first()->signature2;
  if ( ( Auth::user()->user_type_id == 4 ) || ( Auth::user()->user_type_id == 6 ) || ( Auth::user()->user_type_id == 10 ) || ( Auth::user()->user_type_id == 8 ) || ( Auth::user()->user_type_id == 12 ) ) {
    $signature = DB::table( 'users' )->select( 'signature2' )->where( 'id', '=', 2 )->orderBy( 'id', 'Asc' )->first()->signature2;
    $user_type_ids = '20';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'work_there.work_there_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->join( 'work_there', 'work_there.id', '=', 'customers.work_there_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.id', $id )->orderBy( 'customers.id', 'Asc' )->first();

  } elseif ( ( Auth::user()->user_type_id == 5 ) || ( Auth::user()->user_type_id == 7 ) || ( Auth::user()->user_type_id == 11 ) || ( Auth::user()->user_type_id == 9 ) || ( Auth::user()->user_type_id == 13 ) ) {
    $result = DB::table( 'users' )->select( 'full_name', 'permanent_address_1', 'phone' )->where( 'id', '=', 5 )->orderBy( 'id', 'Asc' )->first();
    $user_type_ids = '21';
    $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'work_there.work_there_name', 'customers.id as userID' )
    ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
    ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
    ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
    ->join( 'work_there', 'work_there.id', '=', 'customers.work_there_id' )
    ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.id', $id )->orderBy( 'customers.id', 'Asc' )->first();
  }
  $type = 'jpg';
  $image = public_path( 'upload/idcard/front.jpg' );
  $css_path = asset( 'fonts/Lohit-Tamil.ttf' );
  $data = file_get_contents( $image );
  $bg = 'data:image/' . $type . ';base64,' . base64_encode( $data );
  $idcard = $id.'.png' ;
  /*$pdf = Pdf::loadView('customers/idcard', compact( 'specialmembers', 'bg', 'signature', 'signature_name', 'district_name', 'district_user', 'district_address', 'district_phone', 'css_path', 'district_user_tamil', 'district_address_tamil', 'idcard', 'cust_dist_name' ));
    return $pdf->download('invoice.pdf');*/
  return view( 'customers/idcard', compact( 'specialmembers', 'bg', 'signature', 'signature_name', 'district_name', 'district_user', 'district_address', 'district_phone', 'css_path', 'district_user_tamil', 'district_address_tamil', 'idcard', 'cust_dist_name' ) );
}

public function kannan( $id )
{
  $referral_id = Auth::user()->id;
  $sql = "select referral_id from customers where id=$id";
  $result = DB::select( $sql );
  $ref_id = $result[ 0 ]->referral_id;

  $signature = DB::table( 'users' )->select( 'signature2' )->where( 'id', '=', 2 )->orderBy( 'id', 'Asc' )->first()->signature2;
  $user_type_ids = '20';
  $specialmembers = DB::table( 'customers' )->select( 'customers.*', 'district.district_name', 'taluk.taluk_name', 'panchayath.panchayath_name', 'work_there.work_there_name', 'customers.id as userID' )
  ->Join( 'district', 'district.id', '=', 'customers.dist_id' )
  ->join( 'taluk', 'taluk.id', '=', 'customers.taluk_id' )
  ->join( 'panchayath', 'panchayath.id', '=', 'customers.panchayath_id' )
  ->join( 'work_there', 'work_there.id', '=', 'customers.work_there_id' )
  ->where( 'customers.user_type_id', $user_type_ids )->where( 'customers.referral_id', $referral_id )->orderBy( 'customers.id', 'Asc' )->get();

  $type = 'jpg';
  $image = public_path( 'upload/idcard/front.jpg' );
  $css_path = asset( 'fonts/Lohit-Tamil.ttf' );
  $data = file_get_contents( $image );
  $bg = 'data:image/' . $type . ';base64,' . base64_encode( $data );
        //return view( 'customers/idcard', compact( 'specialmembers', 'bg', 'signature', 'signature_name', 'district_name', 'district_user', 'district_address', 'district_phone' ) );

  return view( 'customers/idcard', compact( 'specialmembers', 'bg' ) );
}

public function specialmemberstatusupdate( $id, $usertype_id )
{
  $balance =  WalletHelper::wallet_balance(Auth::user()->username);
  $sql = "select status,full_name from customers where id = $id";
  $result = DB::select( DB::raw( $sql ) );
  $status = $result[ 0 ]->status;
  $full_name = $result[ 0 ]->full_name;
  $usertype = Auth::user()->user_type_id;
  $payment_amount = 300;
  if ( $usertype == 4 || $usertype == 5 ) {
    $payment_amount = 300;
  } else if ( $usertype == 6 || $usertype == 7 ) {
    $payment_amount = 500;
  } else if ( $usertype == 8 || $usertype == 9 ) {
    $payment_amount = 800;
  } else if ( $usertype == 10 || $usertype == 11 ) {
    $payment_amount = 600;
  } else if ( $usertype == 12 || $usertype == 13 ) {
    $payment_amount = 900;
  }
  $referral = '';
  if ( $usertype == 4 || $usertype == 6 || $usertype == 8 || $usertype == 10 || $usertype == 12 ) {
    $sql = 'select * from users where user_type_id = 2';
    $referral = DB::select( DB::raw( $sql ) )[ 0 ];
  }
  if ( $usertype == 5 || $usertype == 7 || $usertype == 9 || $usertype == 11 || $usertype == 13 ) {
    $sql = 'select * from users where user_type_id = 3';
    $referral = DB::select( DB::raw( $sql ) )[ 0 ];
  }
  return view( 'users/special_member_status_update', compact( 'payment_amount', 'id', 'status', 'referral', 'full_name','balance' ) );
}

public function specialmemberactivate( Request $request ) {
  $log_id = Auth::user()->id;
  $usertype = Auth::user()->user_type_id;
  $user_id = $request->user_id;
  $full_name = $request->full_name;
  $payment_amount = $request->payment_amount;
  $paydate = date( 'Y-m-d' );
  $time = date( 'H:i:s' );

  if ( $usertype == 12 || $usertype == 13 ) {
            //center
    $referral_id = Auth::user()->referral_id;
    $sql = "select user_type_id from users where id = $referral_id";
    $result = DB::select( DB::raw( $sql ) );
    $parent_usertype = $result[ 0 ]->user_type_id;
    if ( $parent_usertype == 4 || $parent_usertype == 5 ) {
                //district
      $to_id = $referral_id;
      $amount = 400;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 12 ) $to_id = 2;
      if ( $usertype == 13 ) $to_id = 3;
      $amount = 500;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
    if ( $parent_usertype == 6 || $parent_usertype == 7 ) {
      $to_id = $referral_id;
      $amount = 300;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      $sql = "select referral_id from users where id = $to_id";
      $result = DB::select( DB::raw( $sql ) );
      $to_id = $result[ 0 ]->referral_id;
      $amount = 300;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 12 ) $to_id = 2;
      if ( $usertype == 13 ) $to_id = 3;
      $amount = 500;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
    if ( $parent_usertype == 10 || $parent_usertype == 11 ) {
      $to_id = $referral_id;
      $amount = 200;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      $sql = "select referral_id from users where id = $to_id";
      $result = DB::select( DB::raw( $sql ) );
      $to_id = $result[ 0 ]->referral_id;
      $amount = 300;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 12 ) $to_id = 2;
      if ( $usertype == 13 ) $to_id = 3;
      $amount = 200;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
    if ( $parent_usertype == 8 || $parent_usertype == 9 ) {
      $to_id = $referral_id;
      $amount = 150;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      $sql = "select referral_id,user_type_id from users where id = $to_id";
      $result = DB::select( DB::raw( $sql ) );
      $to_id = $result[ 0 ]->referral_id;
      $utype = $result[ 0 ]->user_type_id;
      if ( $utype == 6 || $utype == 7 ) {
        $amount = 250;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
        $sql = "select referral_id from users where id = $to_id";
        $result = DB::select( DB::raw( $sql ) );
        $to_id = $result[ 0 ]->referral_id;
        $amount = 250;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
        if ( $usertype == 12 ) $to_id = 2;
        if ( $usertype == 13 ) $to_id = 3;
        $amount = 250;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
      }
      if ( $utype == 10 || $utype == 11 ) {
        $amount = 200;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
        $sql = "select referral_id from users where id = $to_id";
        $result = DB::select( DB::raw( $sql ) );
        $to_id = $result[ 0 ]->referral_id;
        $amount = 250;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
        if ( $usertype == 12 ) $to_id = 2;
        if ( $usertype == 13 ) $to_id = 3;
        $amount = 300;
        self::insert_payment( $amount, $to_id, $user_id, $full_name );
      }
    }
  }

  if ( $usertype == 8 || $usertype == 9 ) {
            //panchayath
    $referral_id = Auth::user()->referral_id;
    $sql = "select user_type_id from users where id = $referral_id";
    $result = DB::select( DB::raw( $sql ) );
    $parent_usertype = $result[ 0 ]->user_type_id;
    if ( $parent_usertype == 4 || $parent_usertype == 5 ) {
                //district
      $to_id = $referral_id;
      $amount = 400;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 8 ) $to_id = 2;
      if ( $usertype == 9 ) $to_id = 3;
      $amount = 400;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
    if ( $parent_usertype == 6 || $parent_usertype == 7 ) {
                //taluk
      $to_id = $referral_id;
      $amount = 200;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      $sql = "select referral_id from users where id = $to_id";
      $result = DB::select( DB::raw( $sql ) );
      $to_id = $result[ 0 ]->referral_id;
      $amount = 300;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 8 ) $to_id = 2;
      if ( $usertype == 9 ) $to_id = 3;
      $amount = 300;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
    if ( $parent_usertype == 10 || $parent_usertype == 11 ) {
                //block
      $to_id = $referral_id;
      $amount = 150;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      $sql = "select referral_id from users where id = $to_id";
      $result = DB::select( DB::raw( $sql ) );
      $to_id = $result[ 0 ]->referral_id;
      $amount = 250;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
      if ( $usertype == 8 ) $to_id = 2;
      if ( $usertype == 9 ) $to_id = 3;
      $amount = 400;
      self::insert_payment( $amount, $to_id, $user_id, $full_name );
    }
  }

  if ( $usertype == 10 || $usertype == 11 ) {
            //block
    $to_id = Auth::user()->referral_id;
    $amount = 300;
    self::insert_payment( $amount, $to_id, $user_id, $full_name );
    if ( $usertype == 10 ) $to_id = 2;
    if ( $usertype == 11 ) $to_id = 3;
    $amount = 300;
    self::insert_payment( $amount, $to_id, $user_id, $full_name );
  }

  if ( $usertype == 6 || $usertype == 7 ) {
            //taluk
    $to_id = Auth::user()->referral_id;
    $amount = 200;
    self::insert_payment( $amount, $to_id, $user_id, $full_name );
    if ( $usertype == 6 ) $to_id = 2;
    if ( $usertype == 7 ) $to_id = 3;
    $amount = 300;
    self::insert_payment( $amount, $to_id, $user_id, $full_name );
  }

  if ( $usertype == 4 || $usertype == 5 ) {
            //district
    $to_id = 0;
    if ( $usertype == 4 ) $to_id = 2;
    if ( $usertype == 5 ) $to_id = 3;
    $amount = 300;
    self::insert_payment( $amount, $to_id, $user_id, $full_name );
  }

  $sql = "update customers set status='Active' where id = $user_id";
  DB::update( DB::raw( $sql ) );

  return redirect( 'specialmembers' );
}

private function insert_payment( $amount, $to_id, $user_id, $full_name ) {
  $log_id = Auth::user()->id;
  $paydate = date( 'Y-m-d' );
  $time = date( 'H:i:s' );
  $ad_info = "Activation of Special Member $full_name SM$user_id";
  $service_status = 'Out Payment';
  $paydate = date( 'Y-m-d' );
  $time = date( 'H:i:s' );
  $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','nalavariyam')";
  DB::insert( DB::raw( $sql ) );
   $sql = "select username from users where id=$to_id ";
   $result =  DB::select( DB::raw( $sql ));
   $tousername = $result[0]->username;
  $sql = "update wallet_users set wallet = wallet + $amount,commission = commission + $amount where username = '$tousername'";
  DB::update( DB::raw( $sql ) );

  $service_status = 'In Payment';
  $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'nalavariyam')";
  DB::insert( DB::raw( $sql ) );
    $sql = "select username from users where id=$log_id ";
    $result =  DB::select( DB::raw( $sql ));
    $logusername = $result[0]->username;
  WalletHelper::debitWallet2($logusername,$amount);
  //$sql = "update users set wallet = wallet - $amount where id = $log_id";
  //DB::update( DB::raw( $sql ) );
}

public function addmember( Request $request )
{
  $aadhaar_no = trim( $request->aadhaar_no );
  $sql = "select * from customers where aadhaar_no = '$aadhaar_no'";
  $result = DB::select( DB::raw( $sql ) );
  if ( count( $result ) > 0 ) {
    return redirect()->back()->with( 'error', 'Duplicate aadhaar no' );
  }

  $user_id = Auth::user()->id;
  $dist_id = $request->dist_id;
  /*$sql = "Select * from district where id = $dist_id order by id";
  $result = DB::select( DB::raw( $sql ) );
  if ( count( $result ) > 0 ) {
    $districtid = $result[ 0 ]->districtid;
  }
  $uniqueId = rand( 111111111, 999999999 );
  $username = 'RJ' . $districtid . 'N' . $uniqueId;*/
  $addmember = DB::table( 'customers' )->insert( [
    'full_name' => $request->full_name,
    'password' => Hash::make( $request->password ),
    'pas' => $request->password,
    'work_two_id' => $request->work_two_id,
    'work_there_id' => $request->work_there_id,
    'dist_id' => $dist_id,
    'phone' => $request->phone,
    'permanent_door_no' => $request->permanent_door_no,
    'panchayath_id' => $request->panchayath_id,
    'street_name' => $request->street_name,
    'pincode' => $request->pincode,
    'aadhaar_no' => $request->aadhaar_no,
    'post_name' => $request->post_name,
    'registeration_no' => $request->registeration_no,
    'taluk_id' => $request->taluk_id,
    'email' => $request->email,
    'referral_id' => $user_id,
    'gender' => $request->gender,
    'user_type_id' => $request->user_type_id,
    'dob' => $request->dob,
    'status' => $request->status,
    'member_photo' => 'user.jpg',
    'log_id' => $user_id
  ] );
  $last_insert_id = DB::getPdo()->lastInsertId();
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
            $sql="insert into wallet_users (username) values ('$username')";
            DB::insert($sql);
             $sql = "update customers set username='$username' where id = $last_insert_id";
            DB::update(DB::raw( $sql ));

  if ( trim( $request->family_member_name ) != '' ) {
    $first_id = DB::table( 'family_member' )->insertGetId( [
      'customer_id' => $last_insert_id,
      'family_member_name' => $request->family_member_name,
      'family_relationship' => $request->family_relationship,
      'studying_course' => $request->studying_course,
      'family_dob' => $request->family_dob,
    ] );
    $second_id = '';
    if ( trim( $request->family_member_name2 ) != '' ) {
      $second_id = DB::table( 'family_member' )->insertGetId( [
        'customer_id' => $last_insert_id,
        'family_member_name' => $request->family_member_name2,
        'family_relationship' => $request->family_relationship2,
        'studying_course' => $request->studying_course2,
        'family_dob' => $request->family_dob2,
      ] );
    }
  }

        //  echo $aadhar;

  $profile = '';
  if ( $request->member_photo != null ) {
    $profile = $last_insert_id . '.' . $request->file( 'member_photo' )->extension();
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'member_photo' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'member_photo' ][ 'tmp_name' ], $filepath . $profile );
  }

  $addimg = DB::table( 'customers' )->where( 'id', $last_insert_id )->update( [
    'member_photo' => $profile,

  ] );

  return redirect()->back()->with( 'success', 'Add Member Successfully ... !' );
}

public function addmemberdocument( Request $request ) {
  $doc_name = $request->doc_name;
  $customer_id = $request->customer_id;
  $sql = "insert into customer_documents (customer_id,doc_name) values ($customer_id,'$doc_name')";
  DB::insert( DB::raw( $sql ) );
  $last_insert_id = DB::getPdo()->lastInsertId();
  if ( $request->file_name != null ) {
    $file_name = $last_insert_id . '.' . $request->file( 'file_name' )->extension();
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'document' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'file_name' ][ 'tmp_name' ], $filepath . $file_name );
    $sql = "update customer_documents set file_name='$file_name' where id=$last_insert_id";
    DB::update( DB::raw( $sql ) );
  }
  return redirect()->back()->with( 'success', 'Document uploaded successfully' );
}

public function addfamily( $id )
{
  $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
  $managetaluk = DB::table( 'taluk' )->where( 'status', '=', 1 )->orderBy( 'id', 'Asc' )->get();
  $managepanchayath = DB::table( 'panchayath' )->where( 'status', '=', 1 )->orderBy( 'id', 'Asc' )->get();
  $manageuser_type = DB::table( 'user_type' )->orderBy( 'id', 'Asc' )->get();
  $userdata = DB::table( 'users' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
  $work_two = DB::table( 'work_two' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
  $work_there = DB::table( 'work_there' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
  $sql = "select * from customers where id = $id";
  $members = DB::select( DB::raw( $sql ) );
  $members = json_decode( json_encode( $members ), true );
  foreach ( $members as $key1 => $member ) {
    $customer_id = $member[ 'id' ];
    $sql_details = "select family_member_name,family_dob,family_relationship,studying_course from family_member where customer_id = $customer_id order by id";
    $details = DB::select( DB::raw( $sql_details ) );
    $family_member_name = '';
    $family_relationship = '';
    $studying_course = '';
    $family_dob = '';
    $family_member_name2 = '';
    $family_relationship2 = '';
    $studying_course2 = '';
    $family_dob2 = '';
    if ( count( $details ) > 0 ) {
      foreach ( $details as $key2 => $det ) {
        if ( $key2 == 0 ) {
          $family_member_name = $det->family_member_name;
          $family_relationship = $det->family_relationship;
          $studying_course = $det->studying_course;
          $family_dob = $det->family_dob;
        }
        if ( $key2 == 1 ) {
          $family_member_name2 = $det->family_member_name;
          $family_relationship2 = $det->family_relationship;
          $studying_course2 = $det->studying_course;
          $family_dob2 = $det->family_dob;
        }
      }
    }
    $members[ $key1 ][ 'family_member_name' ] = $family_member_name;
    $members[ $key1 ][ 'family_relationship' ] = $family_relationship;
    $members[ $key1 ][ 'studying_course' ] = $studying_course;
    $members[ $key1 ][ 'family_dob' ] = $family_dob;
    $members[ $key1 ][ 'family_member_name2' ] = $family_member_name2;
    $members[ $key1 ][ 'family_relationship2' ] = $family_relationship2;
    $members[ $key1 ][ 'studying_course2' ] = $studying_course2;
    $members[ $key1 ][ 'family_dob2' ] = $family_dob2;
  }
  $members = json_decode( json_encode( $members ) );
  $sql = "select count(id) as countmember from family_member where customer_id='$id'";
  $result = DB::select( DB::raw( $sql ) );
  if ( count( $result ) > 0 ) {
    $countmember = $result[ 0 ]->countmember;
  }
  $sql = "Select * from family_member where customer_id='$id'";
  $familymember = DB::select( DB::raw( $sql ) );
  $customers_id = $id;
  return view( 'customers/addfamily', compact( 'managedistrict', 'managetaluk', 'managepanchayath', 'manageuser_type', 'userdata', 'work_two', 'work_there', 'members', 'members', 'countmember', 'familymember', 'customers_id' ) );

}

public function goto( $id )
{
  $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
  $managetaluk = DB::table( 'taluk' )->where( 'status', '=', 1 )->orderBy( 'id', 'Asc' )->get();
  $managepanchayath = DB::table( 'panchayath' )->where( 'status', '=', 1 )->orderBy( 'id', 'Asc' )->get();
  $manageuser_type = DB::table( 'user_type' )->orderBy( 'id', 'Asc' )->get();
  $userdata = DB::table( 'users' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
  $work_two = DB::table( 'work_two' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
  $work_there = DB::table( 'work_there' )->where( 'status', '=', '1' )->orderBy( 'id', 'Asc' )->get();
  $sql = "select * from customers where id = $id";
  $members = DB::select( DB::raw( $sql ) );
  $members = json_decode( json_encode( $members ), true );
  foreach ( $members as $key1 => $member ) {
    $customer_id = $member[ 'id' ];
    $sql_details = "select family_member_name,family_dob,family_relationship,studying_course from family_member where customer_id = $customer_id order by id";
    $details = DB::select( DB::raw( $sql_details ) );
    $family_member_name = '';
    $family_relationship = '';
    $studying_course = '';
    $family_dob = '';
    $family_member_name2 = '';
    $family_relationship2 = '';
    $studying_course2 = '';
    $family_dob2 = '';
    if ( count( $details ) > 0 ) {
      foreach ( $details as $key2 => $det ) {
        if ( $key2 == 0 ) {
          $family_member_name = $det->family_member_name;
          $family_relationship = $det->family_relationship;
          $studying_course = $det->studying_course;
          $family_dob = $det->family_dob;
        }
        if ( $key2 == 1 ) {
          $family_member_name2 = $det->family_member_name;
          $family_relationship2 = $det->family_relationship;
          $studying_course2 = $det->studying_course;
          $family_dob2 = $det->family_dob;
        }
      }
    }
    $members[ $key1 ][ 'family_member_name' ] = $family_member_name;
    $members[ $key1 ][ 'family_relationship' ] = $family_relationship;
    $members[ $key1 ][ 'studying_course' ] = $studying_course;
    $members[ $key1 ][ 'family_dob' ] = $family_dob;
    $members[ $key1 ][ 'family_member_name2' ] = $family_member_name2;
    $members[ $key1 ][ 'family_relationship2' ] = $family_relationship2;
    $members[ $key1 ][ 'studying_course2' ] = $studying_course2;
    $members[ $key1 ][ 'family_dob2' ] = $family_dob2;
  }
  $members = json_decode( json_encode( $members ) );
  $sql = '';
  if ( $members[ 0 ]->user_type_id == 14 ) {
    $sql = 'select id,username,full_name from users where user_type_id in (2,4,6,8,10,12)';
  }
  if ( $members[ 0 ]->user_type_id == 15 ) {
    $sql = 'select id,username,full_name from users where user_type_id in (3,5,7,9,11,13)';
  }
  $referral = DB::select( DB::raw( $sql ) );
        //echo '<pre>';
  $sql = "select count(id) as countmember from family_member where customer_id='$id'";
  $result = DB::select( DB::raw( $sql ) );
  if ( count( $result ) > 0 ) {
    $countmember = $result[ 0 ]->countmember;
  }
  $sql = "Select * from family_member where customer_id='$id'";
  $familymember = DB::select( DB::raw( $sql ) );
  $customers_id = $id;
    $authdistrict_id = Auth::user()->dist_id;
  $authdistrict = DB::table( 'district' )->where( 'id', '=', $authdistrict_id )->get();
//   echo'<pre>';print_r( $members );echo'</pre>';die;
  return view( 'customers/goto', compact( 'managedistrict', 'managetaluk', 'managepanchayath', 'manageuser_type', 'userdata', 'work_two', 'work_there', 'members', 'members', 'countmember', 'familymember', 'customers_id', 'referral','authdistrict' ) );

}

public function gotomembers( Request $request )
{
  $user_id = Auth::user()->id;
  $user_type_id = $request->move_as;
  $referral_id = $request->referral;
  $updatemembers = DB::table( 'customers' )->where( 'id', $request->id )->update( [
    'user_type_id' => $user_type_id,
    'work_two_id' => $request->work_two_id,
    'work_there_id' => $request->work_there_id,
    'dist_id' => $request->dist_id,
    'phone' => $request->phone,
    'permanent_door_no' => $request->permanent_door_no,
    'panchayath_id' => $request->panchayath_id,
    'street_name' => $request->street_name,
    'pincode' => $request->pincode,
    'aadhaar_no' => $request->aadhaar_no,
    'post_name' => $request->post_name,
    'registeration_no' => $request->registeration_no,
    'taluk_id' => $request->taluk_id,
    'dob' => $request->dob,
    'gender' => $request->gender,
    'status' => 'Inactive',
    'log_id' => $user_id
  ] );
  $customer_id = $request->id;
  if ( Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3 ) {
    $sql = "update customers set referral_id=$referral_id where id = $customer_id";
    DB::update( DB::raw( $sql ) );
  }


  $profile = '';
  if ( !empty( $_FILES[ 'member_photo' ][ 'name' ] ) ) {
    $profile = $customer_id . '.' . pathinfo( $_FILES[ 'member_photo' ][ 'name' ], PATHINFO_EXTENSION );
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'member_photo' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'member_photo' ][ 'tmp_name' ], $filepath . $profile );
    $sql = "update customers set member_photo='$profile' where id = $customer_id";
    DB::update( DB::raw( $sql ) );
  }
  $ration = '';
  if ( !empty( $_FILES[ 'rationfile' ][ 'name' ] ) ) {
    $ration = $customer_id . '.' . pathinfo( $_FILES[ 'rationfile' ][ 'name' ], PATHINFO_EXTENSION );
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'ration_card' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'rationfile' ][ 'tmp_name' ], $filepath . $ration );
    $sql = "update customers set rationfile='$ration' where id = $customer_id";
    DB::update( DB::raw( $sql ) );
  }

  if ( $user_type_id == 18 || $user_type_id == 19 ) {
    return redirect( '/members' )->with( 'success', 'Customer moved as member successfully' );
  } else {
    return redirect( '/specialmembers' )->with( 'success', 'Customer moved as special member successfully' );
  }
}

public function gotospmember( Request $request )
{
  $id = $request->user_id5;
  $user_type_id = $request->user_type_id5;
  $referral_id = $request->referral_id5;
  $updatemembers = DB::table( 'customers' )->where( 'id', $id )->update( [
    'user_type_id' => $user_type_id,
    'referral_id' => $referral_id,
    'status' => 'Inactive'
  ] );
  return redirect( '/specialmembers' )->with( 'success', 'Member moved as special member successfully' );
}

public function updatepassword( $customer_id ) {
    $pas = '12345678';
    $password = Hash::make( $pas );
    $sql = "update customers set pas='$pas',password = '$password' where id=$customer_id";
    DB::update( DB::raw( $sql ) );
    return redirect()->back()->with( 'success', 'Password Reset successfully ' );
}

public function updatemembers( $id )
{
  $user_id = Auth::user()->id;
  $updatemembers = DB::table( 'customers' )->where( 'id', $request->id )->update( [
    'full_name' => $request->full_name,
    'work_two_id' => $request->work_two_id,
    'work_there_id' => $request->work_there_id,
    'dist_id' => $request->dist_id,
    'phone' => $request->phone,
    'permanent_door_no' => $request->permanent_door_no,
    'panchayath_id' => $request->panchayath_id,
    'street_name' => $request->street_name,
    'pincode' => $request->pincode,
    'aadhaar_no' => $request->aadhaar_no,
    'post_name' => $request->post_name,
    'registeration_no' => $request->registeration_no,
    'taluk_id' => $request->taluk_id,
    'dob' => $request->dob,
    'gender' => $request->gender,
    'log_id' => $user_id
  ] );
  $customer_id = $request->id;
  $sql = "delete from family_member where customer_id = $customer_id";
  DB::delete( DB::raw( $sql ) );
  if ( trim( $request->family_member_name ) != '' ) {
    $first_id =  DB::table( 'family_member' )->insertGetid( [
      'customer_id' => $customer_id,
      'family_member_name' => $request->family_member_name,
      'family_relationship' => $request->family_relationship,
      'studying_course' => $request->studying_course,
      'family_dob' => $request->family_dob,
    ] );
  }
  if ( trim( $request->family_member_name2 ) != '' ) {
    $second_id =  DB::table( 'family_member' )->insertGetid( [
      'customer_id' => $customer_id,
      'family_member_name' => $request->family_member_name2,
      'family_relationship' => $request->family_relationship2,
      'studying_course' => $request->studying_course2,
      'family_dob' => $request->family_dob2,
    ] );
  }


  $profile = '';
  if ( !empty( $_FILES[ 'member_photo' ][ 'name' ] ) ) {
    $profile = $customer_id . '.' . pathinfo( $_FILES[ 'member_photo' ][ 'name' ], PATHINFO_EXTENSION );
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'member_photo' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'member_photo' ][ 'tmp_name' ], $filepath . $profile );
    $sql = "update customers set member_photo='$profile' where id = $customer_id";
    DB::update( DB::raw( $sql ) );
  }
  $ration = '';
  if ( !empty( $_FILES[ 'rationfile' ][ 'name' ] ) ) {
    $ration = $customer_id . '.' . pathinfo( $_FILES[ 'rationfile' ][ 'name' ], PATHINFO_EXTENSION );
    $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'ration_card' . DIRECTORY_SEPARATOR );
    move_uploaded_file( $_FILES[ 'rationfile' ][ 'tmp_name' ], $filepath . $ration );
    $sql = "update customers set rationfile='$ration' where id = $customer_id";
    DB::update( DB::raw( $sql ) );
  }

  return redirect( '/members' )->with( 'success', 'Edit Members Successfully ... !' );
}

public function addfamilymember( Request $request )
{
  $first_id = DB::table( 'family_member' )->insertGetId( [
    'customer_id' => $request->customer_id,
    'family_member_name' => $request->family_member_name,
    'family_relationship' => $request->family_relationship,
    'studying_course' => $request->studying_course,
    'family_dob' => $request->family_dob,
    'academic_year' => $request->academic_year,
  ] );

        /*$aadharone = '';
        if ( $request->childone_aadhaar_file != null ) {
            $aadharone = $first_id . '.' . $request->file( 'childone_aadhaar_file' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'childaadhaar' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'childone_aadhaar_file' ][ 'tmp_name' ], $filepath . $aadharone );
        }
        $addimg = DB::table( 'family_member' )->where( 'id', $first_id )->update( [
            'childone_aadhaar_file' => $aadharone,
        ] );
        */

        return redirect()->back()->with( 'success', 'Add Member Successfully ... !' );
      }

      public function updatefamilymember( Request $request )
      {
        //dd( $request->all() );
        $updatefamilymember = DB::table( 'family_member' )->where( 'id', $request->family_id )->update( [
          'customer_id' => $request->customer_id,
          'family_member_name' => $request->family_member_name,
          'family_relationship' => $request->family_relationship,
          'studying_course' => $request->studying_course,
          'family_dob' => $request->family_dob,
          'academic_year' => $request->academic_year,
        ] );

        /*$aadharone = '';
        if ( $request->childone_aadhaar_file != null ) {
            $aadharone = $request->family_id . '.' . $request->file( 'childone_aadhaar_file' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'childaadhaar' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'childone_aadhaar_file' ][ 'tmp_name' ], $filepath . $aadharone );
        }
        $addimg = DB::table( 'family_member' )->where( 'id', $request->family_id )->update( [
            'childone_aadhaar_file' => $aadharone,
        ] );
        */

        return redirect()->back()->with( 'success', 'Update Edit Member Successfully ... !' );
      }

      public function gettaluk( Request $request )
      {
        $gettaluk = DB::table( 'taluk' )->where( 'parent', $request->taluk_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $gettaluk );
      }

      public function memberstatus( Request $request )
      {

        $memberstatus = DB::table( 'customers' )->where( 'id', $request->userid )->update( [
          'status'              => $request->status,
        ] );

        return redirect()->back()->with( 'success', 'Status Updated Successfully ... !' );
      }

      public function specialmemberstatus( Request $request )
      {

        $specialmemberstatus = DB::table( 'customers' )->where( 'id', $request->userid )->update( [
          'status'              => $request->status,
        ] );

        return redirect()->back()->with( 'success', 'Status Updated Successfully ... !' );
      }

      public function getpanchayath( Request $request ) {
        $getpanchayath = DB::table( 'panchayath' )->where( 'parent', $request->panchayath_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $getpanchayath );
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

      public function get_sub_work_there( Request $request )
      {
        $get_sub_work_there = DB::table( 'work_there' )->where( 'parent', $request->work_two_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $get_sub_work_there );
      }
    }
