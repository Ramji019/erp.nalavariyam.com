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
                        @if (Auth::user()->user_type_id == 1 ||
                                Auth::user()->user_type_id == 3 ||
                                Auth::user()->user_type_id == 3 ||
                                Auth::user()->user_type_id == 4 ||
                                Auth::user()->user_type_id == 5)
                            <li class="breadcrumb-item">
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
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Full Name</th>
                                            <th>Mobile</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($Participated as $key => $meetingsslist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $meetingsslist->full_name }}</td>
                                                @php $Meetingid = $meetingsslist->id; @endphp
                                                <td>{{ $meetingsslist->phone }}</td>
                                                <td>{{ $meetingsslist->date }}</td>
                                                <td>
                                                    <form action="{{ url('/updatestatus') }}" class="nav-link"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{ $meetingsslist->status }}"
                                                            name="status">
                                                        <input type="hidden" name="parti_id"
                                                            value="{{ $meetingsslist->id }}">
                                                        @if($meetingsslist->status == "1")
                                                        <button onclick="this.form.submit();this. disabled=true;"
                                                            type="submit" class="btn btn-md btn-primary"><i
                                                                class="fa fa-eye"></i></button>
                                                        @elseif( $meetingsslist->status == "2" )
                                                          <p class="btn btn-sm btn-success" style="color: white"><i>Paid</i></p>
                                                        @endif
                                                    </form>
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
    <div class="modal fade" id="addparticipated">
        <form action="{{ url('addparticipated') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="meeting_id" value="{{ $id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Participated</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="meeting_name" class="col-sm-4 col-form-label"><span style="color:red"></span>
                                Assigned </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="user_id" id="user_id" style="width: 100%;">
                                    <option value="">Select Use Name</option>
                                    @foreach ($Users as $meetingsslist)
                                        <option value="{{ $meetingsslist->id }}">ID{{ $meetingsslist->id }}
                                            {{ $meetingsslist->full_name }}</option>
                                    @endforeach
                                </select>
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
    </div>
    </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function edit_meetings(id, meeting_name, address, district_id, user_id, status, metting_date) {
            $("#row_id").val(id);
            $("#editname").val(meeting_name);
            $("#editaddress").val(address);
            $("#districtid").val(district_id);
            $("#userid").val(user_id);
            $("#edstatus").val(status);
            $("#mettingdate").val(metting_date);
            $("#editmeetings").modal("show");
        }
    </script>
@endpush
