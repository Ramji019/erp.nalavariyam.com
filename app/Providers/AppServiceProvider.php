<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
/**
* Register any application services.
*
* @return void
*/

public function register()
{
    $managedistrict = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
    return view('auth/login',compact('managedistrict'));
}

/**
* Bootstrap any application services.
*
* @return void
*/
public $uniondata;
public $unionusers;
public $msgcount;
public $referencedata;
public $onlinestatus_menu;

public function boot()
{   
    view()->composer('layouts.header', function ($view) 
    {
        $this->msgcount = 0;
        $uid = Auth::user()->id;
        $sql = "select count(*) as msgcount from messages where recvId=$uid and status=0";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $this->msgcount = $result[0]->msgcount;
        }

        $dist_id = Auth::user()->dist_id;
//echo $dist_id;die;
        if ( Auth::user()->user_type_id == 16 ) {
            $group_id = '2';
        } elseif ( Auth::user()->user_type_id == 17 ) {

            $group_id = '3';
        } elseif ( Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 6 || Auth::user()->user_type_id == 8 || Auth::user()->user_type_id == 10 || Auth::user()->user_type_id == 12 ) {
            $group_id = '4';
        } elseif ( Auth::user()->user_type_id == 5 || Auth::user()->user_type_id == 7 || Auth::user()->user_type_id == 9 || Auth::user()->user_type_id == 11 || Auth::user()->user_type_id == 13 ) {
            $group_id = '5';
        }

        $sql = "SELECT a.signature_name,a.e_form_date,a.signature_name,a.signature_phone ,a.full_name FROM dist_signature a,users b where a.user_id=b.id
        and a.dist_id = $dist_id and a.signature_date in (SELECT max(signature_date) FROM dist_signature where dist_id = $dist_id) limit 1";
		//echo  $sql;die;
        $this->unionusers = DB::select( DB::raw( $sql ) );
        $fav=0;

        $sql = '';
        if ( Auth::user()->user_type_id == 1 ) {
            $sql = "Select * from `users` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( Auth::user()->user_type_id == 2 ) {
            $sql = "Select * from `users` where `id` = '1' order by `id` desc limit 1 ";
        } else if ( Auth::user()->user_type_id == 3 ) {
            $sql = "Select * from `users` where `id` = '1' order by `id` desc limit 1 ";
        } else {
            $referral_id = Auth::user()->referral_id;
            $sql = "Select * from `users` where `id` = $referral_id order by `id` desc limit 1 ";

        }
        $this->referencedata = DB::select( DB::raw( $sql ) );


//echo "<pre>"; print_r($this->unionusers);  echo "</pre>";die;
        $view->with(['unionusers' => $this->unionusers,'uniondata' => $this->uniondata,'msgcount' => $this->msgcount,'referencedata' => $this->referencedata]);  



    });  

    view()->composer('layouts.sidebar', function ($view) 
    {

        $this->onlinestatus_menu = DB::table( 'payments' )->select( 'online_status_id')->whereNotNull('online_status_id')->distinct('online_status_id')->orderBy( 'online_status_id', 'Asc' )->get();
        $view->with(['onlinestatus_menu' => $this->onlinestatus_menu]);  
    });  

}





}
