@extends('mobile/layouts.use_chat_app')
@section('mobile/content')

  <div class="page-content-wrapper py-3" id="chat-wrapper">
    <div class="container">
      <div class="chat-content-wrap" id="messagediv">
        <!-- Single Chat Item -->
        <div class="single-chat-item" >

          <!-- <div class="user-avatar mt-1">
            <span class="name-first-letter">A</span>
            <img src="img/bg-img/2.jpg" alt="">
          </div> -->

          <div class="user-message">
            <div class="message-content">
              <div class="single-message">
                <p>Hello, Are you there?</p>
              </div>
            </div>
            <!-- <div class="message-time-status">
              <div class="sent-time">11:39 AM</div>
            </div> -->
          </div>
        </div>

        <div class="single-chat-item outgoing">
          <!-- <div class="user-avatar mt-1">
            <span class="name-first-letter">A</span>
            <img src="img/bg-img/user3.png" alt="">
          </div>-->
          <div class="user-message">
            <div class="message-content">
              <div class="single-message">
                <p>Yes, How can I help you?</p>
              </div>
            </div>
            <!-- <div class="message-time-status">
              <div class="sent-time">11:46 AM</div>
              <div class="sent-status seen">
                <i class="bi bi-check"></i>
              </div>
            </div>
          </div>-->
        </div>
      </div>


    </div>
  </div>

  <div class="chat-footer">
    <div class="container h-100">
      <div class="chat-footer-content h-100 d-flex align-items-center">
        <form method="post" >
          {{ csrf_field() }}
          <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
          <input type="hidden" id="sender" name="sender" value="{{ Auth::user()->id }}">
          <input class="form-control" id="message" name="message" type="text" placeholder="Type here...">
          <input id="sendmessage" class="btn btn-primary" type="button" value="Send" >
            <!-- <i class="bi bi-cursor"></i> -->
        </form>
      </div>
    </div>
  </div>
@endsection