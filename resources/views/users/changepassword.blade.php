@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
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
                            <h3 class="card-title">Change Password</h3>
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
                                <form action="{{ url('/updatepassword') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Old Password</label>
                                                    <input type="text" class="form-control" name="oldpassword" required="required" id="oldpassword" placeholder="Enter Old Password">
                                                </div>     
												<div class="form-group">
                                                    <label for="new_password">New Password</label>
                                                    <input type="text" class="form-control" name="new_password" required="required" id="password" placeholder="Enter New Password">
                                                </div> 
												<div class="form-group">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input type="text" class="form-control" name="confirm_password" required="required" id="password" placeholder="Enter Confirm Password">
                                                </div>                                         
                                        <div class="form-group row">
                                            <div class="col-md-12 text-center">
                                                <a href="" class="btn btn-info">Back</a>
                                                <input id="save" class="btn btn-info" type="submit" name="submit"
                                                    value="Submit" />
                                            </div>
                                        </div>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
