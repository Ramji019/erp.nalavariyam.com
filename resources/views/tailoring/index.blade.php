@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Tailoring</h1>
         </div>
         <div class="col-sm-6">
            @if (Auth::user()->tailoring_user == 1  || Auth::user()->user_type_id == 13 || Auth::user()->user_type_id == 12)
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                  data-toggle="modal" data-target="#tailoring"><i class="fa fa-plus"> Add </i></button>
               </li>
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
                              <th> Name</th>
                              <th> Phone No</th>
                              <th> Status</th>
                              @if(Auth::user()->user_type_id == 1)
                              <th> User Id</th>
                              @endif
                              <th> Action </th>

                           </tr>
                        </thead>
                        <tbody>
                           @foreach($tailoring as $key => $tailoringlist)
                           <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $tailoringlist->name }}</td>
                              <td>{{ $tailoringlist->phone_number }}</td>
                              <td>{{ $tailoringlist->status }}</td>
                              @if(Auth::user()->user_type_id == 1)
                              <td> {{ $tailoringlist->user_id }}</td>
                              @endif
                              <td>

                                 <!--  <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletetailoring' , $tailoringlist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a> -->
                                 @if($tailoringlist->payment_status == "New" && Auth::user()->user_type_id != 1)
                                 <input onclick="pay_now()" type="button" value="Pay Now" class="btn btn-primary btn-sm">
                                 <input value="{{ $tailoringlist->id }}" type="hidden"  id="cusid" />
                                 @elseif($tailoringlist->payment_status == "Pending")
                                 @if(Auth::user()->user_type_id == 1)
                                 @foreach ($tailoringlist->address as $k => $p)
                                 <a onclick="approve('{{ $tailoringlist->id }}','{{ $tailoringlist->name }}','{{ $tailoringlist->address_1 }}','{{ $tailoringlist->address_2 }}','{{ $tailoringlist->district }}','{{ $tailoringlist->taluk }}','{{ $tailoringlist->profile_image }}','{{ $p->permanent_address_1 }}','{{ $tailoringlist->user_id }}')" type="button" class="btn btn-info btn-sm">Approve</a>
                                 @endforeach
                                 @else
                                 <input type="button" value="Waiting for Approval" class="btn btn-primary btn-sm">  
                                 @endif
                                 @elseif($tailoringlist->payment_status == "Rejected")
                                 <a onclick="resubmit('{{ $tailoringlist->id }}','{{ $tailoringlist->name }}','{{ $tailoringlist->address_1 }}','{{ $tailoringlist->address_2 }}','{{ $tailoringlist->district }}','{{ $tailoringlist->taluk }}','{{ $tailoringlist->profile_image }}','{{ $tailoringlist->payment_status }}','{{ $tailoringlist->reason }}')" type="button" class="btn btn-info btn-sm">Resubmit</a>
                                 @elseif($tailoringlist->payment_status == "Completed")
                                 <input type="button" value="Approved" class="btn btn-success btn-sm">
                                 @endif
                              </td>   
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
<div class="modal fade" id="tailoring">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Tailoring Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/addtailoring') }}" method="post" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="container">
                  <div class="row">
                     <div class="col-sm">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm">

                                 <div class="form-group">
                                    <label for="full_name">Name</label>
                                    <input type="text" class="form-control" name="name" id="full_name"
                                    placeholder="Enter Name">
                                 </div>
                                 <div class="form-group">
                                    <label for="signication">Signification</label>
                                    <select class="form-control" name="signification" id="signification" style="width:100%;">
                                       <option value="">
                                        Signification 
                                     </option>
                                     <option value="S/O">S/O</option>
                                     <option value="D/O">D/O</option>
                                     <option value="W/O">W/O</option>
                                  </select>
                               </div>
                               <div class="form-group">
                                 <label for="address_1">Address 1</label>
                                 <input type="text" class="form-control" name="address_1" id="address_1"
                                 placeholder="Enter Address 1">
                              </div>
                              <div class="form-group">
                                 <label for="address_2">Address 2</label>
                                 <input type="text" class="form-control" name="address_2" id="address_2"
                                 placeholder="Enter Address 2">
                              </div>
                              <div class="form-group">
                                 <label for="pin_code">Pin Code</label>
                                 <input type="text" class="form-control" name="pin_code" id="pin_code"
                                 placeholder="Enter Pin Code">
                              </div>
                           </div>

                           <div class="col-sm">
                              <div class="form-group">
                                 <label for="phone_number">Phone No</label>
                                 <input type="text" class="form-control" name="phone_number" id="phone_number"
                                 placeholder="Enter Phone Number">
                              </div>
                              <div class="form-group">
                                 <label>Taluk</label>
                                 <input type="text" class="form-control" name="taluk" id="taluk"
                                 placeholder="Enter Taluk">                                   
                              </div>
                              <div class="form-group">
                                 <label>District</label>
                                 <input type="text" class="form-control" name="district" id="district"
                                 placeholder="Enter District">
                              </div>
                              <div class="form-group">
                                 <label for="aadhar_number">Aadhar Number</label>
                                 <input type="text" class="form-control" name="aadhar_number" id="aadhar_number"
                                 placeholder="Enter aadhar Number">
                              </div>

                              <div class="form-group">
                                <label>Photo</label>

                                <input type="file" class="form-control" name="profile_image" >
                             </div>
                          </div>
                       </div>
                    </div>
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

