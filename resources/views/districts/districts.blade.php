@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Districts</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 3))
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#districts"><i class="fa fa-plus"> Add Districts </i></button></li>
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
						  <th> District Name</th>
						  <th> Status</th>
                          <th> Action</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($districts as $key=>$districtslist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $districtslist->district_name }}</td>
                           <td>{{ $districtslist->status }}</td>
                           <td>
                      <a data-toggle="modal" data-target="#EditDistricts{{ $districtslist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
					    <div class="modal fade" id="EditDistricts{{ $districtslist->id }}">
							<div class="modal-dialog modal-md">
							  <div class="modal-content">
								 <div class="modal-header">
									<h4 class="modal-title">Edit District Details</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								 </div>
								 <form action="{{url('/editdistricts')}}" method="post">
									{{ csrf_field() }}
								<input type="hidden" value="{{ $districtslist->id }}" name="districts_id">
									<div class="modal-body">
											 <div class="form-group">
												<label for="full_name">District Name</label>
												<input type="text" value="{{ $districtslist->district_name }}" class="form-control"  name="district_name" id="district_name" placeholder="">
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
                      <a href="{{ route('taluk',$districtslist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="view"> View Taluk</i></a>
                     <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletedistricts' ,$districtslist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>
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