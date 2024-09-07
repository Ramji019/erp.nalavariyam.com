@extends('member.layouts.app')
@section('content')
    <h3> Member Dashboard</h3>
  
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-hand-point-right"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">{{ $pending }}
                        <a href="{{ route('memberpending') }}" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="far fa-thumbs-down"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Resubmit</span>
                    <span class="info-box-number">{{ $rejected }}
                        <a href="{{ route('memberrejected') }}" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number">{{ $completed }}
                        <a href="{{ url('memberstatuscompleted') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}"
                            class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> Request Amount</span>
                    <span class="info-box-number">{{ $RequestAmount }}
                        <a href="{{ url('memberrequestamount') }}" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Wallet</span>
                    <span class="info-box-number">{{ Session::get('wallet') }}
                        <a href="{{ url('memberwallet') }}/{{ date('Y-m-d', strtotime('-1 days')) }}/{{ date('Y-m-d') }}"
                            class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class=" far fa-comment-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Messages</span>
                    <span class="info-box-number">{{ $msgcount }}
                        <a data-toggle="dropdown" href=""
                            onclick="window.open('{{ url('/chatusers') }}','MY Window','height=600,width=500,top=200,centeralign=200,left=900')"
                            href="#" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class=" far fa-comment-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Documents</span>
                    <span class="info-box-number">
                        <a data-toggle="dropdown" href=""
                            onclick="window.open('{{ url('/chatusers') }}','MY Window','height=600,width=500,top=200,centeralign=200,left=900')"
                            href="#" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class=" far fa-comment-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Service</span>
                    <span class="info-box-number">{{ $servicecount }}
                        <a href="{{ url('memberservices') }}" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        function pay_now() {
            var wallet_amount = parseFloat($("#wallet_amount").val());
            var payment_amount = parseFloat($("#payment_amount").val());
            $("#pay_amount").val(payment_amount);
            if (payment_amount > wallet_amount) {
                $("#referral_modal").modal("show");
            } else {
                $("#paynow_modal").modal("show");
            }
        }
    </script>
@endpush
