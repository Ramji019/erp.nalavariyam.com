@extends('member.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Services</h1>
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
                            <table id="example2" class="table table-bordered table-striped">    <thead>
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
                                    @if((Session::get("user_type") == 20 || Session::get("user_type") == 21) && Session::get("status") == "Active")
                                    <td>Free</td>
                                    @else
                                    <td>₹ {{ $service->pay_amount }}</td>
                                    @endif
                                    <td><a href="{{ URL::to('/') }}/upload/fromimg//{{ $service->from_image }}" class="btn btn-default" >Download</a></td>
                                    <td>
                                        @if($service->action == "Pay Now" && $service->pay_amount <= Session::get("wallet"))
                                        <a onclick="show_paynow('{{ $service->id }}','{{ $service->pay_amount }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}','{{ $customer->dist_id }}','{{ $customer->taluk_id }}','{{ $customer->panchayath_id }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @elseif($service->action == "Pay Now" && ($service->pay_amount > Session::get("wallet") ))
                                        <a onclick="show_referral('{{ $service->id }}','{{ $service->pay_amount }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @elseif($service->action == "Create Form" || $service->action == "Reject Form"  )
                                        <a onclick="show_image_upload('{{ $service->id }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @elseif($service->action == "Pending")
                                        <a class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @elseif($service->action == "Waiting")
                                        <a class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @elseif($service->action == "Output" && $service->id == 1)
                                        <a href="{{ URL::to('/') }}/upload/output/{{ $service->output_image }}" class="btn btn-sm btn-info" download>Download</a>
                                        @else
                                        @if($service->pay_amount <= Session::get("wallet") )

                                        <a onclick="show_paynow('{{ $service->id }}','{{ $service->pay_amount }}','{{ $customer->customer_id }}','{{ $customer->customer_user_type_id }}','{{ $customer->dist_id }}','{{ $customer->taluk_id }}','{{ $customer->panchayath_id }}')" class="btn btn-sm btn-info">Pay Now</a>
                                        @else
                                        <a onclick="show_referral('{{ $service->id }}','{{ $service->pay_amount }}')" class="btn btn-sm btn-info">{{ $service->action }}</a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="paynow_modal">
                        <form action="{{ url('/memservicepayment') }}" method="post">
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

                    <div class="modal fade" id="image_modal">
                        <form action="{{ url('/memcreateapplication') }}" method="post" enctype="multipart/form-data">
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
    function show_paynow(service_id, pay_amount, customer_id, customer_user_type_id, dist_id, taluk_id, panchayath_id) {
        $("#service_id").val(service_id);
        $("#customer_id").val(customer_id);
        $("#customer_user_type_id").val(customer_user_type_id);
        $("#dist_id").val(dist_id);
        $("#taluk_id").val(taluk_id);
        $("#panchayath_id").val(panchayath_id);
        $("#pay_amount").val(pay_amount);
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
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#Customer").addClass('menu-open');
        $("#Customers").addClass('active');
        $("#ViewCustomers").addClass('active');
    });
</script>
@endpush
