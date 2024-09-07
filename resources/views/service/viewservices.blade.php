@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Services</h1>
                </div>
                <div class="col-sm-6">
                    @if (Auth::user()->user_type_id == 1)
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                                    data-toggle="modal" data-target="#AddServices"><i class="fa fa-plus"> Add </i></button>
                            </li>
                        </ol>
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
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> S No</th>
                                        <th> Service Name</th>
                                        <th> Service Payment</th>
                                        <th> Status</th>
 @if (Auth::user()->user_type_id == 1)
                                        <th> Edit</th>
@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viewservices as $key => $service)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $service->service_name }}</td>
                                            <td>{{ $service->service_payment }}</td>
                                            <td>{{ $service->status }}</td>
 @if (Auth::user()->user_type_id == 1)
                                            <td>
                                                <a href="{{ url('editservice',$service->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"title="Edit"></i> Edit</a>
                                            </td>
@endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="AddServices">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Services</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addservice') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="service_name">Service Name</label>
                                    <input type="text" required="required" class="form-control" name="service_name" id="service_name"
                                        placeholder="Enter Service Name">
                                </div>
								<div class="row">
                            <div class="col-md-6">
                                <label>Service Type</label>
									<select class="form-control select2" name="servicetype" id="service_type" required="required" style="width: 100%;">
										<option value="">Select Service Type</option>
										 <option value="1">Normal</option>
										 <option value="2">Scholarship</option>
									</select>
                                </div>
                                 <div class="col-md-6">
                                  <div class="form-group">
                                   <label for="service_payment">Service Payment"</label>
                                    <input required="required" type="text" class="form-control number" name="service_payment" id="service_payment"
                                        placeholder="Enter Service Payment">
                                </div>
                            </div>
                        </div>

								<div class="row" id="datehidden">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="full_name">From Date</label>
                                    <input type="date" class="form-control" name="from_date" id="from_date">
                                </div>
                                </div>
                                 <div class="col-md-6">
                                  <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="to_date" id="to_date">
                                </div>
                            </div>
                        </div>

                                <div class="form-group">
                                    <label for="user_photo">புகைப்படம்</label>
                                    <div class="input-group">
                                        <input type="file" class="custom-file-input" name="from_image" id="from_image"
                                            autocomplete="off" >
                                        <label class="custom-file-label" for="from_image">Choose file</label>
                                    </div>
                                </div>
 <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> S No</th>
                                        <th> Service Name</th>
                                        <th> Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                      @foreach ($district as $key =>  $districtlist)
								        <tr>
                                            <td>{{ $districtlist->id }}
                                                <input type="hidden" name="dist_id[]" value="{{ $districtlist->id }}"></td>
                                            <td>{{ $districtlist->district_name }}</td>
                                            <td>
                                            <label>
                                                <input type="checkbox" name="check_{{ $districtlist->id }}"
                                                    value="2">
                                                 Offline
                                            </label>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@endsection
@push('page_scripts')
    <script>

           $(function() {
            $('#datehidden').hide();
            $('#from_date').prop("required", false);;
            $('#to_date').prop("required", false);;
            $('#service_type').change(function() {
                if ($(this).val() == "2") {
                    $('#from_date').val("");
                    $('#to_date').val("");

                    $('#datehidden').show('slow');
                    $('#from_date').prop("required", true);
                    $('#to_date').prop("required", true);

                }else {
                    $('#from_date').val("");
                    $('#to_date').val("");

                    $('#datehidden').hide();
                    $('#from_date').prop("required", false);
                    $('#to_date').prop("required", false);

                }
            });
        });
    </script>
@endpush
