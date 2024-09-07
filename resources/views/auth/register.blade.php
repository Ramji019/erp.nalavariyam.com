<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Registration Page</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{!! asset('plugins/select2/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}">

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form method="post" action="{{ route('register') }}">
                @csrf


                <div class="input-group mb-3">
                     <select class="form-control select2" name="dist_id" id="dist_id"
                                        style="width: 100%;" required="required">
                                        <option value="">Select District Name</option>
                                        @foreach ($managedistrict as $district)
                                            <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                        @endforeach
                                    </select>
                                    
                </div>

                <div class="input-group mb-3">
                    <select class="form-control select2" name="taluk_id" id="taluk"
                    style="width: 100%;" required="required">
                    <option value="">Select Taluk Name</option>
                  
                </select>
                </div>

                <div class="input-group mb-3">
                    <select class="form-control select2" name="panchayath_id" id="panchayath"
                    style="width: 100%;" required="required">
                    <option value="">Select Panchayath Name</option>
                
                </select>
                </div>

                <div class="input-group mb-3" id="hideusertype">
                    <select class="form-control select2" name="user_type_id" id="centerid"
                    style="width: 100%;" required="required">
                    <option value="">Select Usertype</option>
                
                </select>
                </div>

                
                <div class="input-group mb-3">
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           placeholder="Mobile Number">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="text"
                           name="aadhaar_no"
                           value="{{ old('aadhaar_no') }}"
                           class="form-control @error('aadhaar_no') is-invalid @enderror"
                           placeholder="Aadhaar Number">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('aadhaar_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <input type="hidden" value="{{ $referral_id }}" name="referral_id" />
                <input type="hidden" value="{{ $usertype }}" id="usertype" />
                @if($referral_id == 0)
                <span class="text-danger input-group mb-2 font-weight-bold">Please Check Your Referral Link</span>
                @endif

                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" id="regsubmit" @if($referral_id == 0) disabled @endif class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{ route('welcome') }}" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->

    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="{{ mix('js/app.js') }}" defer></script>
<script src="{!! asset('plugins/jquery/jquery.min.js') !!}"></script>
<!-- Bootstrap -->
<script src="{!! asset('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<script src="{!! asset('plugins/select2/js/select2.full.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script>
$('.select2').select2({
    theme: 'bootstrap4'
  });

  $('#dist_id').on('change', function () {
                var idTaluk = this.value;
                $("#taluk").html('');
                $.ajax({
                    url: "{{url('/gettalukfront')}}",
                    type: "POST",
                    data: {
                        taluk_id: idTaluk,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
                        $.each(result, function (key, value) {
                            $("#taluk").append('<option value="' + value
                                .id + '">' + value.taluk_name + '</option>');
                        });
                        $('#panchayath').html('<option value="">-- Select Panchayath --</option>');
                    }   
                });
            });
			
			$('#taluk').on('change', function () {
                var idPanchayath = this.value;
                $("#panchayath").html('');
                $.ajax({
                    url: "{{url('/getpanchayathfront')}}",
                    type: "POST",
                    data: {
                        panchayath_id: idPanchayath,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#panchayath').html('<option value="">-- Select Taluk Name --</option>');
                        $.each(result, function (key, value) {
                            $("#panchayath").append('<option value="' + value
                                .id + '">' + value.panchayath_name +'</option>');
                        });
                    }   
                });
            });
			
           
            $('#panchayath').on('change', function () {
                var centerid = this.value;
                $("#centerid").html('');
                $("#hideusertype").show();
                $("#regsubmit").prop('disabled', false);
                $.ajax({
                    url: "{{url('/getcenterfront')}}",
                    type: "POST",
                    data: {
                        centerid: centerid,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        
                       var usertype = $("#usertype").val();
                        $('#centerid').html('<option value="">-- Select UserType --</option>');
                        if(result.length == 0 && usertype == 4 || usertype == 6 || usertype == 8 || usertype == 10){
                                $("#centerid").append('<option value="' + 12 + '">' + 'Center President' + '</option>');
                            }else if(result.length == 0 && usertype == 5 || usertype == 7 || usertype == 9 || usertype == 11){
                                $("#centerid").append('<option value="' + 13 + '">' + 'Center Secretary' + '</option>');
                            }else if(result.length == 2){
                                $("#hideusertype").hide();
                                $("#regsubmit").prop('disabled', true);
                                alert("All Posts are  already Taken . Please Check Other Panchayath");
                                return false;
                            }
                        $.each(result, function (key, value) {
                            if(value.user_type_id == 12 && usertype == 4 || usertype == 6 || usertype == 8 || usertype == 10){
                                $("#hideusertype").hide();
                                $("#regsubmit").prop('disabled', true);
                                alert("Center President Post is already Taken . Please Check Other Panchayath");
                                return false;
                            }else if(value.user_type_id == 12 && usertype == 5 || usertype == 7 || usertype == 9 || usertype == 11){
                                $("#centerid").append('<option value="' + 13 + '">' + 'Center Secratary' + '</option>');
                            }else if(value.user_type_id == 13  && usertype == 4 || usertype == 6 || usertype == 8 || usertype == 10){
                                $("#centerid").append('<option value="' + 12 + '">' + 'Center President' + '</option>');
                            }else if(value.user_type_id == 13 && usertype == 5 || usertype == 7 || usertype == 9 || usertype == 11){
                                $("#hideusertype").hide();
                                $("#regsubmit").prop('disabled', true);
                                alert("Center Secretarty Post is already Taken . Please Check Other Panchayath");
                                return false;
                            }
                        });
                    }   
                });
            });
			

  </script>
</body>
</html>
