@extends('layouts.app')
@section('content')
<section class="content-header">
<div class="container-fluid">
<h5>
<center>
தற்போது உள்ள கணக்கின்படி அதிகபட்ச விண்ணப்பம் செய்தவரின் Completed 600 விண்ணப்பத்திற்கு மேல் இல்லை ஆகவே 600 விண்ணப்பம் வரை லாக் செய்யப்படுகிறது மேலும் அவர் தனது விண்ணப்பத்தின் எண்ணிக்கையை பூர்த்தி செய்ய கால அவகாசம் வழங்கப்பட்டுள்ளது 
</br></br>
மேலும் 11-8-2024 க்கு பின் 500விண்ணப்பத்தினை லாக் செய்யப்படும் அவ்வாறு படிப்படியாக விண்ணப்ப கணக்கை குறைக்கப்படும்.
</br></br>
ஆகவே உங்கள் Completed யில் இருக்கும் விண்ணப்பங்களின் எண் மற்றும் செல் நம்பர் சரியாக பதிவு செய்யவும்.
</br></br>
தவறான செல் நம்பர் மற்றும் விண்ணப்ப எண் வழங்கினாலும் லாக் ஆகிவிடும்</center>

</h5>
</div>
</section>

<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
@if($CompletedCount < 650)
@if($ResubmitCount < 650)

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
<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Online</a>
</li>
<li class="nav-item">
<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Offline</a>
</li>
</ul>
</div>
<div class="card-body">
<div class="tab-content" id="custom-tabs-four-tabContent">
<div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
<div class="table-responsive" style="overflow-x: auto; ">
<table id="" class="table table-bordered table-striped">    <thead>
        <tr>
            <th>S No</th>
            <th>Services</th>
            <th>Amount</th>
            <th>Download</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $key => $service)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $service->service_name }}</td>
            <td>₹ {{ $service->pay_amount }}</td>
            <td><a href="{{ URL::to('/') }}/upload/fromimg//{{ $service->from_image }}" class="btn btn-default" >Download</a></td>
            <td>
                @if($service->action == "Pay Now" && ($service->pay_amount <= $balance ))
                    <a onclick="show_paynow('{{ $service->id }}','{{ $service->pay_amount }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}','{{ $customer->dist_id }}','{{ $customer->taluk_id }}','{{ $customer->panchayath_id }}')" class="btn btn-sm btn-info">{{ $service->pay_amount == "0" ? "Free" : $service->action }}</a>
                    @elseif($service->action == "Pay Now" && ($service->pay_amount > $balance ))
                    <a onclick="show_referral('{{ $service->id }}','{{ $service->pay_amount }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                    @elseif($service->action == "Create Form" || $service->action == "Reject Form")
                    <a onclick="show_image_upload('{{ $service->id }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                    @elseif($service->action == "Pending")
                    <a class="btn btn-sm btn-info">{{ $service->action }}</a>
                    @elseif($service->action == "Waiting")
                    <a class="btn btn-sm btn-info">{{ $service->action }}</a>
					 @elseif($service->action == "Output" && $service->id == 1)
                    <a href="{{ URL::to('/') }}/upload/output/{{ $service->output_image }}" class="btn btn-sm btn-info" download>Download</a>
					 @else
                     @if($service->pay_amount <= $balance )

                     <a onclick="show_paynow('{{ $service->id }}','{{ $service->pay_amount }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}','{{ $customer->dist_id }}','{{ $customer->taluk_id }}','{{ $customer->panchayath_id }}')" class="btn btn-sm btn-info">{{ $service->pay_amount == "0" ? "Free" : $service->action }}</a>
				  @else
                    <a onclick="show_referral('{{ $service->id }}','{{ $service->pay_amount }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
 @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
	  </div></div>
