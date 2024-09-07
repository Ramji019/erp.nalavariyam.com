@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <input type="hidden" id="statuscheck" value="{{ Auth::user()->status }}">
        <div class="modal fade" id="statususercheck">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New User</h4>
                    </div>
                    <div class="modal-body">
                           @php
                             $referral = DB::table( 'users' )->select('full_name','phone')->where('id',Auth::user()->referral_id)->first();
                           @endphp
                           <center>
                            உங்களுக்கான நிர்வாகி உங்களை விரைவில் தொடர்பு கொள்வார்கள்<br>
                            நிர்வாகி பெயர் : <b> {{ $referral->full_name ?? '' }}</b></br>
                            நிர்வாகி மொபைல் எண் : <b>{{ $referral->phone ?? '' }}</b></br>
                        </center>
                    </div>
                    <div class="modal-footer justify-content-between">
                    </div>
                </div>
            </div>
        </div>
        @if ($payment_pending != 0)
        <div class="row">
            <div class="col-md-2 col-sm-2 col-2">
            </div>
            <div class="col-md-8 col-sm-8 col-8 text-center">
                <span class="text-danger font-weight-bold">{{ $payment_message }} &nbsp;</span>
                <input onclick="pay_now()" type="button" value="Pay Now" class="btn btn-primary">
                <input value="{{ $payment_amount }}" type="hidden" name="payment_amount" id="payment_amount" />
            </div>
            <div class="col-md-2 col-sm-2 col-2">
            </div>
        </div>
        @endif


        <div class="modal fade" id="paynow_modal">
            <form action="{{ url('/userstatuspayment_update') }}" method="post">
                {{ csrf_field() }}
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
                                    <input readonly name="pay_amount" id="pay_amount" required="required" maxlength="50"
                                    class="form-control number" />
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
                    <h4 class="modal-title">Request Amount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                   <form action="{{ url('paymentrequest') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                <div class="modal-body">
                    <center>
                            {{ $superadminreferral->full_name }}</br>
                            {{ $superadminreferral->phone }}</br>
                            {{ $superadminreferral->upi }}</br>
                            <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $superadminreferral->payment_qr_oode }}" />
                                 <input type="hidden" class="form-control" name="to_id"
                                    value="{{ $superadminreferral->id }}">
                    </center>
                     
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
                        <button type='submit' id='plansubmit' class='btn btn-primary'>Request Now</button>
                 </form>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="referral_modal">
            <form action="" method="post">
                {{ csrf_field() }}
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
                                <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referral->payment_qr_oode ?? '' }}" />
                            </center>
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

  
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-hand-point-right"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">{{ $pending }}
                        <a href="{{ route('pending') }}" class="small-box-footer float-sm-right">
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
                        <a href="{{ route('rejected') }}" class="small-box-footer float-sm-right">
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
        @if (( Auth::user()->id == 1 ) || ( Auth::user()->id == 2 ) || ( Auth::user()->id == 3 ))
                        <a href="{{ url('/onlinestatus') }}/Completed/{{ date('Y-m-d', strtotime('-10 days')) }}/{{ date('Y-m-d') }}" class="small-box-footer float-sm-right"> MoreInfo <i class="fas fa-arrow-circle-right"></i></a>
        @else
                        <a href="{{ url('/onlinestatus') }}/Completed/{{ date('Y-m-d', strtotime('-750 days')) }}/{{ date('Y-m-d') }}" class="small-box-footer float-sm-right"> MoreInfo <i class="fas fa-arrow-circle-right"></i></a>
		@endif
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
                    <a href="{{ url('viewrequestamount') }}" class="small-box-footer float-sm-right">
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
                <span class="info-box-number">{{ $balance }}
                    <a href="{{ url('wallet') }}/{{ date('Y-m-d', strtotime('-1 days')) }}/{{ date('Y-m-d') }}"
                    class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@if (Auth::user()->user_type_id == 1)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Primary Users</span>
            <span class="info-box-number">{{ $PrimaryUsers }}
                <a href="{{ route('primaryusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Special Users</span>
            <span class="info-box-number">{{ $SpecialUsers }}
                <a href="{{ route('specialusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            @if (Auth::user()->user_type_id == 1)
            <span class="info-box-text">District Users</span>
            @elseif(Auth::user()->user_type_id == 2)
            <span class="info-box-text">District President</span>
            @elseif(Auth::user()->user_type_id == 3)
            <span class="info-box-text">District Secretary</span>
            @endif
            <span class="info-box-number">{{ $District }}
                <a href="{{ route('districtusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 ||
