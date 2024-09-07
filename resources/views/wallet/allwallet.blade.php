@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Wallet</h3>
                            <div class="row float-right ">
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
                                            <th>UserId</th>
                                            <th>Title</th>
                                            <th>DateTime</th>
                                            <th>Data</th>
                                            <th> Debit</th>
                                            <th> Credit</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet as $key => $walletlist)
                                            <tr>
                                                <td>{{ $walletlist->id }}</td>
                                                <td>{{ $walletlist->from_id }}</td>
                                                <td>{{ $walletlist->service_status }} , {{ $walletlist->ad_info }} ,
                                                    {{ $walletlist->ad_info2 }} , RS {{ $walletlist->amount }} , </td>
                                                <td>{{ $walletlist->paydate }} , {{ $walletlist->time }}</td>
                                               
												 <td>C {{ $walletlist->customer_id }} , S {{ $walletlist->service_id }} , {{ $walletlist->time }}</td>

                                                @if ($walletlist->service_status == 'Out Payment')
                                                    <td>{{ $walletlist->amount }}</td>
                                                    <td></td>
                                                @else
                                                    <td></td>
                                                    <td>{{ $walletlist->amount }}</td>
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
                                        <td>{{ Auth::user()->wallet }}</td>
                                        @if (Auth::user()->user_type_id == 1)
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
  
@endsection
@push('page_scripts')
    <script>
        var wallet = "{{ url('wallet') }}";

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
