@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Bulk Service Lists</h1>
         </div>
         <div class="col-sm-6">
            @if(Auth::user()->user_type_id == 1) 
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#Addbulkservicelists"><i class="fa fa-plus"> Add </i></button></li>
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
               <div class="card-header">
                  <h3 class="card-title">bulkservicelists</h3>
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
                  <table id="example2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                          <th> S No</th>
						  <th> bulkservicelist Name</th>
						  <th> bulkservicelist Payment</th>
						  <th> Status</th>
                          <th> Edit</th>
                          <th> Delete</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($bulkservice  as $key=>$bulkservicelist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $bulkservicelist->service_name }}</td>
                           <td>{{ $bulkservicelist->service_payment }}</td>
                           <td>{{ $bulkservicelist->status }}</td>
                           <td>
						    <a href="" class="btn btn-info"><i class="fa fa-edit"title="Edit"> </i></a>
                            </td>
                           <td>
						   <a href="" class="btn btn-info"><i class="fa fa-trash"title="Delete"> </i></a>
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
<div class="modal fade" id="Addbulkservicelists">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add bulkservicelists</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/addbulkservicelist')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     
                     <div class="form-group">
                        <label for="bulkservicelist_name">bulkservicelist Name</label>
                        <input type="text" class="form-control"  name="bulkservicelist_name" id="bulkservicelist_name" placeholder="Enter bulkservicelist Name">
                     </div>
                    
                     <div class="form-group">
                        <label for="bulkservicelist_payment">bulkservicelist Payment"</label>
                        <input type="text" class="form-control" name="bulkservicelist_payment" id="bulkservicelist_payment" placeholder="Enter bulkservicelist Payment">
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