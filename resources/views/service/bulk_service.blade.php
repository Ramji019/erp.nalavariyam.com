@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Bulk Service</h1>
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
                        <form onsubmit="return validateqty()" method="post" action="{{ url('savebulkbuy') }}" id="form1">
                            {{ csrf_field() }}
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
                                        <td name="amount" style="text-align:right"><input size="1" readonly type="text" value="{{ $bulkservicelist->pay_amount }}" class="form-control serviceamt" /></td>
                                        <td style="text-align:right">
                                            <input @if($bulkservicelist->used == 0) readonly @endif type="text" size="1" maxlength="3" name="services_{{ $bulkservicelist->id }}_{{ $bulkservicelist->pay_amount }}" class="form-control number serviceqty">
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
                        <div class="modal fade" id="referral_modal">
                            <form action="{{ url('/bulkrequestamount') }}" enctype="multipart/form-data" method="post">
                                       {{ csrf_field() }}
                                       <div class="modal-dialog">
                                        <input type="hidden" name="to_id" value="{{ $referral->id }}">
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
                                                   <div class="row">
                                                       <div class="col-md-6">
                                                           <div class="form-group">
                                                               <label for="payamount">Amount</label>
                                                               <input readonly type="text" id="tota" class="form-control" name="payamount" style="width: 100%;">
                                                           </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                           <div class="form-group">
                                                               <label for="req_image">Paid Screenshot Image</label>
                                                               <input type="file" class="form-control" name="req_image" style="width: 100%;">
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="modal-footer justify-content-between">
                                                       <button type="button" class="btn btn-default"
                                                           data-dismiss="modal">Close</button>
                                                          <button id="save" type="submit" class="btn btn-primary">Submit</button>
                                                   </div>
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
</section>
@endsection
@push('page_scripts')
<script>
    var sum = 0;
    function validateqty(){

    var total = 0;
    $(".serviceqty").each(function() {
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseInt(this.value);
      }
    });
    if(sum < 5){
     alert("Since quantity is less than 5 delivery charge 50 will be added");
    }

     var wallet = parseInt($("#wallet").html());
     var totamount = parseInt($("#totamount").html());
     if(sum<5){
       totamount=totamount+50;
    $("#totamount").html(totamount);
     }
     if(totamount > wallet){
        $("#tota").val(totamount);
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
              console.log(qty);
              amt = $(this).parent().parent().find(".serviceamt").val();
              console.log(amt);
              total =  total + amt * qty;
            }
        });
        $("#totamount").html(total);
    });

</script>
@endpush