Auth::user()->user_type_id == 2 ||
Auth::user()->user_type_id == 3 ||
Auth::user()->user_type_id == 4 ||
Auth::user()->user_type_id == 5)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-dark"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            @if (Auth::user()->user_type_id == 1)
            <span class="info-box-text">Thaluk Users</span>
            @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4)
            <span class="info-box-text">Thaluk President</span>
            @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5)
            <span class="info-box-text">Thaluk Secretary</span>
            @endif
            <span class="info-box-number">{{ $Taluk }}
                <a href="{{ route('talukusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 ||
Auth::user()->user_type_id == 2 ||
Auth::user()->user_type_id == 3 ||
Auth::user()->user_type_id == 4 ||
Auth::user()->user_type_id == 5)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            @if (Auth::user()->user_type_id == 1)
            <span class="info-box-text">Block Users</span>
            @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 6)
            <span class="info-box-text">Block President</span>
            @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5 || Auth::user()->user_type_id == 7)
            <span class="info-box-text">Block Secretary</span>
            @endif
            <span class="info-box-number">{{ $Block }}
                <a href="{{ route('blockusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 ||
Auth::user()->user_type_id == 2 ||
Auth::user()->user_type_id == 3 ||
Auth::user()->user_type_id == 4 ||
Auth::user()->user_type_id == 5 ||
Auth::user()->user_type_id == 6 ||
Auth::user()->user_type_id == 7 ||
Auth::user()->user_type_id == 10 ||
Auth::user()->user_type_id == 11)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            @if (Auth::user()->user_type_id == 1)
            <span class="info-box-text"> Sub Block Users</span>
            @elseif(Auth::user()->user_type_id == 2 ||
            Auth::user()->user_type_id == 4 ||
            Auth::user()->user_type_id == 6 ||
            Auth::user()->user_type_id == 8)
            <span class="info-box-text">Panchayath President</span>
            @elseif(Auth::user()->user_type_id == 3 ||
            Auth::user()->user_type_id == 5 ||
            Auth::user()->user_type_id == 7 ||
            Auth::user()->user_type_id == 9)
            <span class="info-box-text"> Sub Block Secretary</span>
            @endif
            <span class="info-box-number">{{ $Panchayath }}
                <a href="{{ route('panchayathusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 ||
Auth::user()->user_type_id == 2 ||
Auth::user()->user_type_id == 3 ||
Auth::user()->user_type_id == 4 ||
Auth::user()->user_type_id == 5 ||
Auth::user()->user_type_id == 6 ||
Auth::user()->user_type_id == 7 ||
Auth::user()->user_type_id == 8 ||
Auth::user()->user_type_id == 9 ||
Auth::user()->user_type_id == 10 ||
Auth::user()->user_type_id == 11)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            @if (Auth::user()->user_type_id == 1)
            <span class="info-box-text">Center Users</span>
            @elseif(Auth::user()->user_type_id == 2 ||
            Auth::user()->user_type_id == 4 ||
            Auth::user()->user_type_id == 6 ||
            Auth::user()->user_type_id == 8 ||
            Auth::user()->user_type_id == 10)
            <span class="info-box-text">Center President</span>
            @elseif(Auth::user()->user_type_id == 3 ||
            Auth::user()->user_type_id == 5 ||
            Auth::user()->user_type_id == 7 ||
            Auth::user()->user_type_id == 9 ||
            Auth::user()->user_type_id == 11)
            <span class="info-box-text">Center Secretary</span>
            @endif
            <span class="info-box-number">{{ $Center }}
                <a href="{{ route('centerusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 ||
Auth::user()->user_type_id == 2 ||
Auth::user()->user_type_id == 3 ||
Auth::user()->user_type_id == 4 ||
Auth::user()->user_type_id == 5 ||
Auth::user()->user_type_id == 6 ||
Auth::user()->user_type_id == 7 ||
Auth::user()->user_type_id == 8 ||
Auth::user()->user_type_id == 9 ||
Auth::user()->user_type_id == 10 ||
Auth::user()->user_type_id == 11 ||
Auth::user()->user_type_id == 12 ||
Auth::user()->user_type_id == 13)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-dark"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Customers</span>
            <span class="info-box-number">{{ $Customers }}
                <a href="{{ route('customers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13)
