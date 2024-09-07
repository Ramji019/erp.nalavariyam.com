@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>View Special Members</h1>
         </div>
         <div class="col-sm-6">
            @if (Auth::user()->user_type_id == 1)
            @else
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                  data-toggle="modal" data-target="#specialmembers"><i class="fa fa-plus"> Add
                  </i></button>
               </li>
            </ol>
            @endif
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
                                            <th> ID </th>
                                            <th> District</th>
                                            <th> Full Name</th>
                                            <th> Phone</th>
                                            <th> Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialmembers as $key => $specialmemberslist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>SM{{ $specialmemberslist->userID }}</td>
                                                <td>{{ $specialmemberslist->district_name }}</td>
                                                @if ($specialmemberslist->full_name != '')
                                                    <td>{{ $specialmemberslist->full_name }}</td>
                                                @else
                                                    <td>{{ $specialmemberslist->full_name_tamil }}</td>
                                                @endif
                                                <td>{{ $specialmemberslist->phone }}</td>
                                                <td>{{ $specialmemberslist->status }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default">Action</button>
                                                        <button type="button"
                                                            class="btn btn-default dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">

                                                            <a class="dropdown-item" target="_blank" href="{{ url('/idcard', $specialmemberslist->userID) }}">ID Card</a>

                                                            <a class="dropdown-item"
                                                            href="{{ url('/addfamily', $specialmemberslist->userID) }}">Add
                                                            Family</a>
                                                        <a onclick="userdatas('{{ $specialmemberslist->userID }}','{{ $specialmemberslist->full_name }}','{{ $specialmemberslist->registeration_no }}','{{ $specialmemberslist->district_name }}','{{ $specialmemberslist->taluk_name }}','{{ $specialmemberslist->panchayath_name }}','{{ $specialmemberslist->pas }}','{{ $specialmemberslist->phone }}','{{ $specialmemberslist->status }}')"
                                                            type="button" class="dropdown-item">View Member</a>

                                                            @if (Auth::user()->user_type_id == 1)
                                                            <a href="updatepassword/{{ $specialmemberslist->userID }}" type="button" class="dropdown-item">Reset Password</a>
                                                            @endif

                                                        @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                                            <a onclick="specialmemberstatus('{{ $specialmemberslist->userID }}','{{ $specialmemberslist->full_name }}','{{ $specialmemberslist->status }}')"
                                                                type="button" class="dropdown-item">Status</a>
                                                        @elseif(Auth::user()->user_type_id < 14)
                                                            <a class="dropdown-item"
                                                                href="{{ url('/specialmemberstatusupdate') }}/{{ $specialmemberslist->userID }}/{{ $specialmemberslist->user_type_id }}">Status
                                                                Update</a>
                                                        @endif

                                                        <a class="dropdown-item" onclick="show_purchase_modal()"
                                                            href="{{ url('viewservices', $specialmemberslist->userID) }}"><i
                                                                class=""></i>Services</a>
                                                        <a onclick="documents('{{ $specialmemberslist->id }}','{{ $specialmemberslist->userID }}','{{ $specialmemberslist->aadhaarfile }}','{{ $specialmemberslist->nalavariyam_card }}','{{ $specialmemberslist->rationfile }}','{{ $specialmemberslist->member_photo }}','{{ $specialmemberslist->member_signature }}','{{ json_encode($specialmemberslist->documents, true) }}')"
                                                            type="button" class="dropdown-item">Documents</a>
                                                        </a>

                                                        <a onclick="memberwallets('{{ $specialmemberslist->userID }}','{{ $specialmemberslist->full_name }}','{{ $specialmemberslist->wallet }}')"
                                                            type="button" class="dropdown-item">View Wallet</a>


                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
</section>

<div class="modal fade" id="specialmembers">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Special Members</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/addmember') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            @if (Auth::user()->user_type_id == 2 ||
            Auth::user()->user_type_id == 4 ||
            Auth::user()->user_type_id == 6 ||
            Auth::user()->user_type_id == 10 ||
            Auth::user()->user_type_id == 8 ||
            Auth::user()->user_type_id == 12)
            <input type="hidden" name="user_type_id" value="20">
            @elseif(Auth::user()->user_type_id == 3 ||
            Auth::user()->user_type_id == 5 ||
            Auth::user()->user_type_id == 7 ||
            Auth::user()->user_type_id == 11 ||
            Auth::user()->user_type_id == 9 ||
            Auth::user()->user_type_id == 13)
            <input type="hidden" name="user_type_id" value="21">
            @endif
            <input type="hidden" name="status" value="Inactive">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="work_two_id">வாரியம் பெயர்</label>
                        <select class="form-control select2" name="work_two_id" id="work_two"
                           style="width: 100%;" required="required">
                           <option value=""> வாரியம் பெயர் தேர்ந்தெடு</option>
                           @foreach ($work_two as $work_twolist)
                           <option value="{{ $work_twolist->id }}">
                              {{ $work_twolist->work_two_name }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="work_there_id">தொழிலின் தன்மை</label>
                        <select class="form-control select2" name="work_there_id" id="work_there"
                           style="width: 100%;" required="required">
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="dist_id">மாவட்டத்தின் பெயர்</label>
                        <select class="form-control select2" name="dist_id" id="district"
                           style="width: 100%;" required="required">
                           <option value="">மாவட்டத்தின் பெயர்</option>
                           @foreach ($authdistrict as $authdistrictlist)
                           <option value="{{ $authdistrictlist->id }}">
                              {{ $authdistrictlist->district_name }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="taluk_id">தாலுக்கா</label>
                        <select class="form-control select2" name="taluk_id" id="taluk"
                           style="width: 100%;" required="required">
                           <option value="">தாலுக்கா</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="full_name">முழு பெயர்</label>
                        <input type="text" class="form-control" name="full_name" id="full_name"
                           placeholder="முழு பெயர்" required="required">
                     </div>
                     <div class="form-group">
                        <label for="permenent_door_no">கதவு எண்</label>
                        <input type="text" class="form-control number" name="permanent_door_no"
                           placeholder="கதவு எண்">
                     </div>
                     
                     <div class="col-md-12">
                        
                        <div class="form-group">
                           <label for="registeration_no">பதிவு எண்</label>
                           <input onkeyup="checkregno(0)" type="text" class="form-control number"
                              name="registeration_no" id="register" placeholder="பதிவு எண்">
                           <span id="duplicateregno" style="color:red"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
				  <div class="form-group">
                        <label for="phone">தொலைபேசி எண்</label>
                        <input onkeyup="checkphone(0)" type="text" class="form-control number"
                           name="phone" id="phone" placeholder="தொலைபேசி எண்" required="required"
                           maxlength="10">
                        <span id="duplicatephone" style="color:red"></span>
                     </div>
                     <div class="form-group">
                        <label for="street_name">தெருவின் பெயர்</label>
                        <input type="text" class="form-control" name="street_name"
                           placeholder="தெருவின் பெயர்">
                     </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password"
                           placeholder="Password்">
                     </div>

                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="aadhaar_no">ஆதார் எண்</label>
                        <input onkeyup="checkaadhar(0)" onchange="validateSize(this)" type="text"
                           maxlength="12" class="form-control number" name="aadhaar_no" id="aadhar"
                           placeholder="ஆதார் எண்">
                        <span id="duplicateaadhar" style="color:red"></span>
                     </div>
                     <div class="form-group">
                        <label for="post_name">அஞ்சல் பெயர்</label>
                        <input type="text" class="form-control" name="post_name"
                           placeholder="அஞ்சல பெயர்" required="required">
                     </div>
                    
                     <div class="form-group">
                        <label for="user_photo">புகைப்படம்</label>
                        <div class="input-group">
                           <input type="file" accept="image/png,image/jpeg,image/jpg"
                              class="custom-file-input" name="member_photo" id="user_photoFile"
                              autocomplete="off" required="required">
                           <label class="custom-file-label" for="user_photoFile">Choose file</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="panchayath_id">
                        கிராம நிர்வக பகுதி</label>
                        <select class="form-control select2" name="panchayath_id" id="panchayath"
                           style="width: 100%;" required="required">
                           <option value="">ஊர் பெயர்</option>
                        </select>
                     </div>
					  <div class="form-group">
                        <label for="pincode">பின்கோடு</label>
                        <input type="text" onchange="validateSize(this)" maxlength="6"
                           class="form-control number" name="pincode" placeholder="பின்கோடு"
                           required="required">
                     </div>
                    
                     <div class="form-group">
                        <label for="dob">பிறந்த தேதி</label>
                        <input type="date" class="form-control" name="dob" placeholder="பிறந்த தேதி">
                     </div>
                  </div>
               </div>
               <hr>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button id="save" type="submit" class="btn btn-primary">Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="userdata">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="full_name"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>ID </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="id"></span> </label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span
                  style="color:red"></span>Registeration No
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="username"></span> </label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="districtname"></span> </label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Taluk
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="talukname"></span> </label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Panchayath
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="panchayathname"></span> </label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Password
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="pas"></span></label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Phone
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="phones"></span></label>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
               </label>
               <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                  id="status"></span> </label>
            </div>
            <center>
               <a class="btn btn-info" href="" id="msgbtn" data-action="share/whatsapp/share"
                  target="_blank">Send Whatsapp</a>
            </center>
         </div>
         <div class="modal-footer justify-content-between">
            <a type="" class=""></a>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="wallets">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="name"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <div class="text-center">
                  <h1 id="userwallet"></h1>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <a type="" class=""></a>
               <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="document">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="full_name"></h4>
            <h3>Special Member Documents</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body text-center">
            <form action="{{ url('/addmemberdocument') }}" method="post" enctype="multipart/form-data">
               {{ csrf_field() }}
               <input type="hidden" name="customer_id" value="" id="customer_id" />
               <div class="row">
                  <div class="col col-md-4">
                     <input class="form-control" required type="text" placeholder="Document Name"
                        name="doc_name" maxlength="20" />
                  </div>
                  <div class="col col-md-6">
                     <input class="form-control" required accept="image/*" type="file" name="file_name" />
                  </div>
                  <div class="col col-md-2">
                     <input type="submit" class="btn btn-success btn-sm" name="submit" value="Upload">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-body text-center" id="extra_documents">
         </div>
         <div class="modal-body text-center">
            <span style="color: red">Aadhaar</span>
            <center>
               <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="svn" />
            </center>
            <a id="aadhardownload" href="" type="button" class="btn btn-primary btn-sm"
               download>Download</a>
            <hr>
         </div>
         <div class="modal-body text-center">
            <span style="color: red">Nalavariyam</span>
            <center>
               <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="nalavariyam" />
            </center>
            <a href="" id="carddownload" type="button" class="btn btn-primary btn-sm"
               download>Download</a>
            <hr>
         </div>
         <div class="modal-body text-center">
            <span style="color: red">Ration</span>
            <center>
               <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="ration" />
            </center>
            <a id="rationdownload" href="" type="button" class="btn btn-primary btn-sm"
               download>Download</a>
            <hr>
         </div>
         <div class="modal-body text-center">
            <span style="color: red">Member</span>
            <center>
               <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="member" />
            </center>
            <a id="memberdownload" href="" type="button" class="btn btn-primary btn-sm"
               download>Download</a>
            <hr>
         </div>
         <div class="modal-body text-center">
            <span style="color: red">Signature</span>
            <center>
               <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="sign" />
            </center>
            <a id="signdownload" href="" type="button" class="btn btn-primary btn-sm"
               download>Download</a>
         </div>
         <div class="modal-footer justify-content-between">
            <a type="" class=""></a>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="specialmemberstatusmodel">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="statusname"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ url('/specialmemberstatus') }}" method="post">
               {{ csrf_field() }}
               <input type="hidden" name="userid" id="statusid">
               <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" id="userstatus" style="width: 100%;">
                     <option value="">Select Status</option>
                     <option value="Active">Active</option>
                     <option value="Inactive">Inactive</option>
                  </select>
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                  <button id="save" type="submit" class="btn btn-primary">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@push('page_scripts')
<script>
   function userdatas(id, full_name, regesteration_no, district_name, taluk_name, panchayath_name, pas,
       phone, status) {
       $("#id").text(id);
       $("#full_names").text(full_name);
       $("#username").text(regesteration_no);
       $("#districtname").text(district_name);
       $("#talukname").text(taluk_name);
       $("#panchayathname").text(panchayath_name);
       $("#pas").text(pas);
       $("#phones").text(phone);
       $("#status").text(status);
       $('#msgbtn').attr('href', 'https://api.whatsapp.com/send?phone=91' + phone +
           '&text=Sir, We are from NalaVariyam , Your Login UserName : ' + username + ', Password : ' + pas +
           ', Contact Us : Mobile 7598984380 Email : ramjitrust039@gmail.com, Websit : www.nalavariyam.com. I have attached your Login website  link below https://nalavariyam.com/apps/'
       )
       $("#userdata").modal("show");
   }
   $('#district').on('change', function() {
       var idTaluk = this.value;
       $("#taluk").html('');
       $.ajax({
           url: "{{ url('/gettaluk') }}",
           type: "POST",
           data: {
               taluk_id: idTaluk,
               _token: '{{ csrf_token() }}'
           },
           dataType: 'json',
           success: function(result) {
               $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
               $.each(result, function(key, value) {
                   $("#taluk").append('<option value="' + value
                       .id + '">' + value.taluk_name + '</option>');
               });
               $('#panchayath').html('<option value="">-- Select Panchayath --</option>');
           }
       });
   });

   $('#taluk').on('change', function() {
       var idPanchayath = this.value;
       $("#panchayath").html('');
       $.ajax({
           url: "{{ url('/getpanchayath') }}",
           type: "POST",
           data: {
               panchayath_id: idPanchayath,
               _token: '{{ csrf_token() }}'
           },
           dataType: 'json',
           success: function(result) {
               $('#panchayath').html('<option value="">-- Select Panchayath Name --</option>');
               $.each(result, function(key, value) {
                   $("#panchayath").append('<option value="' + value
                       .id + '">' + value.panchayath_name + '</option>');
               });
           }
       });
   });
