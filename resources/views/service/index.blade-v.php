@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bulk Order ( {{ $user->full_name }} )</h1>
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
                        <form method="post" action="{{ url('updatebulkstatus') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Service Name</th>
                                        <th style="text-align: right">Rate</th>
                                        <th style="text-align: right">Quantity</th>
                                        <th style="text-align: right">Amount</th>
                                        <th>Added Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total=0;
                                    @endphp
                                    @foreach ($bulkorders as $key => $bulkorderslist)
                                    @php
                                    $total = $total + ($bulkorderslist->amount * $bulkorderslist->quantity);
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $bulkorderslist->service_name }}</td>
                                        <td style="text-align: right">₹ {{ $bulkorderslist->amount }}</td>
                                        <td style="text-align: right">{{ $bulkorderslist->quantity }}</td>
                                        <td style="text-align: right">₹ {{ $bulkorderslist->amount * $bulkorderslist->quantity }}</td>
                                        <td>{{ $bulkorderslist->added_datetime }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" style="text-align: right">Total</td><td style="text-align: right">₹ {{ $total }}</td><td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-4 col-form-label">Select Status</label>
                                        <div class="col-sm-8">
                                            <select required="required" name="status" class="form-control" id="to_class">
                                                <option value="">Select Status</option>
                                                <option value="Delivered">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="row">
                              <div class="col-12 text-center" >
                                <input onclick="show_address()" type="button"  value="View Address" class="btn btn-primary">
                                <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
                            </div>

                        </div>
                    </form>

                    <div class="modal fade" id="address_modal">
                       <form action="" method="post">
                          {{ csrf_field() }}
                          <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                   <h4 class="modal-title">Address</h4>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group row">
                                   {{ Auth::user()->full_name }}</br>
                                   {{ Auth::user()->permanent_address_1 }}</br>
                                   {{ Auth::user()->pincode }}</br>
                                   Phone: {{ Auth::user()->phone }}</br>
                               </div>
                               <div class="modal-footer justify-content-between">
                                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    function show_address(){
        $("#address_modal").modal("show");
    }
</script>
@endpush