@else
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Members</span>
            <span class="info-box-number">{{ $Members }}
                <a href="{{ route('members') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>


<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Special Members</span>
            <span class="info-box-number">{{ $SpecialMembers }}
                <a href="{{ route('specialmembers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
@if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fa fa-briefcase"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Available Posting</span>
            <span class="info-box-number">{{ $avilableposting }}
                <a href="{{ route('avilableposting') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-dark"><i class="far fa-bell"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Notifications</span>
            <span class="info-box-number">{{ $notification }}
                <a href="{{ route('notification') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fas fa-bullhorn"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Business Ads</span>
            <span class="info-box-number">{{ $addscount }}
                <a href="{{ route('advertisement') }}" class="small-box-footer float-sm-right">
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
            <span class="info-box-text">Bulk Buy</span>
            <span class="info-box-number">{{ $bulkbuy }}
                <a href="{{ route('customers') }}" class="small-box-footer float-sm-right">
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
@if(Auth::user()->user_type_id >= 1 && Auth::user()->user_type_id <= 11)
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class=" far fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Registered User</span>
            <span class="info-box-number">{{ $Registeruser }}
                <a href="{{ route('registerusers') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@endif
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class=" far fa-flag"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Meetings</span>
            <span class="info-box-number">{{ $meetings }}
                <a href="{{ route('meetings') }}" class="small-box-footer float-sm-right">
                    MoreInfo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>




</div>
</div>
</div>
</div>
</section>
<div class="modal fade" id="showimage" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
 வெற்றியாளர்
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="row">

<div class="col-md-4">

<div class="card card-widget widget-user shadow">

<div class="widget-user-header bg-info">
<h3 class="widget-user-username">MY</h3>
<h5 class="widget-user-desc"><span class="info-box-number">{{ Auth::user()->full_name }}</span>
</h5>
</div>
<div class="widget-user-image">
<img class="img-circle elevation-2" src="{{ URL::to('/') }}/upload/user_photo/{{ Auth::user()->photo }}" alt="User Avatar"></br>
<span class="info-box-number"></span>
</div>
<center>
<h5 class="widget-user-desc"><span class="info-box-number">{{ $user_type_name }}</span></h5>
</center>

<div class="row">
<div class="col-sm-4 border-right">
<div class="description-block">
<h5 class="description-header">{{ $Auth_user_monthly }}</h5>
<span class="description-text">Monthly</span>
</div>
</div>

<div class="col-sm-4 border-right">
<div class="description-block">
<h5 class="description-header">{{ $Auth_user_overall }}</h5>
<span class="description-text">Overall</span>
</div>
</div>

<div class="col-sm-4 border-right">
<div class="description-block">
<h5 class="description-header">{{ $Auth_team_overall }}</h5>
<span class="description-text">Team </span>
</div>
</div>
</div>
<center>
 <span class="info-box-number"> <a href="{{ url('/performers') }}" class="small-box-footer"> More Details <i class="fas fa-arrow-circle-right"></i></a></center>
 </span>
</div>
</div>
<div class="col-md-7">
 <center> <h1>Meetings</h1>
  <a href="{{ route('meetings') }}"><img class="elevation-2" src="{{ URL::to('/') }}/upload/click.gif" alt="Girl in a jacket" height="200">> </a></center>

</div>
</div>



                     </div>
                     <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
               </div>
<div class="modal fade" id="showcompleted" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
 Online Application Form Status
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
		  @foreach ($onlinestatus_menu as $onlinestatus)
					<div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="far fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ $onlinestatus->online_status_id }}</span>
                    <span class="info-box-number">
                        <a href="{{ url('onlinestatus') }}/{{ $onlinestatus->online_status_id }}/{{ date('Y-m-d', strtotime('-3 days')) }}/{{ date('Y-m-d') }}" class="small-box-footer float-sm-right">
                            MoreInfo <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
		 @endforeach
		

                     </div>
                     </div>
                     <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    
    @if(Auth::user()->emailverified == "1")
        var status =  $("#statuscheck").val();
        if(status != "New"){
			
             $("#showimage").modal("show");
			 
        }
        if(status == "New"){
            $("#statususercheck").modal({backdrop: 'static', keyboard: false});
        }
    @endif

</script>


@endpush
