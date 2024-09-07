<?php 
namespace App;
use Illuminate\Support\Facades\DB;
class WalletHelper
{
    public static function debitWallet2($username,$amount)
    {
        $sql="select wallet,commission,deposit from wallet_users where username='$username'";
        $result = DB::select($sql);
        if(count($result)>0){
            $wallet = $result[0]->wallet;
            $commission = $result[0]->commission;
            $deposit = $result[0]->deposit;
            if($commission >= $amount){
                $sql = "update wallet_users set wallet = wallet - $amount,commission = commission - $amount where username = '$username'";
                DB::update( DB::raw( $sql ) );
            }else{
                $deposit_debit = 0;
                $commision_debit = 0;
                $deposit_debit = $amount - $commission;
                $commision_debit = $amount - $deposit_debit;
                $sql = "update wallet_users set wallet = wallet - $amount,commission = commission - $commision_debit,deposit = deposit - $deposit_debit where username = '$username'";
                DB::update( DB::raw( $sql ) );
            }
        }
    }

    public static function debitWallet($userid,$amount)
    {
        $sql="select wallet,commission,deposit from users where id=$userid";
        $result = DB::select($sql);
        if(count($result)>0){
            $wallet = $result[0]->wallet;
            $commission = $result[0]->commission;
            $deposit = $result[0]->deposit;
            if($commission >= $amount){
                $sql = "update users set wallet = wallet - $amount,commission = commission - $amount where id = $userid";
                DB::update( DB::raw( $sql ) );
            }else{
                $deposit_debit = 0;
                $commision_debit = 0;
                $deposit_debit = $amount - $commission;
                $commision_debit = $amount - $deposit_debit;
                $sql = "update users set wallet = wallet - $amount,commission = commission - $commision_debit,deposit = deposit - $deposit_debit where id = $userid";
                DB::update( DB::raw( $sql ) );
            }
        }
    }

    public static function wallet_balance($username){
        $balance  = 0;
        $sql = "SELECT * FROM wallet_users where username='$username'";
        $result = DB::select($sql);
            if(count($result) > 0){
                $balance = $result[0]->wallet;
            }
        return $balance;
    }

}