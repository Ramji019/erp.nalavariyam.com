<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function districts()
    {

    	$districts = DB::table('district')->where('status', '=', 'Active')->orderBy('id', 'Asc')->get();

    	return view('districts/districts', compact('districts'));
    }

    public function adddistricts(Request $request)
    {
    	$adddistricts = DB::table('district')->insert([
    		'district_name' => $request->district_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Add District Successfully ... !');
    } 

    public function editdistricts(Request $request)
    {

        $editdistricts = DB::table('district')->where('id',$request->districts_id)->update([
    		'district_name' => $request->district_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Edit District Successfully ... !');
    } 

    public function deletedistricts($id){
              $deletedistricts = DB::table('district')->where('id',$id)->delete();

              return redirect('/districts')->with('success', 'District Deleted Successfully... !');
            }

    public function taluk($district_id)
    {
    	$taluk = DB::table('taluk')->where('parent', '=', '$district_id')->orderBy('id', 'Asc')->get();
    	$managedistrict = DB::table('district')->orderBy('id', 'Asc')->get();
    	$sql="select * from taluk where parent = $district_id";
    	$taluk = DB::select(DB::raw($sql));
    	return view('districts/taluk', compact('taluk','district_id','managedistrict'));
    }

    public function addtaluk(Request $request)
    {
    	$addtaluk = DB::table('taluk')->insert([
    		'parent' => $request->parent,
    		'taluk_name' => $request->taluk_name,
    		'status' => '1'
    	]);
    	return redirect()->back()->with('success', 'Add Taluk Successfully ... !');
    } 

		public function edittaluk(Request $request)
    {

        $edittaluk = DB::table('taluk')->where('id',$request->taluk_id)->update([
    		'taluk_name' => $request->taluk_name,
    		'parent' => $request->parent,
    	]);
    	return redirect()->back()->with('success', 'Edit Taluk Successfully ... !');
    }

    public function deletetaluk($id){
              
      		$deletetaluk = DB::table('taluk')->where('id',$id)->delete();

      return redirect()->back()->with('success', 'Taluk Deleted Successfully... !');
    }

    public function panchayath($taluk_id)
    {
    	$managetaluk = DB::table('taluk')->orderBy('id', 'Asc')->get();
    	$sql="select * from panchayath where parent = $taluk_id";
    	$panchayath = DB::select(DB::raw($sql));
    	return view('districts/panchayath', compact('panchayath','taluk_id','managetaluk'));
    }

    public function addpanchayath(Request $request)
    {
    	$addtaluk = DB::table('panchayath')->insert([
    		'parent' => $request->parent,
    		'panchayath_name' => $request->panchayath_name,
    		'status' => '1'
    	]);
    	return redirect()->back()->with('success', 'Add Panchayath Successfully ... !');
    } 

public function editpanchayath(Request $request)
    {

        $editpanchayath = DB::table('panchayath')->where('id',$request->panchayath_id)->update([
    		'panchayath_name' => $request->panchayath_name,
    		'parent' => $request->parent,

    	]);
    	return redirect()->back()->with('success', 'Edit Panchayath Successfully ... !');
    }

    public function deletepanchayath($id){
              
            $deletepanchayath = DB::table('panchayath')->where('id',$id)->delete();

      return redirect()->back()->with('success', 'Panchayath Deleted Successfully... !');
    }

    public function signature(){
		
     $user_type_id = array( '4', '5' );
     $user_id = Auth::user()->id;
     if(Auth::user()->user_type_id ==1 || Auth::user()->user_type_id ==4 || Auth::user()->user_type_id ==5){
		if(Auth::user()->user_type_id == 1){
          $distsignature = DB::table('dist_signature')->select( 'dist_signature.*', 'district.district_name', 'dist_signature.id as dist_signature_id' )
			->Join( 'district', 'district.id', '=','dist_signature.dist_id' )->get();
		}else {
          $distsignature = DB::table('dist_signature')->select( 'dist_signature.*', 'district.district_name', 'dist_signature.id as dist_signature_id' )
			->Join( 'district', 'district.id', '=','dist_signature.dist_id' )
			->where('dist_signature.user_id',$user_id)->get();
		}
			//print_r($distsignature);die;
            $distusers = DB::table('users')
			->whereIn('user_type_id',$user_type_id)->get();

	}else {
		return redirect('dashboard');
	}	 
    	return view('districts/signature', compact('distsignature','distusers'));
    }
	
	public function editdistrictsignature(Request $request)
    {
		$row_id = $request->row_id;
        $editdistrictssignature = DB::table('dist_signature')->where('id',$row_id)->update([
    		'user_id'        => $request->user_id,
    		'e_form_date'    => $request->e_form_date,
    		'full_name'      => $request->full_name,
    		'signature_phone'=> $request->signature_phone,
    		'signature_date' => date('Y-m-d'),
    	]);
		
		 $signature_name = '';
        if ( $request->signature_name != null ) {
            $signature_name = $row_id.'.'.$request->file( 'signature_name' )->extension();

            $filepath = public_path( 'upload'.DIRECTORY_SEPARATOR.'off'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'signature_name' ][ 'tmp_name' ], $filepath.$signature_name );
            $sql = "update dist_signature set signature_name='$signature_name' where id = $row_id";
            DB::update( DB::raw( $sql ) );
        }
		
    	return redirect()->back()->with('success', 'Update District Signature Successfully ... !');
    }
  }