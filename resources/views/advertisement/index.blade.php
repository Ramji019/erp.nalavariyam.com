@extends('layouts.app')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Advertisement</h1>
      </div>
      <div class="col-sm-6">
        @if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) ||
        (Auth::user()->user_type_id == 3))
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#addadvertisement"><i class="fa fa-plus"> Add Advertisement
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
                    <th> S.No</th>
                    <th>Company Name</th>
                    <th>Location</th>
                    <th>AD From Date</th>
                    <th>AD To Date</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($advertisement as $key=> $advertisementlist)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $advertisementlist->company_name }}</td>
                    <td>{{ $position[$advertisementlist->add_location] }}</td>
                    <td>{{ $advertisementlist->add_from_date }}</td>
                    <td>{{ $advertisementlist->add_to_date }}</td>
                    <td>{{ $advertisementlist->status }}</td>
                    <td>
                      <a data-toggle="modal" data-target="#editadvertisement{{ $advertisementlist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
                      <div class="modal fade" id="editadvertisement{{ $advertisementlist->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Advertisement</h4>
                              <button type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="{{url('/editadvertisement')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $advertisementlist->id }}" name="id">
                            <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="add_location">Ad Location</label>
                                <select required class="form-control" name="add_location" id="add_location">
                                    <option>Select Location</option>
                                    <option  @if($advertisementlist->add_location == '1') selected @endif value="1">Welcome</option>
                                    <option  @if($advertisementlist->add_location == '2') selected @endif value="2">Login Header</option>
                                    <option  @if($advertisementlist->add_location == '3') selected @endif value="3">Login Footer</option>
                                    <option  @if($advertisementlist->add_location == '4') selected @endif value="4">Login Left</option>
                                    <option  @if($advertisementlist->add_location == '5') selected @endif value="5">Login Right</option>

                                </select>
                              </div>
							  
                        <div class="form-group">
                              <label>Add Type</label>
                                 <select required class="form-control" name="add_type" id="add_type" style="width: 100%;">
                                  <option>Select Add Type</option>
                                  <option @if($advertisementlist->add_type == 'video') selected @endif value="video">Video</option>
                                  <option @if($advertisementlist->add_type == 'image') selected @endif value="image">Image</option>
                                 </select>
                             </div>
                      
                             <div class="form-group">
                              <label for="company_name">Company Name</label>
                              <input required value="{{ $advertisementlist->company_name }}" type="text" class="form-control"  name="company_name" id="company_name" placeholder="Enter Company Name">
                            </div>
                  
                            <div class="form-group">
                              <label>District Name</label>
                              <select required required class="form-control select2" name="dist_id" id="editdist_id{{ $advertisementlist->id }}"
                                  style="width: 100%;">
                                  @foreach ($managedistrict as $district)
                                      <option @if ($advertisementlist->district_id == $district->id) selected @endif value="{{ $district->id }}">{{ $district->district_name }}</option>
                                  @endforeach
                              </select>
                          </div>
                  
                          <div class="form-group">
                              <label>Taluk Name</label>
                              <select required class="form-control select2" name="taluk_id" id="edittaluk{{ $advertisementlist->id }}"
                                  style="width: 100%;">
                                  @foreach ($managetaluk as $taluk)
                                  <option @if ($advertisementlist->taluk_id == $taluk->id) selected @endif
                                      value="{{ $taluk->id }}">{{ $taluk->taluk_name }}
                                  </option>
                              @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Panchayath Name</label>
                              <select required class="form-control select2" name="panchayath_id" id="editpanchayath{{ $advertisementlist->id }}"
                                  style="width: 100%;">
                                  <option value="">Select Panchayath Name</option>
								   @foreach ($managepanchayath as $panchayath)
                                  <option @if ($advertisementlist->panchayath_id == $panchayath->id) selected @endif
                                      value="{{ $panchayath->id }}">{{ $panchayath->panchayath_name }}
                                  </option>
                              @endforeach
							  
							  
                              </select>
                          </div>
                          
                           
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="company_url">Company Url</label>
                              <input class="form-control" value="{{ $advertisementlist->company_url }}" name="company_url" id="company_url" placeholder="Enter Company Url">
                            </div>
                            <div class="form-group">
                              <label for="add_from_date">AD From Date</label>
                              <input required type="date" value="{{ $advertisementlist->add_from_date }}" class="form-control" name="add_from_date" id="add_from_date" placeholder="Ad From Date">
                            </div>
                            <div class="form-group">
                              <label for="add_to_date">AD To Date</label>
                              <input required type="date" value="{{ $advertisementlist->add_to_date }}" class="form-control" name="add_to_date" id="add_to_date" placeholder="Ad To Date">
                            </div>
                             <div class="form-group">
                              <label for="company_details">Company Details</label>
                              <textarea class="form-control"  name="company_details" id="company_details" placeholder="Enter Company Details" rows="4">{{ $advertisementlist->company_details }}</textarea>
                            </div>
                            
                            <div class="form-group">
                              <label>Status</label>
                                 <select class="form-control" name="status" id="status" style="width: 100%;">
                                  <option @if($advertisementlist->status == 'Active') selected @endif value="Active">Active</option>
                                  <option @if($advertisementlist->status == 'Inactive') selected @endif value="Inactive">Inactive</option>
                                 </select>
                             </div>
                  
                            <div class="form-group">
                              <label for="add_image">Add Image</label>
                              <input  type="file" class="form-control" name="add_image"  placeholder="Add Image">
                              <img style="border:1px solid #000000; padding:3px; margin:5px" src="{{ URL::to('/') }}/upload/advertise/{{ $advertisementlist->add_image }}" width="50" height="50" id="image">
                            </div>

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

                <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deleteadvertisement' ,$advertisementlist->id) }}"
              class="btn btn-info"><i class="fa fa-trash" title="Delete"> Delete</i></a>
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
<div class="modal fade" id="addadvertisement">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Advertisement</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('/addadvertisement')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
         <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="add_location">Add Location</label>
              <select required class="form-control" name="add_location" id="add_location">
                  <option value="">Select</option>
                  <option value="1">Welcome 720 X 1280</option>
                  <option value="2">Login Header 1125 X 190</option>
                  <option value="3">Login Footer 1125 X 190</option>
                  <option value="4">Login Left 200 X 153</option>
                  <option value="5">Login Right 200 X 153</option>
              </select>
            </div>
			<div class="form-group">
            <label>Add Type</label>
               <select required class="form-control" name="add_type" id="add_type" style="width: 100%;">
                <option>Select Add Type</option>
                <option value="video">Video</option>
                <option value="image">Image</option>
               </select>
           </div>
		
           <div class="form-group">
            <label for="company_name">Company Name</label>
            <input required required type="text" class="form-control"  name="company_name" id="company_name" placeholder="Enter Company Name">
          </div>

          <div class="form-group">
            <label>District Name</label>
            <select required required class="form-control select2" name="dist_id" id="dist_id"
                style="width: 100%;">
                <option value="">Select District Name</option>
                @foreach ($managedistrict as $district)
                    <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Taluk Name</label>
            <select required class="form-control select2" name="taluk_id" id="taluk"
                style="width: 100%;">
                <option value="">Select Taluk Name</option>
            </select>
        </div>
        <div class="form-group">
            <label>Panchayath Name</label>
            <select required class="form-control select2" name="panchayath_id" id="panchayath"
                style="width: 100%;">
                <option value="">Select Panchayath Name</option>
            </select>
        </div>
        
         
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="company_url">Company Url</label>
            <input class="form-control" name="company_url" id="company_url" placeholder="Enter Company Url">
          </div>
          <div class="form-group">
            <label for="add_from_date">AD From Date</label>
            <input required type="date" class="form-control" name="add_from_date" id="add_from_date" placeholder="Ad From Date">
          </div>
          <div class="form-group">
            <label for="add_to_date">AD To Date</label>
            <input required type="date" class="form-control" name="add_to_date" id="add_to_date" placeholder="Ad To Date">
          </div>
           <div class="form-group">
            <label for="company_details">Company Details</label>
            <textarea class="form-control" name="company_details" id="company_details" placeholder="Enter Company Details" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="add_image">Add Image</label>
            <input  type="file" class="form-control" name="add_image" id="add_image" placeholder="Add Image">

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
               dataType: 'json',
               $.ajax({
               url: "{{url('/getpanchayath')}}",
               type: "POST",
               data: {
                   panchayath_id: taluk_id,
                   _token: '{{csrf_token()}}'
               },
               dataType: 'json',
           success: function(result) {
               $('#panchayath').html('<option value="">-- Select Panchayath Name --</option>');
               $.each(result, function(key, value) {
                   $("#panchayath").append('<option value="' + value
                       .id + '">' + value.panchayath_name + '</option>');
               });
           }
       });
      });
	    @if(count($advertisement) > 0)
      var advertisement =0;
      $('#editdist_id' + {{ $advertisementlist->id ?? advertisement}}).on('change', function () {
           var idTaluk = this.value;
           $("#edittaluk" + {{ $advertisementlist->id ?? advertisement}}).html('');
           $.ajax({
               url: "{{url('/gettaluk')}}",
               type: "POST",
               data: {
                   taluk_id: idTaluk,
                   _token: '{{csrf_token()}}'
               },
               dataType: 'json',
               success: function (result) {
                   $('#edittaluk' + {{ $advertisementlist->id ?? advertisement}}).html('<option value="">-- Select Taluk Name --</option>');
                   $.each(result, function (key, value) {
                       $("#edittaluk" + {{ $advertisementlist->id ?? advertisement}}).append('<option value="' + value
                           .id + '">' + value.taluk_name + '</option>');
                   });
                   $('#editpanchayath' + {{ $advertisementlist->id ?? advertisement}}).html('<option value="">-- Select Panchayath --</option>');
               }   
           });
       });
 
 
   $('#edittaluk'+ {{ $advertisementlist->id ?? advertisement}}).on('change', function() {
       var taluk_id = this.value;
       $("#editpanchayath" + {{ $advertisementlist->id ?? advertisement}}).html('');
               dataType: 'json',
               $.ajax({
               url: "{{url('/getpanchayath')}}",
               type: "POST",
               data: {
                   panchayath_id: taluk_id,
                   _token: '{{csrf_token()}}'
               },
               dataType: 'json',
           success: function(result) {
               $('#editpanchayath' + {{ $advertisementlist->id ?? advertisement}}).html('<option value="">-- Select Panchayath Name --</option>');
               $.each(result, function(key, value) {
                   $("#editpanchayath" + {{ $advertisementlist->id ?? advertisement}}).append('<option value="' + value
                       .id + '">' + value.panchayath_name + '</option>');
               });
           }
       });
      });
	  @endif
</script>

@endpush
