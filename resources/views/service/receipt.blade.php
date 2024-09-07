@extends('layouts.print_app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
				<div class="card-body">
            <center> <img src="{{ URL::to('/') }}/dist/img/header.png" width="900"></br><b>Receipt</b></center>
            <hr>
            <div class="row mb-4">
               <div class="col-sm-6">
                  <div><strong>From : </strong>{{ $user_name }}  </br>{{ $user_address }}</div>
               </div>
               <div class="col-sm-6" style="text-align: right;">
                  <div>
                @if(Auth::user()->id == 4)
                     Designation : District Presidents</br>
                @elseif(Auth::user()->id == 5)
                     Designation : District Secretarys</br>
                @elseif(Auth::user()->id == 6)
                     Designation : Taluk Presidents</br>
                @elseif(Auth::user()->id == 7)
                     Designation : Taluk Secretarys</br>
                @elseif(Auth::user()->id == 8)
                     Designation : Sub Block Presidents</br>
                @elseif(Auth::user()->id == 9)
                     Designation :  Sub Block Secretarys</br>
                @elseif(Auth::user()->id == 5)
                     Designation : Block Presidents</br>
                @elseif(Auth::user()->id == 5)
                     Designation : Block Secretarys</br>
                @elseif((Auth::user()->id == 12) || (Auth::user()->id == 13))
                     Designation : Center</br>
                @endif
				Cell Number :{{ $user_phone }}
                  </div>
               </div>
            </div>
            <hr>
            <div class="row mb-4">
               <div class="col-sm-9">
                  <div>
                     <strong>Bill To : </strong>{{ $customer_address }}, {{ $customer_address }}<?php echo $customer_name; ?>,<?php echo $customer_phone; ?> 
                  </div>
               </div>
               <div class="col-sm-3">
                  <div style="text-align: right;">
                     <strong>Receipt No : </strong> 00{{ $customer_id }}</br>
                     <strong> Date : </strong> {{ date('Y-m-d') }}
                  </div>
               </div>
            </div>
            <div class="table-responsive-sm">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>Service Name</th>
                        <th class="right" style="text-align: right;">Amount</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                       
                        <td class="left strong">{{ $service_name }} (சந்தா)</td>
                        <td class="right" style="text-align: right;">{{ $customer_amount }}</td>
                     </tr>
                     <tr>
                        <td class="left strong">Donation fees</td>
                        <td class="right" style="text-align: right;">{{ $customer_ad_amount }}</td>
                     </tr>
                     <tr>
                       
                        <td class="left">
                           <h5><b  id="header1">Amount in words : </b> {{ $getamount }}</h5>
                        </td>
                        <td class="right" style="text-align: right;">Total {{ $customer_ad_amount +  $customer_amount }} </td>
                     </tr>
                  </tbody>
               </table>
               <div class="row">
                  <div class="col-lg-9 col-sm-5">
                     <table class="table table-clear">
                        <tbody>
                           <tr>
                              <td class="left">
                                 </br>
                                 </br>
                                 <strong>Reference No : {{ $customer_reference_id }}</strong>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-lg-3 col-sm-5 ml-auto">
                     <table class="table table-clear">
                        <tbody>
                           <tr>
                              <td class="right">
                                 </br>
                                 <div>
                                   @if(Auth::user()->id == 4)
										 Designation : District Presidents</br>
									@elseif(Auth::user()->id == 5)
										 Designation : District Secretarys</br>
									@elseif(Auth::user()->id == 6)
										 Designation : Taluk Presidents</br>
									@elseif(Auth::user()->id == 7)
										 Designation : Taluk Secretarys</br>
									@elseif(Auth::user()->id == 8)
										 Designation : Sub Block Presidents</br>
									@elseif(Auth::user()->id == 9)
										 Designation :  Sub Block Secretarys</br>
									@elseif(Auth::user()->id == 5)
										 Designation : Block Presidents</br>
									@elseif(Auth::user()->id == 5)
										 Designation : Block Secretarys</br>
									@elseif((Auth::user()->id == 12) || (Auth::user()->id == 13))
										 Designation : Center</br>
									@endif
                                 </div>
                                 <strong>Authorised Signatory</strong>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="row no-print">
               <div class="col-12">
                  <center><button onClick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button></center>
               </div>
            </div>
         </div>
		 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


