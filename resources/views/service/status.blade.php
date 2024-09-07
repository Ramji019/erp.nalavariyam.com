@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            @if ($service_Pending == 'Pending')
            <h1>View Pending</h1>
            @elseif($service_Img == 'Img')
            <h1>View Completed</h1>
            @elseif($service_Rejected == 'Rejected')
            <h1>View Resubmit</h1>
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
                           <th>S No</th>
                           <th>District Name</th>
                           <th>Amount</th>
                           <th>Mobile</th>
                           <th>Date</th>
                           <th>Time</th>
                           <th>Message</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($servicestatus as $key => $servicestatuslist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $servicestatuslist->district_name }}</td>
                           <td>{{ $servicestatuslist->amount }}</td>
                           <td>{{ $servicestatuslist->phone }}</td>
                           <td>{{ $servicestatuslist->paydate }}</td>
                           <td>{{ $servicestatuslist->time }}</td>
                           <td>
                           @if($servicestatuslist->service_status == 'Rejected')
                              <a onclick="show_reason('{{ $servicestatuslist->remark_name }}')"  class="btn btn-default"><i class="fa fa-eye"></i></a>
                           @else

                           @endif
                              </td>
                           <td>
                              @if($servicestatuslist->service_status == "Pending")
                                             @if (Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3 || Auth::user()->id == 21 || Auth::user()->id == 32 || Auth::user()->id == 4916 || Auth::user()->id == 65 || Auth::user()->id == 41 || Auth::user()->id == 97 || Auth::user()->id == 11719 ||
                                             Auth::user()->id == 3185)
                              <button type="button" class="btn btn-default" data-toggle="modal"
                                 data-target="#OutPut{{ $servicestatuslist->id }}"><i
                                 class="fa fa-eye"></i> OutPut</button>
								 @else
									<button type="button" class="btn btn-primary btn-sm"> Waiting</button>
								 @endif
                              <div class="modal fade" id="OutPut{{ $servicestatuslist->id }}">
                                 <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">
                                             {{ $servicestatuslist->service_name }}
                                          </h4>
                                          <button type="button" class="close"
                                             data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <form action="{{ url('/serviceupdatestatus') }}"
                                          method="post">
                                          {{ csrf_field() }}
                                          <div class="modal-body">
                                             @if($servicestatuslist->customer_user_type_id == 18 || $servicestatuslist->customer_user_type_id == 19 || $servicestatuslist->customer_user_type_id == 20 || $servicestatuslist->customer_user_type_id == 21)
                                             <div class="row">
                                                <div class="col-md-12 text-center">
                                                   <label>Name: {{ $servicestatuslist->full_name }}</label>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-12 text-center">

                                                   <label>Phone: {{ $servicestatuslist->phone2 }}</label>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-12 text-center">
                                                   <label>Registration No: {{ $servicestatuslist->registeration_no }}</label>
                                                </div>
                                             </div>
                                             @endif
                                             <div class="form-group text-center">
                                                <img src="{{ URL::to('/') }}/upload/output/{{ $servicestatuslist->from_image }}"
                                                   style="opacity: .8; width:700px;">
                                             </div>

                                             @if (Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3 || Auth::user()->id == 21 || Auth::user()->id == 32 || Auth::user()->id == 4916 || Auth::user()->id == 65 || Auth::user()->id == 41 || Auth::user()->id == 97 || Auth::user()->id == 11719 || Auth::user()->id == 3185)
                                             @if ($service_Pending == 'Pending' || $service_Rejected == 'Rejected')
                                             <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                   <input type="hidden" name="service_id"
                                                      value="{{ $servicestatuslist->userID }}">
                                                   <div class="form-group row">
                                                      <label for="upi"
                                                         class="col-sm-4 col-form-label"><span
                                                         style="color:red">*</span>Status</label>
                                                      <div  class="col-sm-8">
                                                         <select id="brand"
                                                            class="form-control select2bs4"
                                                            name="service_status"
                                                            id="service_status"
                                                            required="requiered"
                                                            style="width: 100%;"
                                                            >
                                                            <option
                                                               value="{{ $servicestatuslist->service_status }}">
                                                               {{ $servicestatuslist->service_status }}
                                                            </option>
                                                            <option id="appr" value="Img">
                                                               Approve
                                                            </option>
                                                            <option id="resub" value="Rejected">
                                                               Resubmit
                                                            </option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div id="svn" style="display: none" class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Reason</label>
                                                    <div class="col-sm-8">
                                                    <select type="text" name="reason" class="form-control">
                                                    <option value="">Select </option>
                                                    @foreach ($remarks as $rem)
                                                    <option value="{{ $rem->id }}">
                                                    {{ $rem->remark_name }}</option>
                                                    @endforeach
                                                    </select>
                                           </div>
                                        </div>
                                                </div>
                                                <div class="col-md-3"></div>
                                             </div>
                                             @endif
                                             @endif
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                             <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                             @if (Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3 || Auth::user()->id == 21 || Auth::user()->id == 32 || Auth::user()->id == 4916 || Auth::user()->id == 65 || Auth::user()->id == 41 || Auth::user()->id == 97 || Auth::user()->id == 11719 || Auth::user()->id == 3185)
                                             <button type='submit'
                                                class='btn btn-primary'>Submit</button>
                                             @else
                                             <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>@endif
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              @else
                              <a onclick="show_image_upload('{{ $servicestatuslist->service_id  }}','{{ $servicestatuslist->customer_id }}','{{ $servicestatuslist->customer_user_type_id }}')" class="btn btn-sm btn-info">Reject Form</a>
                              @endif
                           </td>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
                  <div class="modal fade" id="image_modal">
                     <form action="{{ url('/createapplication') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="imservice_id" name="imservice_id" value="">
                        <input type="hidden" id="imcustomer_id" name="imcustomer_id" value="">
                        <input type="hidden" id="imcustomer_user_type_id" name="imcustomer_user_type_id" value="">
                        {{ csrf_field() }}
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Upload Image</h4>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Image(800 x 1100)</label>
                                    <div class="col-sm-8">
                                       <input accept="image/png,image/jpeg,image/jpg" type="file" name="photo" id="photo" required="required" class="form-control" />
                                    </div>
                                 </div>
                                 <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input class="btn btn-primary" type="submit" value="Submit" />
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>

                  <div class="modal fade" id="showreason">

                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Reason</h4>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                <div class="col-sm-2"></div>
                                <p class="col-sm-10" id="reasonshow"></p>
                                 <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
@endsection
@push('page_scripts')
<script>
   function show_image_upload(service_id,customer_id,customer_user_type_id){
   $("#imservice_id").val(service_id);
   $("#imcustomer_id").val(customer_id);
   $("#imcustomer_user_type_id").val(customer_user_type_id);
   $("#image_modal").modal("show");
   }

   function show_reason(remark_name){
   $("#reasonshow").html(remark_name);
   $("#showreason").modal("show");
   }

    $('#brand').change(function() {
       var brandValue = $(this).val();
       var servicestatuslist = $(this).val();
    if(brandValue == "Rejected") {
        $("svn").attr('required',true);
        $("#svn").show("slow");
    }else if (brandValue == "Img") {
        $("#svn").hide("slow");
    }
})
</script>
@endpush