<div class="modal fade" id="paynow_modal">
   <form action="{{ url('/tailoringpayment_update') }}" method="post">
     {{ csrf_field() }}
     @if(Auth::user()->tailoring_user == 1)
     <input value="150" type="hidden" name="payment_amount" id="payment_amount" />
     @elseif(Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13)
     <input value="300" type="hidden" name="payment_amount" id="payment_amount" />
     @endif
     <input value="{{ Auth::user()->wallet }}" type="hidden" name="wallet_amount" id="wallet_amount" />
     <input  type="hidden" name="customerid" id="customer_id" />

     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Pay Now</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
          </button>
       </div>
       <div class="modal-body">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Amount</label>
          <div class="col-sm-8">
            <input readonly name="pay_amount" id="pay_amount" required="required" maxlength="50"
            class="form-control number" />
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


<div class="modal fade" id="referral_modal">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title">Request Amount</h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <form action="{{ url('paymentrequest') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="modal-body">
       @php
       $superadminreferral = DB::table( 'users' )->select('full_name','phone','upi','id','payment_qr_oode')->where('id',1)->first();
       @endphp
       <center>
        {{ $superadminreferral->full_name }}</br>
        {{ $superadminreferral->phone }}</br>
        {{ $superadminreferral->upi }}</br>
        <img style="width:200px"
        src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $superadminreferral->payment_qr_oode }}" />
        <input type="hidden" class="form-control" name="to_id"
        value="{{ $superadminreferral->id }}">
     </center>

     <div class="form-group row">
      <label for="" class="col-sm-12 col-form-label"><span
       style="color:red"></span>Request Amount</label>
       <input  type="text" class="form-control" name="amount" placeholder='Enter Request Amount' required="required">
    </div>
    <div class="form-group">
      <label for="" class="col-sm-12 col-form-label"><span
       style="color:red"></span>Paid Image(ScreenShot)</label>
       <div class="custom-file">
         <input accept="image/png,image/jpeg,image/jpg" type="file" class="custom-file-input" name="paid_image" required="required">
         <label class="custom-file-label" for="customFile">Choose file</label>
      </div>
   </div>

</div>

<div class="modal-footer justify-content-between">
 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 <button type='submit' id='plansubmit' class='btn btn-primary'>Request Now</button>
