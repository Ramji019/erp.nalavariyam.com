@extends('layouts.app')
@section('content')
<section class="content-header">
 <div class="container-fluid">
  <div class="row mb-2">
   <div class="col-sm-6">
    <h1>Panchayath</h1>
  </div>
  <div class="col-sm-6">
    @if((Auth::user()->user_type_id == 1) || (Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 3))
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#addpanchayath"><i class="fa fa-plus"> Add Panchayath </i></button></li>
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
          <th> Panchayath Name</th>
          <th> Status</th>
          <th> Action</th>

        </tr>
      </thead>
      <tbody>
        @foreach($panchayath as $key => $panchayathlist)
        <tr>
         <td>{{ $key + 1 }}</td>
         <td>{{ $panchayathlist->panchayath_name }}</td>
         <td>{{ $panchayathlist->status }}</td>
         <td>
          <a data-toggle="modal" data-target="#editpanchayath{{ $panchayathlist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
          <div class="modal fade" id="editpanchayath{{ $panchayathlist->id }}">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                 <div class="modal-header">
                  <h4 class="modal-title">Edit Panchayath Details</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
                 <form action="{{url('/editpanchayath')}}" method="post">

                  {{ csrf_field() }}
                <input type="hidden" value="{{ $panchayathlist->id }}" name="panchayath_id">
                  <div class="modal-body">
				  <div class="form-group">
                        <label for="parent">Taluk Name</label>
<select class="form-control select2" name="parent" id="parent"
                            style="width: 100%;">
                            <option value="">Select Taluk Name</option>
                            @foreach ($managetaluk as $taluk)
                                <option {{ $taluk_id == $taluk->id ? 'selected' : '' }}
                                    value="{{ $taluk->id }}">{{ $taluk->taluk_name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
						
                       <div class="form-group">
                        <label for="panchayath_name">Panchayath Name</label>
                        <input type="text" value="{{ $panchayathlist->panchayath_name }}" class="form-control"  name="panchayath_name" id="panchayath_name" placeholder="">
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
          <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletepanchayath' ,$panchayathlist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>
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
<div class="modal fade" id="addpanchayath">
 <div class="modal-dialog modal-md">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Add Panchayath Details</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <form action="{{url('/addpanchayath')}}" method="post">
    <input type="hidden" name="parent" id="parent" value="{{ $taluk_id }}">

    {{ csrf_field() }}
    <div class="modal-body">
     <div class="row">
      <div class="col-md-6">
       <div class="form-group">
        <label for="panchayath_name">Panchayath Name</label>
        <input type="text" class="form-control"  name="panchayath_name" id="panchayath_name" placeholder="Enter Panchayath Name">
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
