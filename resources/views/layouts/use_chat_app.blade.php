<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> 
  <title>{{ config('app.name') }}</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

   <link rel="icon" href="{!! asset('chat/img/core-img/logo.png') !!}">
  <link rel="apple-touch-icon" href="{!! asset('chat/img/icons/icon-96x96.png') !!}">
  <link rel="apple-touch-icon" sizes="152x152" href="{!! asset('chat/img/icons/icon-152x152.png') !!}">
  <link rel="apple-touch-icon" sizes="167x167" href="{!! asset('chat/img/icons/icon-167x167.png') !!}">
  <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('chat/img/icons/icon-180x180.png') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/bootstrap.min.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/bootstrap-icons.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/tiny-slider.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/venobox.min.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/rangeslider.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/vanilla-dataTables.min.css') !!}">
  <link rel="stylesheet" href="{!! asset('chat/css/apexcharts.css') !!}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Style CSS -->
  <link rel="stylesheet" href="{!! asset('chat/style.css') !!}">

  <!-- Web App Manifest -->
  <link rel="manifest" href="{!! asset('chat/manifest.json') !!}">
  
  
  @yield('third_party_stylesheets')

  @stack('page_css')
</head>
<body>
<div id="preloader">
    <div class="spinner-grow text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- Internet Connection Status -->
  <div class="internet-connection-status" id="internetStatus"></div>


  @include('layouts.chat_header')
  @include('layouts.menu')


  @yield('content')
  

@yield('third_party_scripts')


<script src="{!! asset('plugins/jquery/jquery.min.js') !!}"></script>
  <script src="{!! asset('chat/js/bootstrap.bundle.min.js') !!}"></script>
  <script src="{!! asset('chat/js/slideToggle.min.js') !!}"></script>
  <script src="{!! asset('chat/js/internet-status.js') !!}"></script>
  <script src="{!! asset('chat/js/tiny-slider.js') !!}"></script>
  <script src="{!! asset('chat/js/venobox.min.js') !!}"></script>
  <script src="{!! asset('chat/js/countdown.js') !!}"></script>
  <script src="{!! asset('chat/js/rangeslider.min.js') !!}"></script>
  <script src="{!! asset('chat/js/vanilla-dataTables.min.js') !!}"></script>
  <script src="{!! asset('chat/js/index.js') !!}"></script>
  <script src="{!! asset('chat/js/imagesloaded.pkgd.min.js') !!}"></script>
  <script src="{!! asset('chat/js/isotope.pkgd.min.js') !!}"></script>
  <script src="{!! asset('chat/js/dark-rtl.js') !!}"></script>
  <script src="{!! asset('chat/js/active.js') !!}"></script>
  
<script>



$('#message').on("keypress", function(e) {
  if(e.keyCode == 13) {
      sendmessages();
      return false;
  }
});

$('#sendmessage').click(function(){
  sendmessages();
});

function sendmessages(){
  var recvId = $("#recvId").val().trim();
  var sender = $("#sender").val().trim();
  var message = $("#message").val().trim();
  if(message != ""){
      $.ajax({
          url: "{{url('/userchat')}}",
          type: "POST",
          data: {
              recvId: recvId,
              sender: sender,
              message: message,
              _token: '{{csrf_token()}}'
          },
          success: function (result) {
            $("#messagediv").html(result);
            $("#message").val("");
            $("#message").focus();
            document.getElementById('chat-wrapper').scrollIntoView({ behavior: 'smooth', block: 'end' });
          },
          error: function (error) {  
              console.log(JSON.stringify(error));
          }
      });
  }
}

setInterval(getmessages, 10000);

function getmessages(){
  var recvId = $("#recvId").val().trim();
  var sender = $("#sender").val().trim();
  $.ajax({
      url: "{{url('/getchat')}}/"+recvId,
      type: "GET",
      success: function (result) {
        $("#messagediv").html(result);
        document.getElementById('messagediv').scrollIntoView({ behavior: 'smooth', block: 'end' });
      },
      error: function (error) {  
          console.log(JSON.stringify(error));
      }
  });
}