<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
<div class="table-responsive" style="overflow-x: auto; ">
<form onsubmit="return validateqty()" method="post" action="{{ url('savebulkbuy') }}" id="form1">
       {{ csrf_field() }}
       <input type="hidden" id="bulk_customer_id" name="bulk_customer_id" value="{{ $customer->customer_id }}">
       <input type="hidden" name="delivery_amount" id="deliveryamount">
       <table id="example2" class="table table-bordered table-striped">
        <thead>
         <tr>
           <th> S No</th>
           <th> Service</th>
           <th style="text-align:right">Amount</th>
           <th style="text-align:right">Quantity</th>
         </tr>
       </thead>
       <tbody>
        @foreach($bulkservice  as $key=>$bulkservicelist)
        <tr>
         <td>{{ $key + 1 }}</td>
         <td>{{ $bulkservicelist->service_name }}</td>
         <td name="amount" style="text-align:right"><input size="1" readonly type="text" value="{{ $bulkservicelist->pay_amount }}" class="form-control serviceamt" />
            
         </td>
         <td style="text-align:right">
          @if($bulkservicelist->used == 1)  
          <input type="text" size="1" maxlength="3" name="services_{{ $bulkservicelist->id }}_{{ $bulkservicelist->pay_amount }}" class="form-control number serviceqty">
          @else
          <a class="btn btn-success" onclick="show_upload({{ $bulkservicelist->id }})">Upload</a>
          @endif
        </td>
      </tr>
      @endforeach
      <tr>
        <td style="text-align:right;font-weight:bold" colspan="2">Wallet Amount: ₹ <span id="wallet">{{ $balance }}</span></td>
        <td style="text-align:right;font-weight:bold" colspan="2">Total Amount: ₹ <span id="totamount"></span></td>
      </tr>
    </tbody>
  </table>
  <div class="row">
    <div class="col-12 text-center" >
     <input type="submit" name="Submit" value="Submit" class="btn btn-primary" id="submitbtn">
   </div>
 </div>
</form>
	  </div></div>
</div>
</div>
</div>
</div>

@else
<center>
புதிய விண்ணப்பம் செய்யும் முன் ஏற்கனவே விண்ணப்பம் செய்யதுள்ள விண்ணங்களின் குறைகளை சரி செய்யவும்.
</br>
 குறைந்தபட்சம் 15 விண்ணப்பம் வரை மட்டுமே உங்களுக்கு வாய்ப்பு வழங்கப்படுகிறது
</br>

<a href="{{ url('onlinestatus') }}/Resubmit/{{ date('Y-m-d', strtotime('-700 days')) }}/{{ date('Y-m-d') }}" class="nav-link "> Go to Resubmit <i class="fas fa-arrow-circle-right"></i></p></a>
</center>
@endif
@else

