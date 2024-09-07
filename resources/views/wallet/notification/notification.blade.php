@extends('layouts.app')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Notification</h1>
      </div>
      <div class="col-sm-6">
        @if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) ||
        (Auth::user()->user_type_id == 3))
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#districts"><i class="fa fa-plus"> Add Districts
          </i></button></li>
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
                    <th> S No</th>
                    <th> Notification</th>
                    <th> Status</th>
                    <th> Action</th>

                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a data-toggle="modal" data-target="#EditDistricts" class="btn btn-info"><i
                        class="fa fa-edit" title="Edit"> Edit </i></a>
                        <div class="modal fade" id=>
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Edit District Details</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{url('/editdistricts')}}" method="post" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="hidden" value="" name="districts_id">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for="full_name">District Name</label>
                                  <input type="text" value=""class="form-control"
                                  name="district_name" id="district_name"
                                  placeholder="">
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                data-dismiss="modal">Close</button>
                                <button id="save" type="submit"
                                class="btn btn-primary">Submit</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <a href="" class="btn btn-info"><i class="fa fa-eye" title="view"> View
                      Taluk</i></a>
                      <a onclick="return confirm('Do you want to perform delete operation?')" href=""
                      class="btn btn-info"><i class="fa fa-trash" title="Delete"> Delete</i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="districts">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Notification</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('/id')}}" method="post" >
        {{ csrf_field() }}
        <div class="modal-body">
         <div class="row">
          <div class="col-md-6">
           <div class="form-group">
            <label for="user_type">User Type</label>
            <select class="form-control select2bs4" name="user_type" style="width: 100%;" required="required">
             <option value="A">Superadmin</option> 
             <option value="B">State Users</option> 
             <option value="C">District Users</option> 
             <option value="D">Taluk Users</option> 
             <option value="E">Block Users</option> 
             <option value="F">Panchayath Users</option> 
             <option value="G">Center Users</option>
             <option value="I">Special User</option>
           </select>
         </div>

         <div class="form-group">
          <label for="full_name">Notification Name</label>
          <input type="text" class="form-control"  name="notification_name" id="notification_name" placeholder="Enter Notification Name">
        </div>
        <div class="form-group">
          <label for="aadhaar_no">Notification Details</label>
          <input type="text" class="form-control" name="notification_details" id="notification_details" placeholder="Enter Notification Details">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="password">From Date</label>
          <input type="text" class="form-control" name="from_date" id="from_date" placeholder="Enter From Date">
        </div>
        <div class="form-group">
          <label for="password">To Date</label>
          <input type="text" class="form-control" name="to_date" id="to_date" placeholder="Enter To Date">
        </div>
        <div class="form-group">
          <label for="email">Notification Image</label>
          <input  type="file" class="form-control" name="notification_img" id="notification_img" placeholder="Enter Notification Image">

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
@endsection
