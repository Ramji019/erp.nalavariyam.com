<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notification()
    {

      if((Auth::user()->user_type_id == '1') || (Auth::user()->user_type_id == '2') || (Auth::user()->user_type_id == '3')){ 
   
      } else {
       return redirect( 'dashboard' );
       }

        $notification = DB::table('notification')->orderBy('id', 'Asc')->get();
        return view('notification/index', compact('notification'));
    }

    public function addnotification(Request $request)
    {
        $addnotification = DB::table('notification')->insert([
            'user_type' => $request->user_type,
            'notification_name' => $request->notification_name,
            'notification_details' => $request->notification_details,
            'notification_img' => $request->notification_img,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'status' => '1'
        ]);

    $last_insert_id = DB::getPdo()->lastInsertId();
    $notificationimg = "user.jpg";
    if ($request->notification_img != null) {
      $notificationimg = $last_insert_id . '.' . $request->file('notification_img')->extension();
      $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'notification_img' . DIRECTORY_SEPARATOR);
      move_uploaded_file($_FILES['notification_img']['tmp_name'], $filepath . $notificationimg);
    }
    $addimg = DB::table('notification')->where('id', $last_insert_id)->update([
      'notification_img' => $notificationimg,

    ]);

        return redirect()->back()->with('success', 'Add Notification Successfully ... !');
    }
    public function editnotification(Request $request)
    {
        
        $editnotification = DB::table('notification')->where('id',$request->id)->update([
        'user_type' => $request->user_type,
        'notification_name' => $request->notification_name,
        'notification_details' => $request->notification_details,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'status' => $request->status
      ]);
        

    $id = $request->id;
    if ($request->notification_img != null) {
      $fromimage = $id . '.' . $request->file('notification_img')->extension();
      $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'notification_img' . DIRECTORY_SEPARATOR);
      move_uploaded_file($_FILES['notification_img']['tmp_name'], $filepath . $fromimage);
    }
    if($request->notification_img == ""){
     return redirect()->back()->with('success', 'Notification Updated Successfully ... !');
   }
   else{
     $addimg = DB::table('notification')->where('id', $id)->update([
      'notification_img' => $fromimage,
    ]);
   }

   return redirect()->back()->with('success', 'Notification Updated Successfully ... !');
 }

    public function deletenotification($id){
              
            $deletenotification = DB::table('notification')->where('id',$id)->delete();

      return redirect()->back()->with('success', 'Notification Deleted Successfully... !');
    }


}

