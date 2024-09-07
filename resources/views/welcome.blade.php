<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">


</head>

<body>


    <style>
        body {
            text-align: center;
            text-transform: uppercase;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    @foreach ($loginheader as $loginheaderlist)
                        <div class="w3-content w3-section">
                            <a href="{{ url($loginheaderlist->company_url) }}">
                                <img width="1125" height="190" align="center" class="mySlidesheader"
                                    src="{{ URL::to('/') }}/upload/advertise/{{ $loginheaderlist->add_image }}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="card">
                  @foreach ($loginleft as $loginleftlist)
                        <div class="w3-content w3-section" style="max-width:500px">
                            <a href="{{ url($loginleftlist->company_url) }}">
                                <img class="mySlidesleft"
                                    src="{{ URL::to('/') }}/upload/advertise/{{ $loginleftlist->add_image }}"
                                    style="width:100%">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="card bg-info">
                    <ul class="nav nav-pills nav-fill mb-1" id="pills-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" id="pills-signin-tab" data-toggle="pill"
                                onclick="showlogin()" role="tab" aria-controls="pills-signin"
                                aria-selected="true">Admin Login</a> </li>
                        <li class="nav-item"> <a class="nav-link" id="pills-signup-tab" data-toggle="pill"
                                onclick="showregister()" role="tab" aria-controls="pills-signup"
                                aria-selected="false">Member Login</a> </li>
                    </ul>

                    <div style="display: none;" class="tab-pane" id="pills-signup" role="tabpanel"
                        aria-labelledby="pills-signup-tab">
                        <div class="col-sm-12 border-primary shadow rounded pt-2">
                            <div class="container">
                                <p class="login-box-msg">Member Login</p>
                                <p class="text-center text-danger">{{ session('message') }} </p>
                                <form method="post" action="{{ url('/checklogin') }}">
                                    @csrf
                                    <input type="hidden" name="device_id" id="deviceid">
                                    <div class="input-group mb-3">
                                        <input type="text" name="registeration_no" placeholder="Registration No"
                                            class="form-control">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input name="password" type="password" maxlength="20" class="form-control">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-8">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="remember">
                                                <label for="remember">Remember Me</label>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign
                                                In</button>
												</br>
                                        </div>

                                    </div>
                                </form>

                                <p class="mb-1">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-signin" role="tabpanel"
                            aria-labelledby="pills-signin-tab">
                            <div class="container">
                                <p class="login-box-msg">Admin Login</p>
                                <p class="text-center text-danger">{{ session('message') }} </p>
                                <form method="post" action="{{ url('/login') }}">
                                    @csrf
                                    <input type="hidden" name="device_id" id="device_id">
                                    <div class="input-group mb-3">
                                        <input type="text" name="username" placeholder="username"
                                            class="form-control">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="password" name="password" placeholder="Password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="row">
                                        <div class="col-8">
                                            <a href="{{ url('password/reset') }}">I forgot my password</a>
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-warning btn-block">Sign
                                                In</button>
												</br>
                                        </div>
                                    </div>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="card">
                    @foreach ($loginright as $loginrightlist)
                        <div class="w3-content w3-section" style="max-width:500px">
                            <a href="{{ url($loginrightlist->company_url) }}">
                                <img class="mySlides"
                                    src="{{ URL::to('/') }}/upload/advertise/{{ $loginrightlist->add_image }}"
                                    style="width:100%">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    @foreach ($loginfooter as $loginfooterlist)
                        <div class="w3-content w3-section">
                            <a href="{{ url($loginfooterlist->company_url) }}">
                                <img width="1125" height="190" align="center" class="mySlidesfooter"
                                    src="{{ URL::to('/') }}/upload/advertise/{{ $loginfooterlist->add_image }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showimage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($welcome as $welcomelist)
                        <div style="text-align:center" class="w3-content w3-section">
                            <img width="430" height="300" align="center" class="mySlideswelcome"
                                src="{{ URL::to('/') }}/upload/advertise/{{ $welcomelist->add_image }}">
                        </div>
                    @endforeach


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    </div>
    <script src="{!! asset('plugins/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script>
        @if (count($welcome) > 0)
            $("#showimage").modal("show");
        @endif
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js"></script>
    <script>

        var firebaseConfig = {
            apiKey: "AIzaSyDOCQyOUapH4HxLKZZS6Mk2La2EURl22Ak",
            authDomain: "aypt-b20e4.firebaseapp.com",
            projectId: "aypt-b20e4",
            storageBucket: "aypt-b20e4.appspot.com",
            messagingSenderId: "19421078519",
            appId: "1:19421078519:web:4eb17253f6cac1bd3344f2"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function IntitalizeFireBaseMessaging() {
            messaging
                .requestPermission()
                .then(function() {
                    console.log("Notification Permission");
                    return messaging.getToken();
                })
                .then(function(token) {
                    console.log("Token : " + token);
                    $("#device_id").val(token);
                })
                .catch(function(reason) {
                    console.log(reason);
                });
        }

        messaging.onMessage(function(payload) {
            console.log(payload);
            const notificationOption = {
                body: payload.notification.body,
                icon: payload.notification.icon
            };

            if (Notification.permission === "granted") {
                var notification = new Notification(payload.notification.title, notificationOption);

                notification.onclick = function(ev) {
                    ev.preventDefault();
                    window.open(payload.notification.click_action, '_blank');
                    notification.close();
                }
            }

        });
        messaging.onTokenRefresh(function() {
            messaging.getToken()
                .then(function(newtoken) {
                    console.log("New Token : " + newtoken);
                })
                .catch(function(reason) {
                    console.log(reason);
                    alert(reason);
                })
        })
        IntitalizeFireBaseMessaging();


        function showlogin() {
            $("#pills-signup-tab").removeClass("active");
            $("#pills-signup").slideUp();
            $("#pills-signin-tab").addClass("active");
            $("#pills-signin").slideDown();
        }

        function showregister() {
            $("#pills-signin-tab").removeClass("active");
            $("#pills-signin").slideUp();
            $("#pills-signup-tab").addClass("active");
            $("#pills-signup").slideDown();
        }
    </script>
    <script>
        var myIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1
            }
            x[myIndex - 1].style.display = "block";
            setTimeout(carousel, 5000);
        }

        var myIndexleft = 0;
        carouselleft();

        function carouselleft() {
            var i;
            var x = document.getElementsByClassName("mySlidesleft");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexleft++;
            if (myIndexleft > x.length) {
                myIndexleft = 1
            }
            x[myIndexleft - 1].style.display = "block";
            setTimeout(carouselleft, 5000);
        }

        var myIndexfooter = 0;
        carouselfooter();

        function carouselfooter() {
            var i;
            var x = document.getElementsByClassName("mySlidesfooter");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexfooter++;
            if (myIndexfooter > x.length) {
                myIndexfooter = 1
            }
            x[myIndexfooter - 1].style.display = "block";
            setTimeout(carouselfooter, 5000);
        }

        var myIndexheader = 0;
        carouselheader();

        function carouselheader() {
            var i;
            var x = document.getElementsByClassName("mySlidesheader");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexheader++;
            if (myIndexheader > x.length) {
                myIndexheader = 1
            }
            x[myIndexheader - 1].style.display = "block";
            setTimeout(carouselheader, 5000);
        }

        var myIndexwelcome = 0;
        carouselwelcome();

        function carouselwelcome() {
            var i;
            var x = document.getElementsByClassName("mySlideswelcome");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexwelcome++;
            if (myIndexwelcome > x.length) {
                myIndexwelcome = 1
            }
            x[myIndexwelcome - 1].style.display = "block";
            setTimeout(carouselwelcome, 5000);
        }
    </script>
</body>

</html>
