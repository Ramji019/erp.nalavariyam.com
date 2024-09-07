@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
		<section class="hero set-bg">
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>

<div class="container"><center>
            @if($payment_pending != 0)
<h2>{{ $payment_message }}</h2></br>

                    <input onclick="pay_now()" type="button" value="Pay Now" class="btn btn-primary">
                    <input value="{{ $payment_amount }}" type="hidden" name="payment_amount" id="payment_amount" />
              
			@else

<h2>This User Account Is Active</h2>
            @endif
			</center>
</div>
</section>

<div class="modal fade" id="paynow_modal">
    <form action="{{ url('/renewpayment') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ $user_status_id }}">
        <input type="hidden" id="referral_id" name="referral_id" value="{{ $referral->id ?? '' }}">
        <input value="{{ $ad_info }}" type="hidden" name="ad_info" id="ad_info" />
        <input value="{{ $payment_amount }}" type="hidden" name="payment_amount" id="payment_amount" />
        <input value="{{ $balance }}" type="hidden" name="wallet_amount" id="wallet_amount" />

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
                            <input readonly name="pay_amount" id="pay_amount" required="required"  maxlength="50" class="form-control number" />
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
                    <h4 class="modal-title">Pay Now</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					 <center>
                        {{ $referral->full_name ?? '' }}</br>
                        {{ $referral->phone ?? '' }}</br>
                        {{ $referral->upi ?? '' }}</br>
                        <img style="width:200px" src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referral->payment_qr_oode ?? '' }}"/>

						 </center>
					<form onsubmit="return validateamount()" action="{{ url('paymentrequest') }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
                        <input type="hidden" class="form-control" name="to_id" value="{{ $referral->id }}">
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
                        <input class="btn btn-primary" type="submit" value="Submit" />
                    </div>
					
                </div>
            </div>
        </div>
    </form>
</div>


           
        </div>
    </section>
@endsection

@push('page_scripts')
<script>
    function pay_now(){
        var wallet_amount = parseFloat($("#wallet_amount").val());
        var payment_amount = parseFloat($("#payment_amount").val());
        $("#pay_amount").val(payment_amount);
        if(payment_amount > wallet_amount){
            $("#referral_modal").modal("show");
        }else{
            $("#paynow_modal").modal("show");
        }
    }
</script>
@endpush
