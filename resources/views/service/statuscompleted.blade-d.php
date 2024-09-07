@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>View Completed</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <div class="row">
                  <div class="form-group">
                     <input type="date" class="form-control" name="from" id="from"
                        value="{{ $from }}">
                  </div>
                  <div class="form-group">
                     <input type="date" class="form-control" name="to" id="to"
                        value="{{ $to }}">
                  </div>
               </div>
               <div>
                  <input id="btntop" type="button" onclick="load_report()" value="Show"
                     class="col-sm-12 btn btn-success">
               </div>
            </ol>
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
                  <div class="col-12">
                     <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                           <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#completed" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Completed</a>
                              </li>
							  <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom1" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Applied</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom2" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Vao Approved </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom3" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Resubmit </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom4" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Clarification Replied </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom5" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Approved </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom6" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Rejected </a>
                              </li>
                           </ul>
                        </div>
                        <div class="card-body">
                           <div class="tab-content" id="custom-tabs-four-tabContent">
                              <div class="tab-pane fade show active" id="completed" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example2" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($completed as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)

                                                <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                                                                                                                            <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>

                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
							  <div class="tab-pane fade" id="custom1" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example8" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom1 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)

<a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                                                                                                                             <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>

                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="custom2" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example3" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom2 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)
                                             <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                         <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>


                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
							  <div class="tab-pane fade" id="custom3" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example4" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom3 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)
                                                <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                                                                                                                          <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>


                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
							   <div class="tab-pane fade" id="custom4" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example5" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom4 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)
                                                <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                                                                                                                             <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>


                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
							   <div class="tab-pane fade" id="custom5" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example6" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom5 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)
                                             <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                                                                              <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>

                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
							   <div class="tab-pane fade" id="custom6" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                 <div class="table-responsive" style="overflow-x: auto; ">
                                    <table id="example7" class="table table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>S No</th>
                                             <th>Date</th>
                                             <th>District Name</th>
                                             <th>CID SID</th>
                                             <th>Customer Name</th>
                                             <th>App NO</th>
                                             <th>Mobile</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($custom6 as $key => $appliedstatuslist)
                                          <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $appliedstatuslist->paydate }}</td>
                                             <td>{{ $appliedstatuslist->district_name }}</td>
                                             <td>C{{ $appliedstatuslist->customersID }}, S{{ $appliedstatuslist->service_id }}</td>
                                             <td>{{ $appliedstatuslist->full_name_tamil }}</td>
                                             <td>{{ $appliedstatuslist->app_no }}</td>
                                             <td>{{ $appliedstatuslist->phone }}</td>
                                             <td>
                                                @if (Auth::user()->user_type_id == 1 ||
                                                Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 3 ||
                                                Auth::user()->user_type_id == 16 ||
                                                Auth::user()->user_type_id == 17)
                                               <a onclick="show_output('{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->from_image }}','{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->app_no }}','{{ $appliedstatuslist->mobile_no }}')" type="button" class="btn btn-primary btn-sm">Output</a>

                                                @else
                                               <a href="{{ URL::to('/') }}/upload/output/{{ $appliedstatuslist->from_image }}" type="button" class="btn btn-primary btn-sm" download>Download</a>
                                                @endif
                                                @if ($appliedstatuslist->bill == 1)
                                                <a onclick="create_bill('{{ $appliedstatuslist->userID }}','{{ $appliedstatuslist->service_name }}','{{ $appliedstatuslist->service_payment }}')"
                                                   type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                <a href="{{ url('/receipt') }}/{{ $appliedstatuslist->customer_id }}/{{ $appliedstatuslist->userID }}"
                                                   type="button" class="btn btn-primary btn-sm">View
                                                Bill</a>
                                                @endif
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
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>

    <div class="modal fade" id="output">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="servicename"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    <form action="{{ url('/updatecompleteddetails') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
                <div class="modal-body">
                    <center> <img src="" id="photo" style="opacity: .8; width:700px;">
					</center>
					
              <input type="hidden" name="payment_id" id="paymentid">
                   <div class="form-group">
						<label for="service_name">Mobile Number</label>
						<input required type="text" maxlength="10" class="form-control number" id="mobileno" name="mobile_no"
							 placeholder="Enter Mobile Number">
					</div>

					<div class="form-group">
						<label for="service_payment">Application Number</label>
						<input required type="text" maxlength="13" class="form-control number" id="appno"  name="app_no"
							 placeholder="Application Number">
					</div>
							  <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="online_status" id="onlinestatus" style="width: 100%;">
							<option value="1">Applied</option>
							<option value="2">Vao Approved </option>
							<option value="3">Resubmit</option>
							<option value="4">Clarification Replied </option>
							<option value="5">Approved </option>
							<option value="6">Rejected</option>
                            </select>
                        </div>
						

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Submit</button>
                    </div>
                </div>
				</form>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="bill">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="service_name"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/completedbill') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
               <input type="hidden" id="serviceid" name="payment_id">
               <div class="form-group">
                  <label for="servicepayment">Service Payment</label>
                  <input type="text" class="form-control" id="servicepayment" readonly>
               </div>
               <div class="form-group">
                  <label for="adsional_amount">Additional Payment</label>
                  <input type="text" class="form-control" name="adsional_amount" id="adsional_amount"
                     placeholder="Enter Additional Amount">
               </div>
               <div class="form-group">
                  <label for="reference_id">Referral Id</label>
                  <input type="text" class="form-control" name="reference_id" id="reference_id"
                     placeholder="Enter Referral Id">
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
         </form>
         </div>
      </div>
   </div>
</div>
@endsection
@push('page_scripts')

    <script>
        function show_output(servicename, photo,paymentid,appno,online_status,mobile) {
            $("#servicename").text(servicename);
            $("#paymentid").val(paymentid);
            $("#appno").val(appno);
            $("#onlinestatus").val(online_status);
            $("#mobileno").val(mobile);
            $("#photo").attr("src", '/upload/output/' + photo);
            $("#output").modal("show");
        }

        function create_bill(id, servicename, payment) {
            $("#service_name").text(servicename);
            $("#servicepayment").val(payment);
            $("#serviceid").val(id);
            $("#bill").modal("show");
        }

        var completed = "{{ url('completed') }}";

        function load_report() {
            var from = $("#from").val();
            var to = $("#to").val();
            if (from == "") {
                alert("Please select from Date");
            } else if (to == "") {
                alert("Please select To Date");
            } else {
                var url = completed + "/" + from + "/" + to;
                window.location.href = url;
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#Output").addClass('menu-open');
            $("#OutputApplication").addClass('active');
            $("#Completed").addClass('active');
        });
    </script>
@endpush
