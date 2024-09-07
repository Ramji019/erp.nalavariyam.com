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
          <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#addnotification"><i class="fa fa-plus"> Add Notification
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
                  <th> User Type</th>
                  <th> Notification</th>
                  <th> From Date</th>
                  <th> To Date</th>
				  @if(Auth::user()->user_type_id == 1)
                     <th> Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($notification as $key=> $notificationlist)
                <tr>
                  <td>{{ $key + 1 }}</td>
				 @if($notificationlist->user_type == 'A')
                  <td>Super Admin</td>
				 @elseif($notificationlist->user_type == 'B')
                  <td>Primary Users</td>
				 @elseif($notificationlist->user_type == 'C')
                  <td>District  Users</td>
				 @elseif($notificationlist->user_type == 'D')
                  <td>Taluk User</td>
				 @elseif($notificationlist->user_type == 'E')
                  <td>Panchayath Users</td>
				 @elseif($notificationlist->user_type == 'F')
                  <td>Block </td>
				 @elseif($notificationlist->user_type == 'G')
                  <td>Center </td>
				 @elseif($notificationlist->user_type == 'I')
                  <td>Special User</td>
				@endif
				  
                  <td>{{ $notificationlist->notification_name }}</td>
                  <td>{{ $notificationlist->from_date }}</td>
                  <td>{{ $notificationlist->to_date }}</td>
				  
				  @if(Auth::user()->user_type_id == 1)
                  <td>
                    <a data-toggle="modal" data-target="#editnotification{{ $notificationlist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
                    <div class="modal fade" id="editnotification{{ $notificationlist->id }}">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Edit Notification Details</h4>
                            <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{url('../editnotification')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" value="{{ $notificationlist->id }}" name="id">
                          <div class="modal-body">
                           <div class="row">
                            <div class="col-md-6">
                             <div class="form-group">
                              <div class="form-group">
                                <label for="user_type">User Type</label>
                                <input type="text" value="{{ $notificationlist->user_type }}" class="form-control"  name="user_type" id="user_type" placeholder="">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-group">
                                <label for="user_type">Notification Name</label>
                                <input type="text" value="{{ $notificationlist->notification_name }}" class="form-control"  name="notification_name" id="notification_name" placeholder="">
                              </div>
                              <div class="form-group">
                                <label for="user_type">Notification Details</label>
                                <textarea type="text" value="" class="form-control"  name="notification_details" id="notification_details" placeholder="" rows="3"> {{ $notificationlist->notification_details }}</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_type">From Date</label>
                                <input type="date" value="{{ $notificationlist->from_date }}" class="form-control"  name="from_date" id="from_date" placeholder="">
                              </div>
                              <div class="form-group">
                                <label for="user_type">To Date</label>
                                <input type="date" value="{{ $notificationlist->to_date }}" class="form-control"  name="to_date" id="to_date" placeholder="">
                              </div>
                              
                              <div class="form-group">
                                    <label for="notification_img">Notification Image</label>
                                    <div class="input-group">
                                        <input type="file" class="custom-file-input" name="notification_img" id="notification_img"
                                            autocomplete="off" >
                                        <label class="custom-file-label" for="notification_img">Choose file</label>
                                    </div>
                                </div>
                                <img src="{{ URL::to('/') }}/upload/notification_img/{{ $notificationlist->notification_img }}" width="50" height="50" id="image">
                          </div>
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

              <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletenotification' ,$notificationlist->id) }}"
              class="btn btn-info"><i class="fa fa-trash" title="Delete"> Delete</i></a>
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
</div>
</section>
<div class="modal fade" id="addnotification">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Notification</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('/addnotification')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
         <div class="row">
          <div class="col-md-6">
           <div class="form-group">
            <label for="user_type">User Type</label>
            <select class="form-control select2bs4" name="user_type" id="user_type" style="width: 100%;" required="required">
             <option value="A">Superadmin</option> 
             <option value="B">State Users</option> 
             <option value="C">District Users</option> 
             <option value="D">Taluk Users</option> 
             <option value="E">Block Users</option> 
             <option value="F"> Sub Block Users</option> 
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
          <textarea class="form-control" name="notification_details" id="notification_details" placeholder="Enter Notification Details" rows="4"></textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="password">From Date</label>
          <input type="date" class="form-control" name="from_date" id="from_date" placeholder="Enter From Date">
        </div>
        <div class="form-group">
          <label for="password">To Date</label>
          <input type="date" class="form-control" name="to_date" id="to_date" placeholder="Enter To Date">
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
