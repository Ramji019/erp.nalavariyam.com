@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Edit Customers</h1>
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
                  @foreach ($customers as $custom)
                  <form action="{{ url('/updatecustomers') }}" enctype="multipart/form-data" method="post">
                     {{ csrf_field() }}
                     <div class="card-body">
                        <div class="row">
                           <input type="hidden" name="id" value="{{ $custom->id }}" />
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="dist_id">District Name</label>
                                 <select class="form-control select2" name="dist_id" id="districtid"
                                    style="width: 100%;" required="required">
                                    <option value=""></option>
                                    @foreach ($managedistrict as $district)
                                    <option @if ($custom->dist_id == $district->id) selected @endif
                                    value="{{ $district->id }}">{{ $district->district_name }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label for="full_name_tamil">Full Name</label>
                                 <input type="text" class="form-control"
                                    value="{{ $custom->full_name_tamil }}" name="full_name_tamil"
                                    placeholder="Full Name">
                              </div>
							  <div class="row">
                              <div class="col-md-6">
                              <div class="form-group">
                                 <label for="gender">Gender</label>
                                 <div class="radio">
                                    <label>
                                    Select
                                    <label>
                                    <label>
                                    <input @if ($custom->gender == 1) checked @endif
                                    type="radio" name="gender" id="male"
                                    value="1">
                                    Male
                                    </label>
                                    <label>
                                    <input @if ($custom->gender == 2) checked @endif
                                    type="radio" name="gender" id="female"
                                    value="2">
                                    Female
                                    </label>
                                 </div>
                              </div>
                              </div>
							  <div class="col-md-6">
                              <div class="form-group">
                                 <label for="aadhaar_no">Aadhaar No</label>
                                 <input type="text" class="form-control"
                                    value="{{ $custom->aadhaar_no }}" onkeyup="checkaadhar(0)"  maxlength="12" name="aadhaar_no" id="aadhar"
                                    placeholder="Aadhaar No">
                                 <span id="duplicateaadhar" style="color:red"></span>
                              </div>
                           </div>
                           </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="phone">Phone</label>
                                 <input type="text" class="form-control" value="{{ $custom->phone }}"
                                    name="phone" id="phone" placeholder="Phone"onkeyup="checkphone(0)"  maxlength="10">
                                    <span id="duplicatephone" style="color:red"></span>
                              </div>
                              <div class="form-group">
                                 <label>Address</label>
                                 <textarea class="form-control" value="{{ $custom->permanent_address_1 }}" name="permanent_address_1"rows="4"
                                    placeholder="Enter Address ...."></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
               <div class="form-group row">
               <div class="col-md-12 text-center">
               <a href="" class="btn btn-info">Back</a>
               <input id="save" class="btn btn-info" type="submit" name="submit"
                  value="Submit" />
               </div>
               </div>
               </form>
               @endforeach
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
@endsection
@push('page_scripts')
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#Customer").addClass('menu-open');
$("#Customers").addClass('active');
$("#ViewCustomers").addClass('active');
});
</script>
@endpush
