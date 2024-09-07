@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
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
                            @foreach ($profile as $key => $pro)
                                <form action="{{ url('/updateprofile') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $pro->id }}" />
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="full_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Full Name</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="full_name" id="full_name" maxlength="50"
                                                        placeholder="Full Name" value="{{ $pro->full_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="aadhaar_no" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Aadhaar No</label>
                                                <div class="col-sm-8">
                                                    <input readonly required="requiered" type="text" class="form-control"
                                                        name="aadhaar_no" id="aadhaar_no" maxlength="50"
                                                        placeholder="Aadhaar No" value="{{ $pro->aadhaar_no }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Mobile Number</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="phone" id="phone" maxlength="50"
                                                        placeholder="Mobile Number" value="{{ $pro->phone }}"
                                                        onkeyup="duplicatephone(0)" maxlength="10">
                                                    <span id="dupmobile" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Email ID</label>
                                                <div class="col-sm-8">
                                                    <input readonly required="requiered" type="email" class="form-control"
                                                        name="email" id="email" maxlength="50" placeholder="Email ID"
                                                        value="{{ $pro->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gender" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Gender </label>
                                                <div class="col-sm-8">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" <?php  if($pro->gender == '1'){ ?> checked
                                                                <?php }else{ ?> '' <?php } ?> name="gender"
                                                                id="male" value="1">
                                                            Male
                                                        </label>
                                                        <label>
                                                            <input type="radio" <?php  if($pro->gender == '2'){ ?> checked
                                                                <?php }else{ ?> '' <?php } ?> name="gender"
                                                                id="female" value="2">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="permanent_address_1" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Contact Address</label>
                                                <div class="col-sm-8">
                                                    <textarea rows="3" required="requiered" type="text" class="form-control" name="permanent_address_1"
                                                        id="permanent_address_1" maxlength="1000" placeholder="Contact Address">{{ $pro->permanent_address_1 }}</textarea>
                                                </div>
                                            </div>
                                            @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 ||
                                                    Auth::user()->user_type_id == 3 ||
                                                    Auth::user()->user_type_id == 4 ||
                                                    Auth::user()->user_type_id == 5 ||
                                                    Auth::user()->user_type_id == 6 ||
                                                    Auth::user()->user_type_id == 7 ||
                                                    Auth::user()->user_type_id == 8 ||
                                                    Auth::user()->user_type_id == 9 ||
                                                    Auth::user()->user_type_id == 10 ||
                                                    Auth::user()->user_type_id == 11 ||
                                                    Auth::user()->user_type_id == 16 ||
                                                    Auth::user()->user_type_id == 17)
                                                <div class="form-group row">
                                                    <label for="payment_qr_oode" class="col-sm-4 col-form-label">
                                                        <span style="color:red"></span>UPI QR</label>
                                                    <div class="col-sm-7">
                                                        <input type="file" name="payment_qr_oode"><br />

                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-default"
                                                            data-toggle="modal"
                                                            data-target="#viewimg{{ $pro->id }}"><i
                                                                class="fa fa-eye"></i> </button>
                                                    </div>
                                                    <div class="modal fade" id="viewimg{{ $pro->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">UPI QR Image</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <center> <img style="width:200px"
                                                            src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $pro->payment_qr_oode }}" />
                                                                    </center>

                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="upi" class="col-sm-4 col-form-label">
                                                        <span style="color:red"></span>UPI ID</label>
                                                    <div class="col-sm-8">
                                                        <input required="requiered" type="text" class="form-control"
                                                            name="upi" id="upi" maxlength="50"
                                                            placeholder="UPI ID" value="{{ $pro->upi }}">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group row">
                                                <label for="user_photo" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Profile Photo</label>
                                                <div class="col-sm-7">
                                                    <input type="file" name="user_photo" value="Upload Image">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-default"
                                                        data-toggle="modal" data-target="#viewprofile{{ $pro->id }}"><i
                                                            class="fa fa-eye"></i> </button>
                                                </div>
                                                  <div class="modal fade" id="viewprofile{{ $pro->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Profile Image</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center><img style="width:200px"
                                                                        src="{{ URL::to('/') }}/upload/user_photo/{{ $pro->user_photo }}" />
                                                                </center>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                            </div>
                                           
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <a href="" class="btn btn-info">Back</a>
                                <input id="save" class="btn btn-info" type="submit" name="submit"
                                    value="Submit" />
                            </div>
                        </div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
