<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
public function chatusers()
    {
        if(Auth::user()->id == 1){
            $user_id = 0;
        }elseif(Auth::user()->id == 2 || Auth::user()->id== 3){
            $user_id = 1;
        }else{
            $user_id = Auth::user()->referral_id;
        }
        $referral_id = Auth::user()->id;
        $sql = "select id,full_name,user_photo,phone from users where id = $user_id or id=1";
        $upline = DB::select(DB::raw($sql));
        $upline = json_decode(json_encode($upline), true);
        foreach ($upline as $key1 => $up) {
            $recvId = $up["id"];
            $sql = "select count(*) as msgcount from messages where sender=$recvId and status=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $msgcount = $result[0]->msgcount;
            }
            $upline[$key1]["msgcount"] = $msgcount;
            if($msgcount > 0){
                $upline = collect($upline)->sortBy('msgcount')->reverse()->toArray();
            }

        }
        $upline = json_decode(json_encode($upline));
        if(Auth::user()->id == 1){
            $sql = "select id,full_name,user_photo,phone from users";
        }else{
            $sql = "select id,full_name,user_photo,phone from users where referral_id=$referral_id";
        }
        $downline = DB::select(DB::raw($sql));
        $downline = json_decode(json_encode($downline), true);
        foreach ($downline as $key1 => $down) {
            $recvId = $down["id"];
            $sql = "select count(*) as msgcount from messages where sender=$recvId and status=0";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $msgcount = $result[0]->msgcount; 
            }
            $downline[$key1]["msgcount"] = $msgcount;
            if($msgcount > 0){
                $downline = collect($downline)->sortBy('msgcount')->reverse()->toArray();
            }
        }
        $downline = json_decode(json_encode($downline));
      return view('chat.index',compact('downline','upline'));
    }
	
    public function chat($recvId){
        $sender = Auth::user()->id;
        $sql = "update messages set status=1 where sender=$recvId and status=0";
        DB::update(DB::raw($sql));
        $sql = "select full_name,user_photo from users where id in ($recvId)";
        $result = DB::select(DB::raw($sql));
        $recv_name = $result[0]->full_name;
        $recv_photo = $result[0]->user_photo;
        if($sender == 1){
            $sql = "select a.*,b.full_name,b.user_photo from messages a,users b where a.sender=b.id and a.status=0 order by time";
        }else{
        $sql = "select a.*,b.full_name,b.user_photo from messages a,users b where a.sender=b.id and sender in ($sender,$recvId) and recvId in ($sender,$recvId) order by time";
    }

        $messages = DB::select(DB::raw($sql));
            return view('chat.chat',compact('messages','recvId','sender','recv_name','recv_photo'));
    }

    public function userchat(Request $request){
        $last_message_id = 0;
        $sender = Auth::user()->id;
        $recvId = $request->recvId;
        $message = $request->message;
        $sql = "insert into messages (sender,recvId,body) values ($sender,$recvId,'$message')";
        DB::insert(DB::raw($sql));
        $sql = "select a.*,b.full_name,b.user_photo from messages a,users b where a.sender=b.id and sender in ($sender,$recvId) and recvId in ($sender,$recvId) order by time";
        $messages = DB::select(DB::raw($sql));
        $type = "";
        $chat = "";
        foreach($messages as $msg){
            $last_message_id = $msg->id;
            $body = $msg->body;
            $time = $msg->time;
            $name = $msg->full_name;
            $time = date("h:i A",strtotime(substr($time,11,5)));
            if($msg->sender == $sender){
                $type = " outgoing";
            }else{
                $type = "";
            }
            $chat = $chat."<div class='single-chat-item".$type."'><div class='user-message'><div class='message-content'><div class='single-message'><p>".$body."</p></div></div><div class='message-time-status'><div class='sent-time'>".$time."</div></div></div></div>";
        }
        echo $chat."<br/>";
    }

    public function getchat($recvId){
        $last_message_id = 0;
        $sender = Auth::user()->id;
        $sql = "select a.*,b.full_name,b.user_photo from messages a,users b where a.sender=b.id and sender in ($sender,$recvId) and recvId in ($sender,$recvId) order by time";
        $messages = DB::select(DB::raw($sql));
        $type = "";
        $chat = "";
        foreach($messages as $msg){
            $last_message_id = $msg->id;
            $body = $msg->body;
            $time = $msg->time;
            $full_name = $msg->full_name;
            $time = date("h:i A",strtotime(substr($time,11,5)));
            if($msg->sender == $sender){
                $type = " outgoing";
            }else{
                $type = "";
            }
            $chat = $chat."<div class='single-chat-item".$type."'><div class='user-message'><div class='message-content'><div class='single-message'><p>".$body."</p></div></div><div class='message-time-status'><div class='sent-time'>".$time."</div></div></div></div>";
        }
        echo $chat."<br/>";
    }
}

