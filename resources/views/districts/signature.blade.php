@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Districts Signature</h1>
         </div>
         <div class="col-sm-6">
         
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
						  <th> District Name</th>
                          <th> Action</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($distsignature as $key=> $districtslist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $districtslist->district_name }}</td>
                           <td>
                 @if($districtslist->user_type_id == 4)
					 
                    <a data-toggle="modal" data-target="#AddSige{{ $districtslist->id }}" class="btn @if($districtslist->user_id != "")btn-info @else btn-danger @endif"><i class="fa fa-eye"title="Edit"> President </i></a>
			     @else
                    <a data-toggle="modal" data-target="#AddSige{{ $districtslist->id }}" class="btn @if($districtslist->user_id != "")btn-info @else btn-danger @endif"><i class="fa fa-eye"title="Edit"> Secretarys </i></a>
				 @endif
                       <div class="modal fade" id="AddSige{{ $districtslist->id }}">
							<div class="modal-dialog modal-md">
							  <div class="modal-content">
								 <div class="modal-header">
									<h4 class="modal-title">Asign District Users</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								 </div>
				 <form action="{{url('/editdistrictsignature')}}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
								<input type="hidden" value="{{ $districtslist->id }}" name="row_id">
								<div class="modal-body">
                      @if(Auth::user()->user_type_id == 1)
                       <div class="form-group">
                        <label for="user_id">Full Name</label>
                         <select class="form-control select2" name="user_id" id="user_id"
                            style="width: 100%;">
                            <option value="">Select Full Name</option>
                            @foreach ($distusers as $district)
                                <option {{ $districtslist->user_id == $district->id ? 'selected' : '' }}
                                    value="{{ $district->id }}">{{ $district->username }} -- > {{ $district->full_name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
						
				     <div class="form-group row">
						<label for="e_form_date" class="col-sm-4 col-form-label"><span
								style="color:red"></span>E Form Date</label>
						<div class="col-sm-7">
							<input type="date" class="form-control" name="e_form_date" value="{{ $districtslist->e_form_date }}">
						</div>
					</div>
						@else
                      <input type="hidden" value="{{ $districtslist->user_id }}" name="user_id">
				  <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input value="{{ $districtslist->full_name }}" type="text" required class="form-control"  name="full_name" id="full_name" placeholder="Enter Full Name">
                      </div>   
						<div class="form-group">
                        <label for="e_form_date">eForm Date</label>
                        <input value="{{ $districtslist->e_form_date }}" type="date" required class="form-control"  name="e_form_date" id="e_form_date" placeholder="Enter eForm Date">
                     </div>   
					 <div class="form-group">
                        <label for="signature_phone">Mobil Number</label>
                        <input value="{{ $districtslist->signature_phone }}" type="text" required class="form-control"  name="signature_phone" id="signature_phone" placeholder="Enter Mobil Number">
                     </div>   
					 
                        @endif
						
				     <div class="form-group row">
						<label for="signature_name" class="col-sm-4 col-form-label"><span
								style="color:red"></span>Signature</label>
						<div class="col-sm-7">
							<input type="file" required class="form-control" accept="image/png" name="signature_name" value="Upload Image">
						</div>
					</div>
				  <center> <img style="width:200px" src="{{ URL::to('/') }}/upload/off/{{ $districtslist->signature_name }}" /></center>
				   
						
									
												
									</div>
									<div class="modal-footer justify-content-between">
									   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									   <button id="save" type="submit" class="btn btn-primary">Submit</button>
									</div>
								 </form>
							  </div>
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
<div class="modal fade" id="districts">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add District Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/adddistricts')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                     <div class="form-group">
                        <label for="full_name">District Name</label>
                        <input type="text" class="form-control"  name="district_name" id="district_name" placeholder="Enter District Name">
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