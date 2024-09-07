@extends('member.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">MemberWallet</h3>
                            <div class="row float-right ">
                                <div class="row">
                                    <ol class=" float-sm-right">

                                        @if ( Session::get("user_type_id") == 18)
                                         <a href="" data-toggle="modal" data-target="#Transfer"
                                            class="btn btn-primary" title="Fund Transfer"><i class="fas fa-plus">
                                                Transfer</i> </a>&nbsp;
                                            <a href="" data-toggle="modal" data-target="#add"
                                                class="btn btn-primary float-sm-right" title="Add Payment "><i
                                                    class="fas fa-plus"> Add Payment</i> </a>
                                        @else
                                             @if($status == 'Pending')
                                        <a href="{{ route('memberrequestamount') }}"  class="btn btn-primary float-sm-right" title="Request Amound "><i class="fas fa-plus"> Request Amount</i> </a>
                                        @else
                                       
                                        <a href="" data-toggle="modal" data-target="#Request"
                                        class="btn btn-primary float-sm-right" title="Request Amound "><i
                                            class="fas fa-plus"> Request Amount</i> </a>
                                        @endif
                                        @endif
                                    </ol>
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
                            </div>
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
                            <div class="table-responsive" style="overflow-x: auto; ">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>DateTime</th>
                                            <th>UserId</th>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            @if ( Session::get("user_type_id") == 18 )
                                                <th>Delete</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet as $key => $walletlist)
                                            <tr>
                                                <td>{{ $walletlist->id }}</td>
                                                <td>{{ $walletlist->paydate }} , {{ $walletlist->time }}</td>

                                                <td>U{{ $walletlist->to_id }}</td>
                                                <td>{{ $walletlist->service_status }} , {{ $walletlist->ad_info }}  </td>
                                               
												 <td>C {{ $walletlist->customer_id }} , S {{ $walletlist->service_id }}</td>

                                                @if ($walletlist->service_status == 'Out Payment')
                                                    <td>{{ $walletlist->amount }}</td>
                                                    <td></td>
                                                @else
                                                    <td></td>
                                                    <td>{{ $walletlist->amount }}</td>
                                                @endif
                                                @if (Session::$user_type_id == 18)
                                                    <td>
                                                        @if (Session::$user_type_id == 18 && $walletlist->ad_info2 == 'ServicePayment')
                                                            <a onclick="return confirm('Do you want to Confirm delete operation?')"
                                                                href="{{ url('/servicepaymentdelete', $walletlist->pay_id) }}"
                                                                class="btn btn-info btn-sm"><i class="fa fa-undo"></i>
                                                                Refund</a>
                                                        @elseif (Session::$user_type_id == 18 && $walletlist->ad_info2 == 'FundTransfer')
                                                            <a onclick="return confirm('Do you want to Confirm delete operation?')"
                                                                href="{{ url('/transferpaymentdelete', $walletlist->pay_id) }}"
                                                                class="btn btn-info btn-sm"><i class="fa fa-undo"></i>
                                                                Refund</a>
                                                        @else($walletlist->service_status == 'RequestAmount' )
                                                        @endif
                                                    </td>
                                                @endif

                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>{{ Session::get("wallet") }}</td>
                                        @if (Session::get("user_type_id") == 18)
                                            <td></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="Request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Request Amount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				   <form onsubmit="return validateamount()" action="{{ url('memberpaymentrequest') }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
                <div class="modal-body">
                    <center>
                        @foreach ($referencedata as $key => $referencedatas)
                            {{ $referencedatas->full_name }}</br>
                            {{ $referencedatas->phone }}</br>
                            {{ $referencedatas->upi }}</br>
                            <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referencedatas->payment_qr_oode }}" />
								 <input type="hidden" class="form-control" name="to_id"
                                    value="{{ $referencedatas->id }}">
                        @endforeach
                    </center>
                     
                    <div class="form-group row">
                        <label for="" class="col-sm-12 col-form-label"><span
                                style="color:red"></span>Request Amount</label>
                        <input  type="text" class="form-control" name="amount" placeholder='Enter Request Amount' required="required">
                    </div>
					<div class="form-group">
                        <label for="" class="col-sm-12 col-form-label"><span
                                style="color:red"></span>Paid Image(ScreenShot Only Jpeg, Jpg, png)</label>
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
    <div class="modal fade" id="Transfer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fund Transfer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    @if (Session::get("wallet") == 18)
                        <form onsubmit="return validateamount()" action="{{ url('addwallet') }}" method="post" class="form-horizontal">
                    @endif
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-12 col-form-label"><span style="color:red"></span>User
                            List</label>
                        <select class="form-control select2" name="user_id" style="width: 100%;" required="required">
                            <option value="">Select User Name</option>
                            @foreach ($userpayment as $key => $userpaymentlist)
                                @if ($userpaymentlist->id != Auth::user()->id)
                                    <option value="{{ $userpaymentlist->id }}">{{ $userpaymentlist->full_name }} ->
                                        {{ $userpaymentlist->phone }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-12 col-form-label"><span
                                style="color:red"></span>Wallet</label>
                        <input value="{{ Session::get("wallet") }}" type="text" class="form-control" name="wallet"
                            id="transfer" readonly>
                    </div>
                    @if (Session::get("wallet") == 18)
                        <div class='form-group row'>
                            <label for='transfer_payment' class='col-sm-12 col-form-label'><span
                                    style='color:red'></span>Transfer Amount</label>
                            <input maxlength="7" required='requiered' type='text' class='form-control number'
                                id="transfer_payment" name='transfer_payment' placeholder='Enter Transfer Amount'>
                        </div>
                        <div class='form-group row'>
                            <label for='balance' class='col-sm-12 col-form-label'><span
                                    style='color:red'></span>Balance</label>
                            <input readonly required='requiered' type='text' class='form-control' id="balance"
                                name='balance'>
                        </div>
                    @else
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    @if (Session::get("wallet") == 18)
                        <button type='submit' id='plansubmit' class='btn btn-primary'>Transfer Now</button>
                    @else
                        <button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
                    @endif
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('superadminaddwallet') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="amount" class="col-sm-12 col-form-label"><span
                                    style="color:red"></span>Amount</label>
                            <input required="required" maxlength="7" type="text" class="form-control number"
                                name="fundamount" id="amount">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Add Payment" name="addamount" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        var wallet = "{{ url('memberwallet') }}";

        function load_report() {
            var from = $("#from").val();
            var to = $("#to").val();
            if (from == "") {
                alert("Please select from Date");
            } else if (to == "") {
                alert("Please select To Date");
            } else {
                var url = wallet + "/" + from + "/" + to;
                window.location.href = url;
            }
        }
        $('#transfer_payment').on('input', function() {
            var wallet = parseInt($('#transfer').val());
            console.log(wallet);
            var amt = parseInt($('#transfer_payment').val());
            var balance = wallet - amt;
            $('#balance').val(balance);
        });

        function validateamount() {
            var wallet = parseInt($('#transfer').val());
            var amt = parseInt($('#transfer_payment').val());
            var balance = wallet - amt;
            if (balance < 0) {
                alert("Transfer Amount cannot be greater than " + wallet);
                return false;
            } else {
                return true;
            }
        }

        $(document).ready(function() {
            $("#wallet").addClass('menu-open');
        });
    </script>
@endpush