</script>
<script>
   $(function() {
       bsAadhaarfileFileInput.init();
       bsSignature2FileInput.init();
       bsuser_photoFileInput.init();
       bsRationfileFileInput.init();
   });
</script>
<script>
   $('#work_two').on('change', function() {
       var work_two = this.value;
       $("#work_there").html('');
       $.ajax({
           url: "{{ url('/get_sub_work_there') }}",
           type: "POST",
           data: {
               work_two_id: work_two,
               _token: '{{ csrf_token() }}'
           },
           dataType: 'json',

           success: function(result) {
               //console.log(JSON.stringify(result));
               $('#work_there').html('<option value="">-- Select Work There Name --</option>');
               $.each(result, function(key, value) {
                   $("#work_there").append('<option value="' + value
                       .id + '">' + value.work_there_name + '</option>');
               });
           }
       });
   });
</script>
<script>
   function memberwallets(id, full_name, wallet) {
       $("#id").text(id);
       $("#name").text(full_name);
       $("#userwallet").text(wallet);
       $("#wallets").modal("show");
   }
   function specialmemberstatus(id, full_name, status) {
       $("#statusid").val(id);
       $("#statusname").text(full_name);
       $("#userstatus").val(status);
       $("#specialmemberstatusmodel").modal("show");

   }
   function documents(customer_id, id, aadhaarfile, nalavariyam_card, rationfile, member_photo, member_signature,
   doc) {
       var html = "";
       doc = JSON.parse(doc);
       for (let i = 0; i < doc.length; i++) {
           let obj = doc[i];
           html = html + "<span style='color: red'>" + obj.doc_name + "</span>";
           html = html + "<center><img style='width:200px;height:100%;padding-bottom:10px;' src='../upload/document/" +
               obj.file_name + "' /></center>";
           html = html + "<a href='../upload/document/" + obj.file_name +
               "' type='button' class='btn btn-primary btn-sm' download>Download</a>";
           html = html + "<hr>";
       }
       $("#extra_documents").html(html);
       $("#customer_id").val(customer_id);
       $("#imgid").text(id);
       $("#svn").attr("src", "../upload/aadhaar_card/" + aadhaarfile);
       $('a#aadhardownload').attr({
           href: '../upload/aadhaar_card/' + aadhaarfile
       });

       $("#nalavariyam").attr("src", "../upload/nalavariyamcard/" + nalavariyam_card);
       $('a#carddownload').attr({
           href: '../upload/nalavariyamcard/' + nalavariyam_card
       });

       $("#ration").attr("src", "../upload/ration_card/" + rationfile);
       $('a#rationdownload').attr({
           href: '../upload/ration_card/' + rationfile
       });

       $("#member").attr("src", "../upload/member_photo/" + member_photo);
       $('a#memberdownload').attr({
           href: '../upload/member_photo/' + member_photo
       });

       $("#sign").attr("src", "../upload/member_signature/" + member_signature);
       $('a#signdownload').attr({
           href: '../upload/member_signature/' + member_signature
       });

       $("#document").modal("show");
   }
</script>
@endpush