function showlogin(){
  $("#pills-signup-tab").removeClass("active");
  $("#pills-signup").hide();
  $("#pills-signin-tab").addClass("active");
  $("#pills-signin").show();
}
function showregister(){
  $("#pills-signin-tab").removeClass("active");
  $("#pills-signin").hide();
  $("#pills-signup-tab").addClass("active");
  $("#pills-signup").show();
}

$('#loginsubmit').click(function(){
    var email = $("#logemail").val().trim();
    $("#errormessage").html("");
    if(email == ""){
        $("#errormessage").html("Please enter Email or chat No");
        $("#logemail").focus();
    }else if($("#logpassword").val().trim() == ""){
        $("#errormessage").html("Please enter Password");
        $("#logpassword").focus();
    }else{
        var email = $("#logemail").val().trim();
        var password = $("#logpassword").val().trim();
        $.ajax({
            url: "{{url('/checkLogin')}}",
            type: "POST",
            data: {
                email: email,
                password: password,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                console.clear();
                console.log(result);
                if(result.status == "fail"){
                  $("#errormessage").html("IInvalid Login Credentials");
                }else if(result.status == "success"){
                  window.location.href = "{{ url('user/dashboard') }}";
                }
            },
            error: function (error) {  
                console.log(JSON.stringify(error));
            }
        });
    }
});

$('#regsubmit').click(function(){
        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        var email = $("#selleremail").val().trim();
        $("#reqname").html("");
        $("#reqemail").html("");
        $("#reqpassword").html("");
        $("#reqphone").html("");
        $("#reqplan").html("");
        if($("#sellername").val().trim() == ""){
            $("#reqname").html("Please enter Full Name");
            $("#sellername").focus();
        }else if(email == ""){
            $("#reqemail").html("Please enter email");
            $("#selleremail").focus();
        }else if(!pattern.test(email)){
            $("#reqemail").html("Invalid email address");
            $("#selleremail").focus();
        }else if($("#sellerpassword").val().trim() == ""){
            $("#reqpassword").html("Please enter password");
            $("#sellerpassword").focus();
        }else if($("#sellerphone").val().trim() == ""){
            $("#reqphone").html("Please enter chat no");
            $("#sellerphone").focus();
        }else{
            
            var chat = $("#sellerphone").val().trim();
            var name = $("#sellername").val().trim();
            var password = $("#sellerpassword").val().trim();
            var otpgenerated = $("#otpgenerated").val().trim();
            var otp = "";
            if(otpgenerated == 1){
                otp = $("#otp1").val()+$("#otp2").val()+$("#otp3").val()+$("#otp4").val();
            }
            $.ajax({
                url: "{{url('/generateotp')}}",
                type: "POST",
                data: {
                    email: email,
                    chat: chat,
                    name: name,
                    password: password,
                    otpgenerated: otpgenerated,
                    otp: otp,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    if(result.status == "fail" && result.status_type == "1"){
                        $("#reqemail").html(result.message);
                    }else if(result.status == "fail" && result.status_type == "2"){
                        $("#reqphone").html(result.message);
                    }else if(result.status == "fail" && result.status_type == "3"){
                        $("#reqotp").html(result.message);
                    }else if(result.status == "success" && result.status_type == "1"){
                        $("#otpdiv").show();
                        $("#selleremail").attr("readonly",true);
                        $("#sellerphone").attr("readonly",true);
                        $("#otpgenerated").val("1");
                    }else if(result.status == "success" && result.status_type == "2"){
                        window.location.href = '/user/dashboard';
                    }
                },
                error: function (error) {  
                    //console.log(JSON.stringify(error));
                }
            });
        }
    });

    $(".inputs").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(this).next('.inputs').focus();
        }
    });    
    $('.number').keypress(function(event) {
        var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 39 || (keycode >=
                48 && keycode <= 57)))) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
