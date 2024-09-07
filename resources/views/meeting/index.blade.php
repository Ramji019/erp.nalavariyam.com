@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Meetings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                    <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                        data-toggle="modal" data-target="#addmeetings"><i class="fa fa-plus"> Add </i></button>
                        @endif
                    </li>
                </ol>
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
                        <h3 class="card-title"></h3>
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
                        <div class="col-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        @if ((Auth::user()->id == 1) || (Auth::user()->id == 2) || (Auth::user()->id == 3))
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab"
                                                data-toggle="pill" href="#completed" role="tab"
                                                aria-controls="custom-tabs-four-home" aria-selected="true">New
                                            Meeting</a>
                                        </li>
                                        @else
                                        @foreach ($New as $key => $meetingsslist)
                                        @if (Auth::user()->id == $meetingsslist->user_id || Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab"
                                                data-toggle="pill" href="#completed" role="tab"
                                                aria-controls="custom-tabs-four-home" aria-selected="true">New
                                            Meeting</a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
										
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom1" role="tab" aria-controls="custom-tabs-four-home"
                                                aria-selected="true">Live Meeting</a>
                                        </li>

                                        @if ((Auth::user()->id == 1) || (Auth::user()->id == 2) || (Auth::user()->id == 3))
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-home-tab"
                                                data-toggle="pill" href="#custom2" role="tab"
                                                aria-controls="custom-tabs-four-home"
                                                aria-selected="false">Completed Meeting</a>
                                        </li>
                                        @else
                                        @foreach ($New as $key => $meetingsslist)
                                        @if (Auth::user()->id == $meetingsslist->user_id ||
                                        Auth::user()->user_type_id == 1 ||
                                        Auth::user()->user_type_id == 2 ||
                                        Auth::user()->user_type_id == 3)
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-home-tab"
                                                data-toggle="pill" href="#custom2" role="tab"
                                                aria-controls="custom-tabs-four-home"
                                                aria-selected="false">Completed Meeting</a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom3" role="tab" aria-controls="custom-tabs-four-home"
                                                aria-selected="false">Rejected Meeting</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="completed" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Date</th>
                                                            <th>Meeting Name</th>
                                                            <th>Address</th>
                                                            <th>District</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($New as $key => $meetingsslist)
                                                        <tr>
														    <td>  @php 
       $address1 = $meetingsslist->address;
       $address1 = str_replace(PHP_EOL, ' ',$address1);
       $address1 = str_replace("\r\n", ' ', $address1);
       $address1 = str_replace("\n", ' ', $address1);
       $NEWLINE_RE = '/(\r\n)|\r|\n/'; 
       $address1 = preg_replace($NEWLINE_RE,' ', $address1);
       @endphp</td>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $meetingsslist->metting_date }}</td>
                                                            <td>{{ $meetingsslist->meeting_name }}</td>
                                                            <td>{{ $address1 }}</td>
                                                            <td>{{ $meetingsslist->district_name }}</td>
                                                            @if ($meetingsslist->status == 1)
                                                            <td>Active</td>
                                                            @else
                                                            <td>Inactive</td>
                                                            @endif
                                                            <td style="white-space: nowrap">
                                                                @if (Auth::user()->id == $meetingsslist->user_id ||
                                                                Auth::user()->user_type_id == 1 ||
                                                                Auth::user()->user_type_id == 2 ||
                                                                Auth::user()->user_type_id == 3)
                                                                <a onclick="edit_meetings('{{ $meetingsslist->id }}','{{ $meetingsslist->meeting_name }}','{{ $meetingsslist->address }}','{{ $meetingsslist->district_id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->status }}','{{ $meetingsslist->metting_date }}','{{ $meetingsslist->amount }}')"
                                                                    href="#"
                                                                    class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-edit"></i> Edit</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom1" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="table-responsive">
                                                <table id="example3" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Id</th>
                                                            <th>Meeting Name</th>
                                                            <th>Address</th>
                                                            <th>District</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($Live as $key => $meetingsslist)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $meetingsslist->id }}</td>
                                                            <td>{{ $meetingsslist->meeting_name }}</td>
                                                            <td>{{ $meetingsslist->address }}</td>
                                                            <td>{{ $meetingsslist->district_name }}</td>
                                                            @if ($meetingsslist->status == 1)
                                                            <td>Active</td>
                                                            @else
                                                            <td>Inactive</td>
                                                            @endif
                                                            <td style="white-space: nowrap">
@if (in_array($meetingsslist->id, $paiduser))
	 @if (Auth::user()->user_type_id == 1 ||
                    Auth::user()->user_type_id == 2 ||
                    Auth::user()->user_type_id == 3 ||
                    Auth::user()->user_type_id == 4 ||
                    Auth::user()->user_type_id == 5)
<a onclick="pay_now('{{ $meetingsslist->id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->amount }}')" href="#" class="btn btn-sm btn-primary"><i class=""></i> Pay Now</a>
@endif

