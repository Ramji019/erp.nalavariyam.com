@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pending Bulk Order</h1>
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
                                    <th> District Name</th>
                                    <th> Service Name</th>
                                    <th> Quantity</th>
                                    <th> Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending as $key => $bulkservice)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $bulkservice->district_name }}</td>
                                    <td>{{ $bulkservice->service_name }}</td>
                                    <td>{{ $bulkservice->quantity }}</td>
                                    <td>{{ $bulkservice->amount*$bulkservice->quantity }}</td>
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
@endsection
