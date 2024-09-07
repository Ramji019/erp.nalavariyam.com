@extends('layouts.app')
@section('content')
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Edit Users</h1>
</div>
</div>
</div>
</section>
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
        <a href="#" style="color:white !important" class="close" data-dismiss="alert"
            aria-label="close">&times;</a>
        <strong> {{ session('success') }} </strong>
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
        <a href="#" style="color:white !important" class="close" data-dismiss="alert"
            aria-label="close">&times;</a>
        <strong> {{ session('error') }} </strong>
    </div>
@endif
@foreach ($editusers as $user)
    <form action="{{ url('/updateuser') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <input type="hidden" name="id" value="{{ $user->id }}" />
            <div class="col-md-6">
                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                    <div class="form-group">
                        <label>District Name</label>
                        <select class="form-control select2" name="dist_id" id="dist_id"
                            style="width: 100%;">
                            <option value="">Select District Name</option>
                            @foreach ($managedistrict as $district)
                                <option {{ $user->dist_id == $district->id ? 'selected' : '' }}
                                    value="{{ $district->id }}">{{ $district->district_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Taluk Name</label>
                        <select class="form-control select2" name="taluk_id" id="taluk"
                            style="width: 100%;">
                            <option value="{{ $user->taluk_id }}">{{ $user->taluk_id }}
                                Taluk ID
                            </option>   
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Panchayath Name</label>
                        <select class="form-control select2" name="panchayath_id"
                            id="panchayath" style="width: 100%;">
                            <option value="{{ $user->panchayath_id }}">{{ $user->panchayath_id }}
                                Panchayath ID
                            </option>                          
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Referral User</label>
                        <select class="form-control select2" name="referral_id"
                            style="width: 100%;">
                            <option value="{{ $user->referral_id }}">{{ $user->referral_id }}
                                ReferralID
                            </option>
                            @foreach ($userdata as $userdatalist)
                                <option
                                    {{ $user->referral_id == $userdatalist->id ? 'selected' : '' }}
                                    value="{{ $userdatalist->id }}">{{ $userdatalist->id }}
                                    -->{{ $userdatalist->full_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select class="form-control select2" name="user_type_id"
                            style="width: 100%;">
                            @foreach ($manageuser_type as $manageusertype)
                                <option
                                    {{ $user->user_type_id == $manageusertype->id ? 'selected' : '' }}
                                    value="{{ $manageusertype->id }}">
                                    {{ $manageusertype->group_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aadhaar_no">Aadhaar No</label>
                        <input onkeyup="duplicateaadhar(0)"  value="{{ $user->aadhaar_no }}" type="text" maxlength="12" class="form-control number" name="aadhaar_no" id="aadhar" placeholder="Enter Aadhaar Number">
                        <span id="dupaadhar" style="color:red"></span>
                    </div>
                @elseif(Auth::user()->user_type_id == 4 ||
                        Auth::user()->user_type_id == 5 ||
                        Auth::user()->user_type_id == 6 ||
                        Auth::user()->user_type_id == 7 ||
                        Auth::user()->user_type_id == 8 ||
                        Auth::user()->user_type_id == 9 ||
                        Auth::user()->user_type_id == 10 ||
                        Auth::user()->user_type_id == 11 ||
                        Auth::user()->user_type_id == 12 ||
                        Auth::user()->user_type_id == 13 ||
                        Auth::user()->user_type_id == 16 ||
                        Auth::user()->user_type_id == 17)
                    <input type="hidden" name="aadhaar_no" value="{{ $user->aadhaar_no }}" />
                    <input type="hidden" name="user_type_id" value="{{ $user->user_type_id }}" />
                    <input type="hidden" name="referral_id" value="{{ $user->referral_id }}" />
                    <input type="hidden" name="dist_id" value="{{ $user->dist_id }}" />
                    <input type="hidden" name="taluk_id" value="{{ $user->taluk_id }}" />
                    <input type="hidden" name="panchayath_id"
                        value="{{ $user->panchayath_id }}" />
                @endif
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" value="{{ $user->full_name }}"
                        name="full_name" id="full_name" placeholder="Enter Full Name">
                </div>
                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 ||
                        Auth::user()->user_type_id == 3 ||
                        Auth::user()->user_type_id == 16 ||
                        Auth::user()->user_type_id == 17)
                    <div class="form-group row">
                        <label for="signature_owner" class="col-sm-4 col-form-label"><span
                                style="color:red"></span>Signature Owner</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="signature_owner"
                                id="signature_owner" maxlength="50"
                                placeholder="Signature Owner"
                                value="{{ $user->signature_owner }}">
                        </div>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="e_form_date"
                                id="e_form_date" placeholder="eForm Date"
                                value="{{ $user->e_form_date }}">
                        </div>
                    </div>
                @else
                    <input type="hidden" name="signature_owner"
                        value="{{ $user->signature_owner }}" />
                    <input type="hidden" name="e_form_date"
                        value="{{ $user->e_form_date }}" />
                @endif
                <div class="form-group row">
                    <label for="phone" class="col-sm-4 col-form-label"><span
                            style="color:red"></span>Mobile Number</label>
                    <div class="col-sm-4">
                        @if (Auth::user()->user_type_id == 16 || Auth::user()->user_type_id == 17)
                            <input type="hidden" name="phone"
                                value="{{ $user->phone }}" onkeyup="duplicatephone(0)"  maxlength="10">
                     <span id="dupmobile" style="color:red"></span>
                        @else
                            <input type="text" class="form-control" name="phone"
                                id="phone" maxlength="50" placeholder="Mobile Number"
                                value="{{ $user->phone }}" onkeyup="duplicatephone(0)"  maxlength="10">
                     <span id="dupmobile" style="color:red"></span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 ||
                                Auth::user()->user_type_id == 3 ||
                                Auth::user()->user_type_id == 16 ||
                                Auth::user()->user_type_id == 17)
                            <input type="text" class="form-control" name="signature_phone"
                                id="signature_phone" maxlength="50"
                                placeholder="Signature Phone"
                                value="{{ $user->signature_phone }}" onkeyup="duplicatephone(0)"  maxlength="13">
                     <span id="dupmobile" style="color:red"></span>
                        @else
                            <input type="hidden" name="signature_phone"
                                value="{{ $user->signature_phone }}" onkeyup="duplicatephone(0)"  maxlength="13">
                     <span id="dupmobile" style="color:red"></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if (Auth::user()->user_type_id == 16 || Auth::user()->user_type_id == 17)
                    <input type="hidden" name="email" value="{{ $user->email }}" />
                @else
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input value="{{ $user->email }}" onkeyup="duplicateemail(0)"
                            type="email" class="form-control" name="email"
                            id="email" placeholder="Enter email">
                        <span id="dupemail" style="color:red"></span>
                    </div>
                @endif
                <div class="form-group">
                    <label for="full_name">Gender</label>
                    <div class="radio">
                        <label>
                            Select
                            <label>
                                <label>
                                    <input @if ($user->gender == 1) checked @endif
                                        type="radio" name="gender" id="male"
                                        value="1">
                                    Male
                                </label>
                                <label>
                                    <input @if ($user->gender == 2) checked @endif
                                        type="radio" name="gender" id="female"
                                        value="2">
                                    Female
                                </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="permanent_address_1" class="col-sm-4 col-form-label"><span
                            style="color:red"></span>Contact Address</label>
                    <div class="col-sm-8">
                        <textarea rows="3" type="text" class="form-control" name="permanent_address_1" id="permanent_address_1"
                            maxlength="250" placeholder="Contact Address">{{ $user->permanent_address_1 }}</textarea>
                    </div>
                </div>
                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 ||
                        Auth::user()->user_type_id == 3 ||
                        Auth::user()->user_type_id == 16 ||
                        Auth::user()->user_type_id == 17)
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control select2" name="status"
                            style="width: 100%;">
                            <option {{ $user->status == 'Active' ? 'selected' : '' }}
                                value="Active">Active</option>
                            <option {{ $user->status == 'Inactive' ? 'selected' : '' }}
                                value="Inactive">Inactive</option>
                        </select>
                    </div>
                @elseif(Auth::user()->user_type_id == 4 ||
                        Auth::user()->user_type_id == 5 ||
                        Auth::user()->user_type_id == 6 ||
                        Auth::user()->user_type_id == 7 ||
                        Auth::user()->user_type_id == 8 ||
                        Auth::user()->user_type_id == 9 ||
                        Auth::user()->user_type_id == 10 ||
                        Auth::user()->user_type_id == 11 ||
                        Auth::user()->user_type_id == 12 ||
                        Auth::user()->user_type_id == 13)
                    <input type="hidden" name="status" value="{{ $user->status }}" />
                @endif
                <div class="form-group row">
                    <label for="photo" class="col-sm-4 col-form-label"><span
                            style="color:red"></span>Profile Photo</label>
                    <div class="col-sm-8">
                        <input type="file" name="photo" accept="image/png, image/jpeg">
                    </div>
                </div>
                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 4 ||
                        Auth::user()->user_type_id == 2 ||
                        Auth::user()->user_type_id == 3 ||
                        Auth::user()->user_type_id == 4 ||
                        Auth::user()->user_type_id == 5 ||
                        Auth::user()->user_type_id == 16 ||
                        Auth::user()->user_type_id == 17)
                    <div class="form-group row">
                        <label for="signature2" class="col-sm-4 col-form-label"><span
                                style="color:red"></span>Signature Upload</label>
                        <div class="col-sm-8">
                            <input type="file" name="signature2" accept="image/png, image/jpeg"><br /><br />
                            <img style="width:200px" src="{{ URL::to('/') }}/upload/off/{{ $user->signature2 }}" />
                            <span id="signature2" style="color:red"></span>
                        </div>
                    </div>
                @elseif(Auth::user()->user_type_id == 6 ||
                        Auth::user()->user_type_id == 7 ||
                        Auth::user()->user_type_id == 8 ||
                        Auth::user()->user_type_id == 9 ||
                        Auth::user()->user_type_id == 10 ||
                        Auth::user()->user_type_id == 11 ||
                        Auth::user()->user_type_id == 12 ||
                        Auth::user()->user_type_id == 13)
                    <input type="hidden" name="signature2"
                        value="{{ $user->signature2 }}" />
                @endif
                   @if (Auth::user()->user_type_id == 1)
                 <div class="form-group">
                     <div class="custom-control custom-checkbox">
                         <input @if($user->tailoring_user == 1) checked @endif class="custom-control-input" name="tailoring_user" type="checkbox" id="customCheckbox1" value="0">
                         <label for="customCheckbox1" class="custom-control-label">Allow Add Tailoring Users</label>
                                </div>
                                </div>
                                @else
                                 <input type="hidden" name="signature2"
                        value="{{ $user->tailoring_user }}" />
                                @endif
            </div>
        </div>
            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <input id="save" class="btn btn-info" type="submit" name="submit"
                        value="Submit" />
                    <a href="" class="btn btn-info">Back</a>
                </div>
            </div>
@endforeach
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
@push('page_scripts')
<script>
  $('#dist_id').on('change', function () {
                var idTaluk = this.value;
                $("#taluk").html('');
                $.ajax({
                    url: "{{url('/gettaluk')}}",
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
			
			
        $('#taluk').on('change', function() {
            var taluk_id = this.value;
            $("#panchayath").html('');
            var url = "{{ url('/getpanchayathlimit') }}/" + taluk_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $('#panchayath').html('<option value="">-- Select Panchayath Name --</option>');
                    $.each(result, function(key, value) {
                        $("#panchayath").append('<option value="' + value
                            .id + '">' + value.panchayath_name + '</option>');
                    });
                }
            });
        });
    </script>
 
@endpush
