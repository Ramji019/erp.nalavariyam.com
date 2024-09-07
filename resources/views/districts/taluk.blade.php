@extends('layouts.app')
@section('content')
<section class="content-header">
 <div class="container-fluid">
  <div class="row mb-2">
   <div class="col-sm-6">
    <h1>Taluks</h1>
  </div>
  <div class="col-sm-6">
    @if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 3))
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#taluk"><i class="fa fa-plus"> Add Taluk </i></button></li>
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
     <table id="example2" class="table table-bordered table-striped">
       <thead>
        <tr>
          <th> S No</th>
          <th> Taluk Name</th>
          <th> Status</th>
          <th> Action</th>

        </tr>
      </thead>
      <tbody>
        @foreach($taluk as $key => $taluklist)
        <tr>
         <td>{{ $key + 1 }}</td>
         <td>{{ $taluklist->taluk_name }}</td>
         <td>{{ $taluklist->status }}</td>
         <td>
          <a data-toggle="modal" data-target="#edittaluk{{ $taluklist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
          <div class="modal fade" id="edittaluk{{ $taluklist->id }}">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                 <div class="modal-header">
                  <h4 class="modal-title">Edit Taluk Details</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
                 <form action="{{url('/edittaluk')}}" method="post">

                  {{ csrf_field() }}
                <input type="hidden" value="{{ $taluklist->id }}" name="taluk_id">
		
		
                  <div class="modal-body">
                       <div class="form-group">
                        <label for="parent">District Name</label>
<select class="form-control select2" name="parent" id="parent"
                            style="width: 100%;">
                            <option value="">Select District Name</option>
                            @foreach ($managedistrict as $district)
                                <option {{ $district_id == $district->id ? 'selected' : '' }}
                                    value="{{ $district->id }}">{{ $district->district_name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                
				
                       <div class="form-group">
                        <label for="taluk_name">Taluk Name</label>
                        <input type="text" value="{{ $taluklist->taluk_name }}" class="form-control"  name="taluk_name" id="taluk_name" placeholder="">
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
          <a href="{{ route('panchayath',$taluklist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="Delete"> View Panchayath</i></a>
          <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletetaluk' ,$taluklist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>
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
</section>
<div class="modal fade" id="taluk">
 <div class="modal-dialog modal-md">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Add Taluk Details</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <form action="{{url('/addtaluk')}}" method="post">
    <input type="hidden" name="parent" id="parent" value="{{ $district_id }}">

    {{ csrf_field() }}
    <div class="modal-body">
     <div class="row">
	 
		
	<div class="col-md-6">
       <div class="form-group">
        <label for="taluk_name">Taluk Name</label>
        <input type="text" class="form-control"  name="taluk_name" id="taluk_name" placeholder="Enter Taluk Name">
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