@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>View Posting</h1>
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
                           <th>ID</th>
                           <th>Full Name</th>
                           <th>Phone</th>
                           <th>District Name</th>
                           <th>User Type</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($avilableposting as $key=>$avilablepostinglist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $avilablepostinglist->full_name }}</td>
                           <td>{{ $avilablepostinglist->phone }}</td>
                           <td>{{ $avilablepostinglist->district_name }}</td>
                           <td>{{ $avilablepostinglist->group_name }}</td>
                           <td>{{ $avilablepostinglist->status }}</td>
                           <td>
                             
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#status{{ $avilablepostinglist->id }}"><i class="fa fa-eye"></i>  Status</button>
                              <div class="modal fade" id="status{{ $avilablepostinglist->id }}">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Status Update </h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <form action="updateavilableposting" method="post" class="form-horizontal">
                                          {{ csrf_field() }}
                                      <input type="hidden" value="{{ $avilablepostinglist->id }}" name="id">
                                          <div class="modal-body">
                                             <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                   <div class="form-group row">
                                                      <label for="status" class="col-sm-4 col-form-label"><span style="color:red"></span>Status</label>
                                                      <div class="col-sm-8">
                                                         <select class="form-control select2bs4" name="status" id="status" required="requiered" style="width: 100%;" required="required">
                                                            <option value="{{ $avilablepostinglist->status }}">{{ $avilablepostinglist->status }}</option>
                                                            <option value="Active">Active </option>
                                                            <option value="Inactive">Inactive</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-3"></div>
                                             </div>
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type='submit' class='btn btn-primary'>Submit</button>
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
</section>

@endsection