<center>
ஏற்கனவே விண்ணப்பம் செய்த விண்ணப்பத்தின் விண்ணப்ப எண் மற்றும் செல் நம்பர் தகவலை வழங்கவும்.
</br>
அதிகபட்சம் விண்ணப்பம் பெற்று 5 விண்ணப்பம் வரை மட்டுமே வாய்ப்பு வழங்கப்படுகிறது
</br>
<a href="{{ url('onlinestatus') }}/Completed/{{ date('Y-m-d', strtotime('-700 days')) }}/{{ date('Y-m-d') }}" class="nav-link "> Go to Completed <i class="fas fa-arrow-circle-right"></i></p></a>
</center>

	
@endif
    <div class="modal fade" id="paynow_modal">
        <form action="{{ url('/servicepayment') }}" method="post" id="servicepay">
            {{ csrf_field() }}
            <input type="hidden" id="service_id" name="service_id" value="">
            <input type="hidden" id="customer_id" name="customer_id" value="">
            <input type="hidden" id="customer_user_type_id" name="customer_user_type_id" value="">
            <input type="hidden" id="dist_id" name="dist_id" value="">
            <input type="hidden" id="taluk_id" name="taluk_id" value="">
            <input type="hidden" id="panchayath_id" name="panchayath_id" value="">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="paynow">Pay Now</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Amount</label>
                            <div class="col-sm-8">
                                <input readonly name="pay_amount" id="pay_amount" required="required"  maxlength="50" class="form-control number" />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input class="btn btn-primary" id="submitbtn" type="submit" value="Submit" />
                        </div>
                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" id="image_modal">
                            <form action="{{ url('/createapplication') }}" method="post" enctype="multipart/form-data" id="serviceimage">
                                <input type="hidden" id="imservice_id" name="imservice_id" value="">
                                <input type="hidden" id="imcustomer_id" name="imcustomer_id" value="">
                                <input type="hidden" id="imcustomer_user_type_id" name="imcustomer_user_type_id"
                                    value="">
                                {{ csrf_field() }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Upload Image</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Image(800 x 1100)</label>
                                                <div class="col-sm-8">
                                                    <input accept="image/png,image/jpeg,image/jpg" type="file"
                                                        name="photo" id="photo" required="required"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <input class="btn btn-primary" type="submit" value="Submit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" id="referral_modal">
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Pay Now</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-md-12 text-center">
                                                    {{ $referral->full_name }}</br>
                                                    Phone: {{ $referral->phone }}</br>
                                                    UPI: {{ $referral->upi }}</br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <img style="width:200px"
                                                        src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referral->payment_qr_oode }}" />
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="modal fade" id="upload_offline_form">
                            <form action="{{ url('/upload_offline_form') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="form_service_id" id="form_service_id" value="0">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Upload Form</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Customer</label>
                                                <div class="col-sm-7">
                                                    <select name="customer_id" width="200px" required="required" class="form-control select2" >
                                                        <option  value="">Select</option>
                                                        @foreach($viewcustomers as $cust)
                                                        <option value="{{ $cust->id }}">{{ $cust->full_name_tamil }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-1">
                                                    <a class="btn btn-success btn-sm" onclick="show_add_customer()"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Application Form</label>
                                                <div class="col-sm-8">
                                                    <input accept="image/png,image/jpeg,image/jpg" type="file"
                                                        name="photo" id="photo" required="required"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                            <div class="modal-footer justify-content-between">
                                                <input data-dismiss="modal" type="button" class="btn btn-default"
                                                    value="Close" />
                                                <input type="submit" class="btn btn-success"
                                                    value="Submit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    <div class="modal fade" id="Addcustomers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customers Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addcustomer') }}" method="post">
                    {{ csrf_field() }}
                    @if (Auth::user()->user_type_id == 2 ||
                            Auth::user()->user_type_id == 4 ||
                            Auth::user()->user_type_id == 6 ||
                            Auth::user()->user_type_id == 10 ||
                            Auth::user()->user_type_id == 8 ||
                            Auth::user()->user_type_id == 12)
                        <input type="hidden" name="user_type_id" value="14">
                    @elseif(Auth::user()->user_type_id == 3 ||
                            Auth::user()->user_type_id == 5 ||
                            Auth::user()->user_type_id == 7 ||
                            Auth::user()->user_type_id == 11 ||
                            Auth::user()->user_type_id == 9 ||
                            Auth::user()->user_type_id == 13)
                        <input type="hidden" name="user_type_id" value="15">
                    @endif
                    <div class="modal-body">
                     
                                @if (Auth::user()->user_type_id == 2 ||
                                        Auth::user()->user_type_id == 3 ||
                                        Auth::user()->user_type_id == 4 ||
                                        Auth::user()->user_type_id == 5)
                                    <div class="form-group">
                                        <label>District Name</label>
                                        <select class="form-control select2" name="dist_id" id="dist_id"
                                            style="width: 100%;">
                                            <option value="">Select District Name</option>
                                            @foreach ($authdistrict as $district)
                                                <option value="{{ $district->id }}">{{ $district->district_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif(Auth::user()->user_type_id == 6 ||
                                        Auth::user()->user_type_id == 7 ||
                                        Auth::user()->user_type_id == 8 ||
                                        Auth::user()->user_type_id == 9 ||
                                        Auth::user()->user_type_id == 10 ||
                                        Auth::user()->user_type_id == 11 ||
                                        Auth::user()->user_type_id == 12 ||
                                        Auth::user()->user_type_id == 13)
                                    <div class="form-group">
                                        <label>District Name</label>
                                        <select class="form-control select2" name="dist_id" id="dist_id"
                                            style="width: 100%;">
                                            <option value="">Select District Name</option>
                                            @foreach ($authdistrict as $authdistrictlist)
                                                <option value="{{ $authdistrictlist->id }}">
                                                    {{ $authdistrictlist->district_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Taluk Name</label>
                                    <select class="form-control select2" name="taluk_id" id="taluk"
                                        style="width: 100%;">
                                        <option value="">Select Taluk Name</option>
                                    </select>
                                </div>
                              
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" name="full_name_tamil" id="full_name_tamil"
                                        placeholder="Enter Full Name">
                                </div>
                          
                                <div class="form-group">
                                    <label for="phone">Aadhaar Number</label>
                                    <input onkeyup="checkaadhar(0)" type="text" maxlength="12"
                                                class="form-control number" name="aadhaar_no" id="aadhar"
                                                placeholder="Enter Aadhaar Number">
                                            <span id="duplicateaadhar" style="color:red"></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        placeholder="Enter Phone" onkeyup="checkphone(0)" maxlength="10">
                                    <span id="dupphone" style="color:red"></span>
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
        
        function show_add_customer(){
            //$("#upload_offline_form").modal("hide");
            $("#Addcustomers").modal("show");
        }

        function show_upload(service_id){
            $("#form_service_id").val(service_id);
            $("#upload_offline_form").modal("show");
        }

        function show_paynow(service_id, pay_amount, customer_id, customer_user_type_id, dist_id, taluk_id, panchayath_id) {
            $("#service_id").val(service_id);
            $("#customer_id").val(customer_id);
            $("#customer_user_type_id").val(customer_user_type_id);
            $("#dist_id").val(dist_id);
            $("#taluk_id").val(taluk_id);
            $("#panchayath_id").val(panchayath_id);
            $("#pay_amount").val(pay_amount);
            if(pay_amount == "0") {
                $("#paynow").html("Free");
                $("#submitbtn").val("Proceed");
            }else{
                $("#paynow").html("Pay Now");
                $("#submitbtn").val("Submit");
            }
            $("#paynow_modal").modal("show");
        }

        function show_image_upload(service_id, customer_id, customer_user_type_id) {
            $("#imservice_id").val(service_id);
            $("#imcustomer_id").val(customer_id);
            $("#imcustomer_user_type_id").val(customer_user_type_id);
            $("#image_modal").modal("show");
        }

        function show_referral(service_id, pay_amount) {
            $("#referral_modal").modal("show");
        }

        $(document).ready(function() {
            $("#Customer").addClass('menu-open');
            $("#Customers").addClass('active');
            $("#ViewCustomers").addClass('active');
        });

        $('#serviceimage').submit(function(){
            $("input[type='submit']", this)
            .val("Please Wait...")
            .attr('disabled', 'disabled');
            return true;
        });

        $('#servicepay').submit(function(){
            $("input[type='submit']", this)
            .val("Please Wait...")
            .attr('disabled', 'disabled');
            return true;
        });
    
    var sum = 0;
    function validateqty(){
        var total = 0;
        $(".serviceqty").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseInt(this.value);
            }
        });
        var wallet = parseInt($("#wallet").html());
        var totamount = parseInt($("#totamount").html());
        if(sum < 5){
            totamount=totamount+50;
            $("#totamount").html(totamount);
            $("#deliveryamount").val(50);
            alert("Since quantity is less than 5 delivery charge 50 will be added");
        }
       
        if(totamount > wallet){
            //$("#tota").val(totamount);
            $("#referral_modal").modal("show");
            return false;
        }else{
            $('#submitbtn').prop('disabled', true) .val("Please Wait...");
            return true;
        }
    }

    $('.serviceqty').on('input',function() {
        var qty = 0;
        var amt = 0;
        var total = 0;
        $(".serviceqty").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
              qty = parseInt(this.value);
              amt = $(this).parent().parent().find(".serviceamt").val();
              total =  total + amt * qty;
            }
        });
        $("#totamount").html(total);
    });

    $('#dist_id').on('change', function() {
            var idTaluk = this.value;
            $("#taluk").html('');
            $.ajax({
                url: "{{ url('/gettaluk') }}",
                type: "POST",
                data: {
                    taluk_id: idTaluk,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
                    $.each(result, function(key, value) {
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
            var url = "{{ url('/getpanchayathlimit') }}/" + taluk_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $('#panchayath').html('<option value="">-- Select Panchayath Name --</option>');
                    $.each(result, function(key, value) {
                        $("#panchayath").append('<option value="' + value
                            .id + '">' + value.panchayath_name + '</option>');
                    });
                }
            });
        });

</script>
@endpush
