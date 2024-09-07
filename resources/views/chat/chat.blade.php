@extends('layouts.use_chat_app')
@section('content')
  
  <div class="page-content-wrapper py-3" id="chat-wrapper">
    <div class="container">
      <div class="chat-content-wrap" id="messagediv">
        @php
        $type = "";
        $chat = "";
        foreach($messages as $msg){
            $body = $msg->body;
            $time = $msg->time;
            $full_name = $msg->full_name;
            $user_photo = $msg->user_photo;
            $time = date("h:i A",strtotime(substr($time,11,5)));
            if($msg->sender == $sender){
                $type = " outgoing";
            }else{
                $type = "";
            }
            echo "<div class='single-chat-item".$type."'><div class='user-message'><div class='message-content'><div class='single-message'><p>".$body."</p></div></div><div class='message-time-status'><div class='sent-time'>".$time."</div></div></div></div>";
        }
        @endphp
        <br/>
      </div>
  </div>

  <div class="chat-footer">
    <div class="container h-100">
      <div class="chat-footer-content h-100 d-flex align-items-center">
        <form>
          {{ csrf_field() }}
          <input type="hidden" id="recvId" name="recvId" value="{{ $recvId }}">
          <input type="hidden" id="sender" name="sender" value="{{ Auth::user()->id }}">
          <input class="form-control" id="message" name="message" type="text" placeholder="Type here...">
          <a id="sendmessage" class="btn btn-primary" ><i class="bi bi-cursor"></i></a>
        </form>
      </div>
    </div>
  </div>
@endsection