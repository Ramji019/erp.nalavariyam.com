@extends('member.layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Member Profile</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Member Profile</h3>
                        </div>
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
                            @foreach ($member as $mem)
                                <form action="{{ url('/updatememberprofile') }}" method="post"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $mem->id }}" />
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="full_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Full Name</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="full_name" id="full_name" maxlength="50"
                                                        placeholder="Full Name" value="{{ $mem->full_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="aadhaar_no" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Aadhaar No</label>
                                                <div class="col-sm-8">
                                                    <input readonly required="requiered" type="text" class="form-control"
                                                        name="aadhaar_no" id="aadhaar_no" maxlength="50"
                                                        placeholder="Aadhaar No" value="{{ $mem->aadhaar_no }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Mobile Number</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="phone" id="phone" placeholder="Mobile Number"
                                                        value="{{ $mem->phone }}" onkeyup="duplicatephone(0)"
                                                        maxlength="10">
                                                    <span id="dupmobile" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Email ID</label>
                                                <div class="col-sm-8">
                                                    <input readonly required="requiered" type="email" class="form-control"
                                                        name="email" id="email" maxlength="50" placeholder="Email ID"
                                                        value="{{ $mem->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gender" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Gender </label>
                                                <div class="col-sm-8">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" <?php  if($mem->gender == '1'){ ?> checked
                                                                <?php }else{ ?> '' <?php } ?> name="gender"
                                                                id="male" value="1">
                                                            Male
                                                        </label>
                                                        <label>
                                                            <input type="radio" <?php  if($mem->gender == '2'){ ?> checked
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
                                                        id="permanent_address_1" maxlength="1000" placeholder="Contact Address">{{ $mem->permanent_address_1 }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="member_photo" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Member Photo</label>
                                                <div class="col-sm-7">
                                                    <input type="file" name="member_photo" value="Upload Image">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#viewprofile{{ $mem->id }}"><i
                                                            class="fa fa-eye"></i> </button>
                                                </div>
                                                <div class="modal fade" id="viewprofile{{ $mem->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Member Profile Image</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center><img style="width:200px"
                                                                        src="{{ URL::to('/') }}/upload/member_photo/{{ $mem->member_photo }}" />
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
                                                <label for="member_signature" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Signature Upload</label>
                                                <div class="col-sm-7">
                                                    <input type="file" name="member_signature"
                                                        value="Upload Image"><br /><br />
                                                    <span id="member_signature" style="color:red"></span>
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#off{{ $mem->id }}"><i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="off{{ $mem->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Signature Image</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center>
                                                                    <img style="width:200px"
                                                                        src="{{ URL::to('/') }}/upload/member_signature/{{ $mem->member_signature }}" />
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
