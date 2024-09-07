@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Withdrawal</h3>
                        <div class="row float-right ">
                            <div class="row">
                                @if(Auth::user()->user_type_id > 3)
                                <ol class=" float-sm-right">
                                    @if($status == "Pending")
                                    <a href="#" 
                                    class="btn btn-primary disabled float-sm-right" ><i
                                    class="fas fa-plus">Waiting For Approval</i> </a>
                                    @else
                                    <a href="" data-toggle="modal" data-target="#Withdrawal"
                                    class="btn btn-primary float-sm-right" title="Withdrawal"><i
                                    class="fas fa-plus">Withdrawal</i> </a>
                                    @endif
                                </ol>
                                @endif
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
                                            <th>Date</th>
                                            <th>Withdrawal Amount</th>
                                            <th>Status</th>
                                              @if(Auth::user()->id == 1)
                                              <th>User ID</th>
                                               @endif
                                               @if($status != "Pending")
                                             <th>Transaction Id</th>
                                             @endif
                                              @if(Auth::user()->id == 1)
                                            <th>Action</th>
                                            @endif
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawal as $key => $withdrawallist)
                                            <tr>
                                                 <td>{{ $key + 1 }}</td>
                                               
                                                <td>{{ $withdrawallist->withdrawal_date }}</td>
                                                <td>{{ $withdrawallist->amount }}</td>
                                                <td>{{ $withdrawallist->status }}</td>
                                                @if(Auth::user()->id == 1)
                                                <td>U{{ $withdrawallist->userid }}</td>
                                                @endif
                                                   @if($status != "Pending")
                                             <th>{{ $withdrawallist->txnid }}</th>
                                             @endif
                                              @if(Auth::user()->id == 1 && $withdrawallist->status == 'Pending')
                                                <td> 
                                                    
                                                    <a onclick="return confirm('Do you want to cancel the withdrawal?')" href="{{ url('rejectwithdrawal') }}/{{ $withdrawallist->id }}" type="button" class="btn btn-danger btn-sm">Reject</a>
  <a onclick="acceptwithdrawal('{{ $withdrawallist->id }}','{{ $withdrawallist->amount }}','{{ $withdrawallist->account_name }}','{{ $withdrawallist->account_no }}','{{ $withdrawallist->ifsc_code }}')" type="button" class="btn btn-success btn-sm">Approve</a>
</td>
@elseif(Auth::user()->id == 1 && $withdrawallist->status != 'Pending')
<td></td>
@endif
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
<div class="modal fade" id="Withdrawal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Withdrawal Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="return validateamount()" action="{{ url('withdrawalrequest') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
               <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cbalance">Wallet Balance</label>
                        <input type="text" class="form-control" name="totalBalance" placeholder="My Balance" value="{{ $balance }}" id="balance" readonly>
                    </div> 
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="avilable_balance">Withdrawable Balance </label>
                        <input type="text" class="form-control" name="balance" placeholder="My Balance" value="{{ $wallet->commission }}" id="avilable_balance" readonly>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount"><span style="color:red">*</span>Withdrawal Amount</label>
                        <input class="form-control number" maxlength="6"  required="required" name="amount" placeholder="Withdrawal Amount" id="tamount">
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <label for="nbalance1">Balance</label>
                    <input type="text" class="form-control"  required="required" name="nbalance1" id="nbalance" placeholder="New Balance" readonly>
                </div> 
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account_name"><span style="color:red">*</span>A/C Holder Name</label>
                        <input maxlength="50" type="text" class="form-control"  required="required" name="account_name" placeholder="A/C Holder Name" id="account_name">
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <label for="ifsc_code"><span style="color:red">*</span>IFSC Code</label>
                    <input maxlength="20" type="text" class="form-control"  required="required" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" >
                </div> 
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account_no"><span style="color:red">*</span>Account Number</label>
                        <input maxlength="20" type="text" class="form-control number"  required="required" name="account_no" placeholder="Account Number" id="account_no">
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <label for="confirm_account_no"><span style="color:red">*</span>Confirm Account Number</label>
                        <input maxlength="20" type="text" class="form-control number"  required="required" name="confirm_account_no" placeholder="Account Number" id="confirm_account_no">
                </div> 
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                   <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" rows="1" placeholder="Remarks" maxlength="150"></textarea>
                </div>
            </div>
        </div>


    </div>

    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type='submit' id='plansubmit' class='btn btn-primary'>Withdraw Now</button>
    </form>
</div>
</div>
</div>
</div>
<div class="modal fade" id="approvewithdrawalmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/acceptwithdrawal') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="full_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                 <input type="hidden" name="id" id="approveid">
                 <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Amount
                    </label>
                    <label for="" class="col-sm-8 col-form-label"><span id="approveamount"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Account Holder
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span id="approvename"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Account Number
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span id="approveno"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>IFSC Code
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span id="approveifsc"></span> </label>
                    </div>
                     <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Transaction Id
                        </label>
                       <input maxlength="20" type="text" name="txnid" class="col-sm-8 form-control" required="required">
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
    $('#tamount').on('input', function() {
        var wallet = parseInt($('#avilable_balance').val());
        var amt = parseInt($('#tamount').val());
        var balance = wallet - amt;
        $('#nbalance').val(balance);
    });

    function validateamount() {
        var account_no = parseInt($('#account_no').val());
        var confirm_account_no = parseInt($('#confirm_account_no').val());
        var wallet = parseInt($('#avilable_balance').val());
        var amt = parseInt($('#tamount').val());
        var balance = wallet - amt;
        if (balance < 0) {
            alert("Withdrawal balance is " + wallet);
            return false;
        }else if(account_no != confirm_account_no){
            alert("Account number not matching");
            return false;
        } else {
            return true;
        }

    }

    function acceptwithdrawal(id, amount,acc_name,acc_no,ifsc_code) {
        $("#approveid").val(id);
        $("#approveamount").text(amount);
        $("#approvename").text(acc_name);
        $("#approveno").text(acc_no);
        $("#approveifsc").text(ifsc_code);
        $("#approvewithdrawalmodal").modal("show");

    }

    $(document).ready(function() {
        $("#wallet").addClass('menu-open');
    });
</script>
@endpush
