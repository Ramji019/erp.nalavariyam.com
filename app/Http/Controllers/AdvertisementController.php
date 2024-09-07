<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertisementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function advertisement()
    {
      if((Auth::user()->user_type_id == '1') || (Auth::user()->user_type_id == '2') || (Auth::user()->user_type_id == '3')){ 
         
      } else {
         return redirect( 'dashboard' );
     }
     
     if(Auth::user()->pas == '12345678'){

         return redirect('/changepassword');
     }
     $advertisement = DB::table('advertisement')->orderBy('id', 'Asc')->get();
     $managedistrict = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
     $managetaluk = DB::table('taluk')->where('status', '=', 1)->orderBy('id', 'Asc')->get();
     $managepanchayath = DB::table('panchayath')->where('status', '=', 1)->orderBy('id', 'Asc')->get();
     $position[1]="Welcome";
     $position[2]="Login Header";
     $position[3]="Login Footer";
     $position[4]="Login Left";
     $position[5]="Login Right";
     return view('advertisement/index', compact('advertisement','managedistrict','managetaluk','managepanchayath','position'));
 }

 public function addadvertisement(Request $request)
 {
    $addadvertisement = DB::table('advertisement')->insert([
        'company_name' => $request->company_name,
        'company_details' => $request->company_details,
        'company_url' => $request->company_url,
        'add_from_date' => $request->add_from_date,
        'add_to_date' => $request->add_to_date,
        'add_location' => $request->add_location,
        'add_type' => $request->add_type,
        'district_id' => $request->dist_id,
        'taluk_id' => $request->taluk_id,
        'panchayath_id' => $request->panchayath_id,
        'status' => 'Active' 
    ]);
    $last_insert_id = DB::getPdo()->lastInsertId();
    $advertisementimg = "user.jpg";
    if ($request->add_image != null) {
      $advertisementimg = $last_insert_id . '.' . $request->file('add_image')->extension();
      $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'advertise' . DIRECTORY_SEPARATOR);
      move_uploaded_file($_FILES['add_image']['tmp_name'], $filepath . $advertisementimg);
  }
  $addimg = DB::table('advertisement')->where('id', $last_insert_id)->update([
      'add_image' => $advertisementimg,

  ]);

  return redirect()->back()->with('success', 'Add Advertisement Successfully ... !');
}

public function editadvertisement(Request $request)
{
    
    $editadvertisement = DB::table('advertisement')->where('id',$request->id)->update([
      'company_name' => $request->company_name,
      'company_details' => $request->company_details,
      'company_url' => $request->company_url,
      'add_from_date' => $request->add_from_date,
      'add_to_date' => $request->add_to_date,
      'add_location' => $request->add_location,
      'add_type' => $request->add_type,
      'district_id' => $request->dist_id,
      'taluk_id' => $request->taluk_id,
      'panchayath_id' => $request->panchayath_id,
      'status' => $request->status,
  ]);

    $id = $request->id;
    if ($request->add_image != null) {
      $fromimage = $id . '.' . $request->file('add_image')->extension();
      $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'advertise' . DIRECTORY_SEPARATOR);
      move_uploaded_file($_FILES['add_image']['tmp_name'], $filepath . $fromimage);
  }
  if($request->add_image == ""){
   return redirect()->back()->with('success', 'Notification Updated Successfully ... !');
}
else{
   $addimg = DB::table('advertisement')->where('id', $id)->update([
      'add_image' => $fromimage,
  ]);
}


return redirect()->back()->with('success', 'Edit Advertisement Successfully ... !');
}

public function deleteadvertisement($id){
  
    $deleteadvertisement = DB::table('advertisement')->where('id',$id)->delete();

    return redirect()->back()->with('success', 'Notification Deleted Successfully... !');
}

}