@else
<a onclick="pay_now('{{ $meetingsslist->id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->amount }}')" href="#" class="btn btn-sm btn-primary"><i class=""></i> Pay Now</a>

@endif																	
                                                                @if (Auth::user()->id == $meetingsslist->user_id ||
                                                                Auth::user()->user_type_id == 1 ||
                                                                Auth::user()->user_type_id == 2 ||
                                                                Auth::user()->user_type_id == 3)
                                                                <a onclick="edit_meetings('{{ $meetingsslist->id }}','{{ $meetingsslist->meeting_name }}','{{ $address1 }}','{{ $meetingsslist->district_id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->status }}','{{ $meetingsslist->metting_date }}','{{ $meetingsslist->amount }}')"
                                                                    href="#"
                                                                    class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-edit"></i> Edit</a>
                                                                <a href="{{ url('meetingparticipated', $meetingsslist->id) }}"
                                                                    class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-eye"></i> Participated</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom2" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="table-responsive">
                                                <table id="example4" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Id</th>
                                                            <th>Meeting Name</th>
                                                            <th>Address</th>
                                                            <th>District</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($Completed as $key => $meetingsslist)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $meetingsslist->id }}</td>
                                                            <td>{{ $meetingsslist->meeting_name }}</td>
                                                            <td>{{ $address1 }}</td>
                                                            <td>{{ $meetingsslist->district_name }}</td>
                                                            @if ($meetingsslist->status == 1)
                                                            <td>Active</td>
                                                            @else
                                                            <td>Inactive</td>
                                                            @endif
                                                            <td style="white-space: nowrap">
                                                                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                                                <a onclick="edit_meetings('{{ $meetingsslist->id }}','{{ $meetingsslist->meeting_name }}','{{ $address1 }}','{{ $meetingsslist->district_id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->status }}','{{ $meetingsslist->metting_date }}','{{ $meetingsslist->amount }}')"
                                                                    href="#"
                                                                    class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-edit"></i> Edit</a>
                                                                @endif
                                                                @if (Auth::user()->id == $meetingsslist->user_id ||
                                                                Auth::user()->user_type_id == 1 ||
                                                                Auth::user()->user_type_id == 2 ||
                                                                Auth::user()->user_type_id == 3)
                                                                <a href="{{ url('meetingparticipated', $meetingsslist->id) }}"
                                                                    class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-eye"></i> Participated</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom3" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="table-responsive">
                                                <table id="example5" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Id</th>
                                                            <th>Meeting Name</th>
                                                            <th>Address</th>
                                                            <th>District</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($Rejected as $key => $meetingsslist)
														@php 
       $address1 = $meetingsslist->address;
       $address1 = str_replace(PHP_EOL, ' ',$address1);
       $address1 = str_replace("\r\n", ' ', $address1);
       $address1 = str_replace("\n", ' ', $address1);
       $NEWLINE_RE = '/(\r\n)|\r|\n/'; 
       $address1 = preg_replace($NEWLINE_RE,' ', $address1);
       @endphp
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $meetingsslist->id }}</td>
                                                            <td>{{ $meetingsslist->meeting_name }}</td>
                                                            <td>{{ $address1 }}</td>
                                                            <td>{{ $meetingsslist->district_name }}</td>
                                                            @if ($meetingsslist->status == 1)
                                                            <td>Active</td>
                                                            @else
                                                            <td>Inactive</td>
                                                            @endif
                                                            <td style="white-space: nowrap">
                                                                @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                                                <a onclick="edit_meetings('{{ $meetingsslist->id }}','{{ $meetingsslist->meeting_name }}','{{ $address }}','{{ $meetingsslist->district_id }}','{{ $meetingsslist->user_id }}','{{ $meetingsslist->status }}','{{ $meetingsslist->metting_date }}','{{ $meetingsslist->amount }}')"
                                                                    href="#"
                                                                    class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-edit"></i> Edit</a>
                                                                <a href="{{ url('meetingparticipated', $meetingsslist->id) }}"
                                                                    class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-eye"></i> Participated</a>
                                                                @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="addmeetings">
    <form action="{{ url('/addmeeting') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Meeting</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="meeting_name" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        District Name</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="district_id" style="width: 100%;">
                                <option value="">Select District Name</option>
                                @foreach ($Districts as $meetingsslist)
                                <option value="{{ $meetingsslist->id }}">{{ $meetingsslist->district_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="meeting_name" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        Assigned </label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="user_id" style="width: 100%;">
                                @foreach ($DistrictUser as $meetingsslist)
                                <option value="{{ $meetingsslist->id }}">{{ $meetingsslist->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Name</label>
                        <div class="col-sm-8">
                            <input required="required" type="text" class="form-control" name="meeting_name"
                                id="meeting_name" maxlength="30" placeholder="Metting Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Amount</label>
                        <div class="col-sm-8">
                            <input required="required" type="text" class="form-control" name="amount"
                                id="amount" maxlength="30" placeholder="Metting Amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address" rows="3" placeholder="Enter Address..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Date</label>
                        <div class="col-sm-8">
                            <input required="required" type="date" class="form-control" name="metting_date"
                                id="metting_date" maxlength="30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="save" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
    </form>
    </div>
</div>
<div class="modal fade" id="editmeetings">
    <form action="{{ url('/updatemeeting') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="row_id" id="row_id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Meeting List</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="meeting_name" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        District Name</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="district_id" id="districtid"
                                style="width: 100%;">
                                <option value="">Select District Name</option>
                                @foreach ($Districts as $meetingsslist)
                                <option value="{{ $meetingsslist->id }}">{{ $meetingsslist->district_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        Assigned </label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="user_id" id="userid" style="width: 100%;">
                                <option value="">Select User Name</option>
                                @foreach ($DistrictUser as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Name</label>
                        <div class="col-sm-8">
                            <input required="required" type="text" class="form-control" name="meeting_name"
                                id="editname" maxlength="30" placeholder="Metting Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Amount</label>
                        <div class="col-sm-8">
                            <input required="required" type="text" class="form-control" name="amount"
                                id="mettingamount" maxlength="30" placeholder="Metting Amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="address" id="editaddress" rows="3" placeholder="Enter Address..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district" class="col-sm-4 col-form-label"><span style="color:red"></span> Metting
                        Date</label>
                        <div class="col-sm-8">
                            <input required="required" type="date" class="form-control" name="metting_date"
                                id="mettingdate" maxlength="30">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district" class="col-sm-4 col-form-label"><span style="color:red"></span>
                        Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="editstatus" style="width: 100%;">
                                <option value="1">New</option>
                                <option value="2">Live</option>
                                <option value="3">Completed</option>
                                <option value="4">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="save" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<input value="{{ $balance }}" type="hidden" name="wallet_amount" id="wallet_amount" />
<div class="modal fade" id="paynow_modal">
    <form action="{{ url('/meetingpayment') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pay Now</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="meeting_id" id="meetingid" />
                    <input type="hidden" name="coundect_id" id="coundectid" />
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Amount</label>
                        <div class="col-sm-8">
                            <input readonly name="amount" id="payamount" required="required" maxlength="50"
                                class="form-control number" />
                        </div>
                    </div>
                    @if (Auth::user()->user_type_id == 1 ||
                    Auth::user()->user_type_id == 2 ||
                    Auth::user()->user_type_id == 3 ||
                    Auth::user()->user_type_id == 4 ||
                    Auth::user()->user_type_id == 5)
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-4 col-form-label"><span style="color:red">*</span>
                        Users </label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="user_id" id="user_id"
                                style="width: 100%;">
                                <option value="">Select Use Name</option>
                                @foreach ($Users as $meetingsslist)
                                <option value="{{ $meetingsslist->id }}">ID{{ $meetingsslist->id }}
                                    {{ $meetingsslist->full_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <input value="{{ $user_id = Auth::user()->id }}" type="hidden" name="user_id" />
                    @endif
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input class="btn btn-primary" type="submit" value="Submit" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="referral_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pay Now</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    {{ $referral->full_name ?? '' }}</br>
                    {{ $referral->phone ?? '' }}</br>
                    {{ $referral->upi ?? '' }}</br>
                    <img style="width:200px"
                        src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referral->payment_qr_oode ?? '' }}" />
                </center>
                <form onsubmit="return validateamount()" action="{{ url('paymentrequest') }}" method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="to_id" value="{{ $referral->id }}">
                    <div class="form-group row">
                        <label for="" class="col-sm-12 col-form-label"><span style="color:red"></span>Request
                        Amount</label>
                        <input type="text" class="form-control" name="amount" placeholder='Enter Request Amount'
                            required="required">
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-12 col-form-label"><span style="color:red"></span>Paid
                        Image(ScreenShot)</label>
                        <div class="custom-file">
                            <input accept="image/png,image/jpeg,image/jpg" type="file" class="custom-file-input"
                                name="paid_image" required="required">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input class="btn btn-primary" type="submit" value="Submit" />
            </div>
        </div>
    </div>
</div>
</form>
@endsection
@push('page_scripts')
<script>
    function edit_meetings(id, meeting_name, address, district_id, user_id, status, metting_date, amount) {
        $("#row_id").val(id);
        $("#editname").val(meeting_name);
        $("#editaddress").val(address);
        $("#districtid").val(district_id).trigger('change');
        $("#userid").val(user_id).trigger('change');
        $("#editstatus").val(status);
        $("#mettingdate").val(metting_date);
        $("#mettingamount").val(amount);
        $("#editmeetings").modal("show");
    }
    
    function pay_now(id, user_id, amount) {
        $("#meetingid").val(id);
        $("#coundectid").val(user_id);
        $("#payamount").val(amount);
        var wallet_amount = parseFloat($("#wallet_amount").val());
        if (amount > wallet_amount) {
            $("#referral_modal").modal("show");
        } else {
            $("#paynow_modal").modal("show");
        }
    }
</script>
@endpush