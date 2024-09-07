@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::user()->user_type_id == 1)
                        <h1>Special Users</h1>
                    @elseif(Auth::user()->user_type_id == 2)
                        <h1>Special Presidents</h1>
                    @elseif(Auth::user()->user_type_id == 3)
                        <h1>Special Secretarys</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if (Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                                    data-toggle="modal" data-target="#Specialusers"><i class="fa fa-plus"> Add </i></button>
                            </li>
                        </ol>
                    @else
                    @endif
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
                            <div class="table-responsive" style="overflow-x: auto; ">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> #</th>
                                            <th> ID</th>
                                            <th> District</th>
                                            <th> Full Name</th>
                                            <th> Phone</th>
                                            <th> Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialusers as $key => $specialuserslist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>N{{ $specialuserslist->userID }}</td>
                                                <td>{{ $specialuserslist->district_name }}</td>
                                                <td>{{ $specialuserslist->full_name }}</td>
                                                <td>{{ $specialuserslist->phone }}</td>
                                                <td>{{ $specialuserslist->status }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default">Action</button>
                                                        <button type="button"
                                                            class="btn btn-default dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            <a class="dropdown-item"
                                                                href="{{ url('/edituser', $specialuserslist->userID) }}">Edit</a>
                                                            <a class="dropdown-item"
                                                                href="{{ url('/assigned') }}/{{ $specialuserslist->user_type_id }} /{{ $specialuserslist->userID }}">Assigned</a>


                                                            <a onclick="userdatas('{{ $specialuserslist->userID }}','{{ $specialuserslist->full_name }}','{{ $specialuserslist->user_photo }}','{{ $specialuserslist->username }}','{{ $specialuserslist->district_name }}','{{ $specialuserslist->email }}','{{ $specialuserslist->pas }}','{{ $specialuserslist->phone }}','{{ $specialuserslist->status }}')"
                                                                type="button" class="dropdown-item"> View</a>

                                                            @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                                                <a onclick="userstatus('{{ $specialuserslist->userID }}','{{ $specialuserslist->full_name }}','{{ $specialuserslist->from_to_date }}','{{ $specialuserslist->status }}')"
                                                                    type="button" class="dropdown-item">Status</a>
                                                                <a href="resetpassword/{{ $specialuserslist->userID }}"
                                                                    type="button" class="dropdown-item">Reset Password</a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{{ url('/userstatusupdate') }}/{{ $specialuserslist->userID }}/{{ $specialuserslist->user_type_id }}">Status
                                                                    Update</a>
                                                            @endif
                                                            <a onclick="userwallet('{{ $specialuserslist->userID }}','{{ $specialuserslist->full_name }}','{{ $specialuserslist->balance }}')"
                                                                type="button" class="dropdown-item">View Wallet</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="Specialusers">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Special Users Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/adduser') }}" method="post">
                    {{ csrf_field() }}
                    @if (Auth::user()->user_type_id == 2)
                        <input type="hidden" name="user_type_id" value="16">
                    @elseif(Auth::user()->user_type_id == 3)
                        <input type="hidden" name="user_type_id" value="17">
                    @endif
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District Name</label>
                                    <select class="form-control select2" name="dist_id" style="width: 100%;" required>
                                        <option value="">Select District Name</option>
                                        @foreach ($managedistrict as $district)
                                            <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name"
                                        placeholder="Enter Full Name">
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Gender</label>
                                    <div class="radio">
                                        <label>
                                            Select
                                            <l /abel>
                                                <label>
                                                    <input type="radio" name="gender" id="male" value="1">
                                                    Male
                                                </label>
                                                <label>
                                                    <input type="radio" name="gender" id="female" value="2">
                                                    Female
                                                </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="aadhaar_no">Aadhaar Number"</label>
                                    <input onkeyup="duplicateaadhar(0)" type="text" maxlength="12"
                                        class="form-control number" name="aadhaar_no" id="aadhar"
                                        placeholder="Enter Aadhaar Number">
                                    <span id="dupaadhar" style="color:red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input onkeyup="duplicateemail(0)" type="email" class="form-control"
                                        name="email" id="email" placeholder="Enter email">
                                    <span id="dupemail" style="color:red"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Mobile Number</label>
                                    <input type="text" class="form-control number" name="phone" id="phone"
                                        placeholder="Enter Mobile Number"onkeyup="duplicatephone(0)" maxlength="10">
                                    <span id="dupmobile" style="color:red"></span>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address"rows="3" placeholder="Enter Address ...."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="save" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userdata">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="full_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>ID </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="id"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>UserName
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="username"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="district_name"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Email
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="emails"></span></label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Password
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="pas"></span></label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Phone
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="phones"></span></label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="status"></span> </label>
                    </div>
                    <center>
                        <a class="btn btn-info" href="" id="msgbtn" data-action="share/whatsapp/share"
                            target="_blank">Send Whatsapp</a>
                    </center>

                </div>
                <div class="modal-footer justify-content-between">
                    <a type="" class=""></a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="wallets">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <h1 id="userwallet"></h1>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a type="" class=""></a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userstatusmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="statusname"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/userstatus') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="userid" id="statusid">
                        <div class="form-group">
                            <label>District Name</label>
                            <select class="form-control" name="status" id="userstatus" style="width: 100%;">
                                <option value="">Select District Name</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="full_name">From Date</label>
                            <input type="date" class="form-control" name="from_to_date" id="fromdate">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button id="save" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function userdatas(id, full_name, user_photo, username, district_name, email, pas, phone, status) {
            $("#id").text(id);
            $("#full_name").text(full_name);
            $("#user_photo").text(user_photo);
            $("#username").text(username);
            $("#district_name").text(district_name);
            $("#emails").text(email);
            $("#pas").text(pas);
            $("#phones").text(phone);
            $("#status").text(status);
            $('#msgbtn').attr('href', 'https://api.whatsapp.com/send?phone=91' + phone +
                '&text=Sir, We are from NalaVariyam , Your Login UserName : ' + username + ', Password : ' + pas +
                ', Contact Us : Mobile 7598984380 Email : ramjitrust039@gmail.com, Websit : www.nalavariyam.com. I have attached your Login website  link below https://nalavariyam.com/apps/'
                )
            $("#userdata").modal("show");
        }
    </script>
    <script>
        function userwallet(id, full_name, wallet) {
            $("#id").text(id);
            $("#name").text(full_name);
            $("#userwallet").text(wallet);
            $("#wallets").modal("show");
        }

        function userstatus(id, full_name, fromto_date, status) {
            $("#statusid").val(id);
            $("#statusname").text(full_name);
            $("#fromdate").val(fromto_date);
            $("#userstatus").val(status);
            $("#userstatusmodal").modal("show");

        }
    </script>
@endpush