</form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="approvemodal">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title">Approve</h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <form action="{{ url('approve_certificate') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="modal-body">

        <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Customer Name </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="apprname"></span> </label>
       </div>
       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Address 1
         </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="appraddress1"></span> </label>
       </div>
       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Address 2
         </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="appraddress2"></span> </label>
       </div>
       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
         </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="apprdist"></span> </label>
       </div>

       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Taluk
         </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="apprtaluk"></span> </label>
       </div>
       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Center Address
         </label>
         <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="address"></span> </label>
       </div>
       <div class="modal-body text-center">
                    <span>Photo</span>
                    <center>
                        <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="profilephoto" />
                    </center>
                    <a id="profilephotodownload" href="" type="button" class="btn btn-primary btn-sm"
                        download>Download</a>
                    <hr>
                </div>
       <div class="form-group row">
         <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
         </label>
         <select class="form-control col-sm-8" id="apprstatus" name="payment_status"  style="width: 50%;">
           <option>Select</option>
           <option value="Completed">Completed</option>
           <option value="Rejected">Resubmit</option>
        </select>
     </div>

     <div class="form-group row" style="display: none;" id="aprreasonhide">
       <label for="customer_name" class="col-sm-4 col-form-label"><span
        style="color:red"></span>Reason</label>
        <div class="col-sm-8">
         <textarea rows="3" type="text" class="form-control"
         name="reason" id="aprreason" maxlength="100"></textarea>
      </div>
   </div>

   <input type="hidden" id="tailoringcustomerid" class="form-control" name="customerid">
   <input type="hidden" id="tailoringuserid" class="form-control" name="userid">


</div>

<div class="modal-footer justify-content-between">
 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 <button type='submit'class='btn btn-primary'>Submit</button>
</form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="resubmitmodal">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title">Resubmit</h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <form action="{{ url('resubmit_certificate') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="modal-body">



        <div class="form-group row">
          <label for="customer_name" class="col-sm-4 col-form-label"><span
           style="color:red"></span>Name</label>
           <div class="col-sm-8">
            <input required="required" type="text" class="form-control"
            name="name" id="resname" maxlength="50"
            placeholder="Name">
         </div>
      </div>

      <div class="form-group row">
       <label for="customer_name" class="col-sm-4 col-form-label"><span
        style="color:red"></span>Address 1</label>
        <div class="col-sm-8">
         <input required="required" type="text" class="form-control"
         name="address_1" id="resaddress1" maxlength="100"
         placeholder="Name">
      </div>
   </div>

   <div class="form-group row">
    <label for="customer_name" class="col-sm-4 col-form-label"><span
     style="color:red"></span>Address 2</label>
     <div class="col-sm-8">
      <input required="required" type="text" class="form-control"
      name="address_2" id="resaddress2" maxlength="100"
      placeholder="Name">
   </div>
</div>

<div class="form-group row">
 <label for="customer_name"  class="col-sm-4 col-form-label"><span
  style="color:red"></span>District</label>
  <div class="col-sm-8">
   <input required="required" type="text" class="form-control"
   name="district" id="resdist" maxlength="50"
   placeholder="Name">
</div>
</div>

<div class="form-group row">
 <label for="customer_name" class="col-sm-4 col-form-label"><span
  style="color:red"></span>Taluk</label>
  <div class="col-sm-8">
   <input required="required" type="text" class="form-control"
   name="taluk" id="restaluk" maxlength="50"
   placeholder="Name">
</div>
</div>

<div class="form-group row">
 <label for="customer_name" class="col-sm-4 col-form-label"><span
  style="color:red"></span>Photo</label>
  <div class="col-sm-8">
   <input accept="image/*" type="file" class="form-control"
   name="profile_image" id="resphoto">
</div>
</div>

<div class="form-group row">
 <label for="relation_ship" class="col-sm-4 col-form-label"><span
  style="color:red"></span>Status</label>
  <div class="col-sm-8">
   <select required="required" class="form-control"
   id="resstatus" name="card_type">
   <option value="Rejected">Resubmit</option>
</select>
</div>
</div>

<div class="form-group row">
 <label for="customer_name" class="col-sm-4 col-form-label"><span
  style="color:red"></span>Reason</label>
  <div class="col-sm-8">
   <textarea rows="3" type="text" class="form-control"
   name="reason" id="resreason" maxlength="100"></textarea>
</div>
</div>

<input type="hidden" id="resubmitcustomerid" class="form-control" name="customerid">


</div>
<div class="modal-footer justify-content-between">
 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 <button id="resubmitbtn" type='submit'class='btn btn-primary'>Submit</button>
</form>
</div>
</div>
</div>

@endsection
@push('page_scripts')

<script>
   function pay_now() {
    var wallet_amount = parseFloat($("#wallet_amount").val());
    var payment_amount = parseFloat($("#payment_amount").val());
    var customerid = $("#cusid").val();
    $("#pay_amount").val(payment_amount);
    $("#customer_id").val(customerid);
    if (payment_amount > wallet_amount) {
      $("#referral_modal").modal("show");
   } else {
      $("#paynow_modal").modal("show");
   }
}

function approve(id,name,address1,address2,district,taluk,profileimage,address,userid) {
 $("#tailoringcustomerid").val(id);
 $("#tailoringuserid").val(userid);
 $("#apprname").text(name);
 $("#appraddress1").text(address1);
 $("#appraddress2").text(address2);
 $("#apprdist").text(district);
 $("#apprtaluk").text(taluk);
 $("#address").text(address);
 $("#approvemodal").modal("show");
 $('#apprstatus').change(function() {
  if ($(this).val() == "Rejected") {

    $('#aprreasonhide').show();
    $('#aprreason').attr("required", true);

 }else{
   $('#aprreasonhide').hide();
   $('#aprreason').attr("required", true);
}
});
  $("#profilephoto").attr("src", "../upload/tailoringprofile/" + profileimage);
            $('a#profilephotodownload').attr({
                href: '../upload/tailoringprofile/' + profileimage
            });
}
var user_type_id = "{{ Auth::user()->id }}";
function resubmit(id,name,address1,address2,district,taluk,profileimage,status,reason) {
 $("#resubmitcustomerid").val(id);
 $("#resname").val(name);
 $("#resaddress1").val(address1);
 $("#resaddress2").val(address2);
 $("#resdist").val(district);
 $("#restaluk").val(taluk);
 $("#resstatus").val(status);
 $("#resreason").val(reason);
 $("#resubmitmodal").modal("show");

 if (user_type_id == "1" && status == "Rejected" ){
  $("#resubmitbtn").attr("disabled", true);
  $("#resname").attr("readonly", true);
  $('#resaddress1').attr("readonly", true);
  $('#resaddress2').attr("readonly", true);
  $("#resdist").attr("readonly", true);
  $("#restaluk").attr("readonly", true);
  $("#resstatus").attr("readonly", true);
  $("#resreason").attr("readonly", true);
  $("#resphoto").attr("readonly", true);
} else {

  $("#resstatus").attr("readonly", true);
  $("#resreason").attr("readonly", true);
} 

}

$(function() {


});

</script>

@endpush
