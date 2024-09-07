@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Wallet</h3>
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
                                <th style="width:10%">S NO</th>
                                <th style="width:10%">ID</th>
                                <th style="width:30%">Full Name</th>
                                <th style="width:15%">Phone</th>
                                <th style="width:15%">Deposit</th>
                                <th style="width:15%">Commission</th>
                                <th style="width:30%">Total</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($walletamount as $key => $wallet)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>U{{ $wallet->id }}</td>
									
									
                                    <td>{{ $wallet->full_name }}</td>
                                    <td>{{ $wallet->phone }}</td>

                                    <td>{{ $wallet->deposit }}</td>
                                    <td>{{ $wallet->commission }}</td>
									
									<td>{{ $wallet->wallet }}</td>
									       
                                </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-danger" style="font-weight: bolder">{{ $walletamount->sum('deposit') }}</td>
                                    <td class="text-danger" style="font-weight: bolder">{{ $walletamount->sum('commission') }}</td>
                                    <td class="text-danger" style="font-weight: bolder">{{ $walletamount->sum('wallet') }}</td>
                                           
                                </tr>
                        </tfoot>
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
   
@endpush
 