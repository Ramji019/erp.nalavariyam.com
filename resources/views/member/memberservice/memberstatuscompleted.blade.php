@extends('member.layouts.app')
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
                            <input id="btntop" type="button"  onclick="load_report()" value="Show"
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
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>District Name</th>
                                        <th>Amount</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
                                        <th>Time</th>
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
                                                @if ( $user_type == 18 || $user_type == 19 || $user_type == 20 || $user_type == 21 )
                                                    <a onclick="show_output('{{ $servicestatuslist->service_name }}','{{ $servicestatuslist->from_image }}')"
                                                        type="button" class="btn btn-primary btn-sm">Output</a>
                                                @else
                                                    <a href="{{ URL::to('/') }}/upload/output/{{ $servicestatuslist->from_image }}"
                                                        type="button" class="btn btn-primary btn-sm" download>Download</a>
                                                @endif
                                                @if ($servicestatuslist->bill == 1)
                                                    <a onclick="create_bill('{{ $servicestatuslist->userID }}','{{ $servicestatuslist->service_name }}','{{ $servicestatuslist->service_payment }}')"
                                                        type="button" class="btn btn-info btn-sm">Create Bill</a>
                                                @else
                                                    <a href="{{ url('/receipt') }}/{{ $servicestatuslist->customer_id }}/{{ $servicestatuslist->userID }}" type="button" class="btn btn-primary btn-sm">View
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
                <div class="modal-body">
                   <center> <img src="" id="photo" style="opacity: .8; width:700px;"></center>
                    <div class="modal-footer justify-content-between">
                        <a type="" class=""></a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
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
                <form action="{{ url('/membercompletedbill') }}" method="post">
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
        function show_output(servicename, photo) {
            $("#servicename").text(servicename);
            $("#photo").attr("src", '/upload/output/' + photo);
            $("#output").modal("show");
        }

        function create_bill(id, servicename, payment) {
            $("#service_name").text(servicename);
            $("#servicepayment").val(payment);
            $("#serviceid").val(id);
            $("#bill").modal("show");
        }

        var memberstatuscompleted = "{{ url('memberstatuscompleted') }}";
        function load_report() {
            var from = $("#from").val();
            var to = $("#to").val();
            if (from == "") {
                alert("Please select from Date");
            } else if (to == "") {
                alert("Please select To Date");
            } else {
                var url = memberstatuscompleted + "/" + from + "/" + to;
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
