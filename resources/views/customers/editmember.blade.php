@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Members</h1>
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
                            @foreach ($members as $member)
                                <form action="{{ url('/updatemembers') }}" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{ $member->id }}" />
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="work_two_id">வாரியம் பெயர்</label>
                                                    <select class="form-control select2" name="work_two_id" id="work_two"
                                                        style="width: 100%;" required="required">
                                                        <option value=""> வாரியம் பெயர் தேர்ந்தெடு</option>
                                                        @foreach ($work_two as $work)
                                                            <option @if ($member->work_two_id == $work->id) selected @endif
                                                                value="{{ $work->id }}">{{ $work->work_two_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="work_there_id">தொழிலின் தன்மை</label>
                                                    <select class="form-control select2" name="work_there_id"
                                                        id="work_there_id" style="width: 100%;" required="required">
                                                        <option value=""></option>
                                                        @foreach ($work_there as $working)
                                                            <option @if ($member->work_there_id == $working->id) selected @endif
                                                                value="{{ $working->id }}">{{ $working->work_there_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="dist_id">மாவட்டத்தின் பெயர்</label>
                                                    <select class="form-control select2" name="dist_id" id="district"
                                                        style="width: 100%;" required="required">
                                                        <option value="">மாவட்டத்தின் பெயர்</option>
                                                        @foreach ($managedistrict as $district)
                                                            <option @if ($member->dist_id == $district->id) selected @endif
                                                                value="{{ $district->id }}">{{ $district->district_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="taluk_id">தாலுக்கா</label>
                                                    <select class="form-control select2" name="taluk_id" id="taluk_id"
                                                        style="width: 100%;" required="required">
                                                        @foreach ($managetaluk as $taluk)
                                                            <option @if ($member->taluk_id == $taluk->id) selected @endif
                                                                value="{{ $taluk->id }}">{{ $taluk->taluk_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="full_name">முழு பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->full_name }}" name="full_name" id="full_name"
                                                        placeholder="முழு பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="permenent_door_no">கதவு எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->permanent_door_no }}" name="permanent_door_no"
                                                        placeholder="கதவு எண்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">தொலைபேசி எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->phone }}" name="phone" id="phone"
                                                        placeholder="தொலைபேசி எண்" onkeyup="checkphone(0)" maxlength="10">
                                                    <span id="dupphone" style="color:red"></span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add">ஆதார்</label>
                                                        <div class="input-group roe">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    name="aadhaarfile" autocomplete="off">
                                                                <label class="custom-file-label"
                                                                    for="exampleInputFile">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="registeration_date">பதிவு நாள்</label>
                                                        <input type="date" class="form-control"
                                                            value="{{ $member->registeration_date }}"
                                                            name="registeration_date" placeholder="பதிவு நாள்">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="father_or_husband_name">தந்தை / கனவர் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->father_or_husband_name }}"
                                                        name="father_or_husband_name" placeholder="தந்தை / கனவர் பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="street_no">தெருவின் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->street_name }}" name="street_name"
                                                        placeholder="தெருவின் பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="pincode">பின்கோடு</label>
                                                    <input type="text" onchange="validateSize(this)" maxlength="6"
                                                        class="form-control number" value="{{ $member->pincode }}"
                                                        name="pincode" placeholder="பின்கோடு">
                                                </div>
                                                <div class="form-group">
                                                    <label for="rationfile">குடும்ப அட்டை</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="rationfile"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="rationfile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="renew_date">புதுப்பித்தல்</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $member->registeration_date }}" name="renew_date"
                                                        placeholder="புதுப்பித்தல்">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="aadhaar_no">ஆதார் எண்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->aadhaar_no }}" onkeyup="checkaadhar(0)"
                                                        maxlength="12" name="aadhaar_no" placeholder="ஆதார் எண்">
                                                    <span id="duplicateaadhar" style="color:red"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="post_name">அஞ்சல் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->post_name }}" name="post_name"
                                                        placeholder="அஞ்சல பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="signature2">கையொப்பம்</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="signature2"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="add">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nalavariyam_card">நலவாரியம் அட்டை</label>
                                                    <div class="input-group roe">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                name="nalavariyam_card" id="nalavariyamFile"
                                                                autocomplete="off" required="required">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dob">பிறந்த தேதி</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $member->dob }}" name="dob"
                                                        placeholder="பிறந்த தேதி">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="family_smart_card_no">குடும்ப அட்டை எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->family_smart_card_no }}"
                                                        name="family_smart_card_no" placeholder="குடும்ப அட்டை எண்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="panchayath_id">
                                                        கிராம நிர்வக பகுதி</label>
                                                    <select class="form-control select2" name="panchayath_id"
                                                        id="panchayath_id" style="width: 100%;" required="required">
                                                        @foreach ($managepanchayath as $panchayath)
                                                            <option @if ($member->panchayath_id == $panchayath->id) selected @endif
                                                                value="{{ $panchayath->id }}">
                                                                {{ $panchayath->panchayath_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="member_photo">புகைப்படம்</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="member_photo"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="member_photo">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="registeration_no">பதிவு எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->registeration_no }}"
                                                        name="registeration_no" placeholder="பதிவு எண்">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6 text-center">
                                                @if ($countmember == 0)
                                                    <button type="button" class="btn btn-primary btn-md"
                                                        data-toggle="modal" data-target="#Add"><i class="fa fa-plus"> Add
                                                            Child 1</i>
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($countmember == 1)
                                    @foreach ($familymember as $familymemberlist)
                                        <a onclick="userdatas('{{ $familymemberlist->id }}',
                                                     '{{ $familymemberlist->family_member_name }}',
                                                     '{{ $familymemberlist->family_relationship }}',
                                                     '{{ $familymemberlist->family_dob }}',
                                                     '{{ $familymemberlist->studying_course }}')"
                                            href="#" class="btn btn-primary btn-md "><i
                                                class="fa fa-edit">{{ $familymemberlist->family_member_name }}</i></a>
                                        &nbsp;
                                    @endforeach
                        </div>
                        <div class="col-sm-6 text-center">
                            <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                data-target="#Add"><i class="fa fa-plus"> Add Child 2</i>
                            </button>
                        </div>
                    </div>
                @else
                </div>
            </div>
            <div class="row">
                @foreach ($familymember as $familymemberlist)
                    <div class="col-sm-6 text-center">
                        <a onclick="userdatas('{{ $familymemberlist->id }}',
                                                    '{{ $familymemberlist->family_member_name }}',
                                                    '{{ $familymemberlist->family_relationship }}','{{ $familymemberlist->studying_course }}','{{ $familymemberlist->family_dob }}'
                                                    )"
                            href="#" class="btn btn-primary tn-md">{{ $familymemberlist->family_member_name }}</a>
                    </div>
                @endforeach
            </div>
            @endif
            </br>
            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <input id="save" class="btn btn-info" type="submit" name="submit" value="Submit" />
                </div>
            </div>
            </form>
            @endforeach
        </div>
        </div>
        </div>
        </div>
        </div>

        <div class="modal fade" id="Add">
            <form action="{{ url('/addfamilymember') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Child</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="customer_id" value="{{ $customers_id }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="family_member_name">குழந்தை பெயர்</label>
                                        <input type="text" class="form-control" name="family_member_name"
                                            placeholder="குழந்தை பெயர்">
                                    </div>
                                    <div class="form-group">
                                        <label for="family_relationship"> உறவுமுறை</label>
                                        <select class="form-control select2" name="family_relationship"
                                            style="width: 100%;">
                                            <option value="">உறவுமுறை</option>
                                            <option value="மகன்">மகன்</option>
                                            <option value="மகள்">மகள்</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="studying_course"> பயிலும் கல்வி </label>
                                        <select class="form-control select2" name="studying_course" style="width: 100%;">
                                            <option value="">பயிலும் கல்வி</option>
                                            <option value="Master Degree 2nd Year">Master Degree 2nd Year</option>
                                            <option value="Master Degree 1st Year">Master Degree 1st Year</option>
                                            <option value="Degree 4th Year">Degree 4th Year</option>
                                            <option value="Degree 3rd Year">Degree 3rd Year</option>
                                            <option value="Degree 2nd Year">Degree 2nd Year</option>
                                            <option value="Degree 1st Year">Degree 1st Year</option>
                                            <option value="12th Standard">12th Standard</option>
                                            <option value="11th Standard">11th Standard</option>
                                            <option value="10th Standard">10th Standard</option>
                                            <option value="9th Standard">9th Standard</option>
                                            <option value="8th Standard">8th Standard</option>
                                            <option value="7th Standard">7th Standard</option>
                                            <option value="6th Standard">6th Standard</option>
                                            <option value="5th Standard">5th Standard</option>
                                            <option value="4th Standard">4th Standard</option>
                                            <option value="3rd Standard">3rd Standard</option>
                                            <option value="2nd Standard">2nd Standard</option>
                                            <option value="1st Standard">1st Standard</option>
                                            <option value="U.K.G">U.K.G</option>
                                            <option value="L.K.G">L.K.G</option>
                                            <option value="Pre.K.G">Pre.K.G</option>
                                            <option value="Age 2">Age 2</option>
                                            <option value="Age 1">Age 1</option>
                                            <option value="குழந்தை இல்லை">குழந்தை இல்லை</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="childone_aadhaar_file">Child ஆதார்</label>
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input" name="childone_aadhaar_file"
                                                id="childoneFile" autocomplete="off">
                                            <label class="custom-file-label" for="childoneFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="family_dob">பிறந்த தேதி</label>
                                        <input type="date" class="form-control" name="family_dob"
                                            placeholder="புதுப்பித்தல் தேதி">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button id="save" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="userdata">
            <form action="{{ url('/updatefamilymember') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id=""></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="family_id" id="userid">
                            <input type="hidden" name="customer_id" value="{{ $customers_id }}">
                            <div class="form-group">
                                <label for="family_member_name">குழந்தை பெயர்</label>
                                <input type="" class="form-control" name="family_member_name" id="membername"
                                    placeholder="குழந்தை பெயர்">
                            </div>
                            <div class="form-group">
                                <label for="family_relationship"> உறவுமுறை</label>
                                <select class="form-control" name="family_relationship" id="relatives"
                                    style="width: 100%;">
                                    <option value="">உறவுமுறை</option>
                                    <option value="மகன்">மகன்</option>
                                    <option value="மகள்">மகள்</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="studying_course"> பயிலும் கல்வி </label>
                                <select class="form-control" name="studying_course" id="course" style="width: 100%;">
                                    <option value="">பயிலும் கல்வி</option>
                                    <option value="Master Degree 2nd Year">Master Degree 2nd Year</option>
                                    <option value="Master Degree 1st Year">Master Degree 1st Year</option>
                                    <option value="Degree 4th Year">Degree 4th Year</option>
                                    <option value="Degree 3rd Year">Degree 3rd Year</option>
                                    <option value="Degree 2nd Year">Degree 2nd Year</option>
                                    <option value="Degree 1st Year">Degree 1st Year</option>
                                    <option value="12th Standard">12th Standard</option>
                                    <option value="11th Standard">11th Standard</option>
                                    <option value="10th Standard">10th Standard</option>
                                    <option value="9th Standard">9th Standard</option>
                                    <option value="8th Standard">8th Standard</option>
                                    <option value="7th Standard">7th Standard</option>
                                    <option value="6th Standard">6th Standard</option>
                                    <option value="5th Standard">5th Standard</option>
                                    <option value="4th Standard">4th Standard</option>
                                    <option value="3rd Standard">3rd Standard</option>
                                    <option value="2nd Standard">2nd Standard</option>
                                    <option value="1st Standard">1st Standard</option>
                                    <option value="U.K.G">U.K.G</option>
                                    <option value="L.K.G">L.K.G</option>
                                    <option value="Pre.K.G">Pre.K.G</option>
                                    <option value="Age 2">Age 2</option>
                                    <option value="Age 1">Age 1</option>
                                    <option value="குழந்தை இல்லை">குழந்தை இல்லை</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="childone_aadhaar_file">Child1 ஆதார்</label>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input" name="childone_aadhaar_file"
                                        id="childoneFile" autocomplete="off">
                                    <label class="custom-file-label" for="childoneFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="family_dob">பிறந்த தேதி</label>
                                <input type="date" class="form-control" name="family_dob" id="dob"
                                    placeholder="புதுப்பித்தல் தேதி">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="save" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('page_scripts')
<script>
    $('#child_status').change(function(event) {
        if ($('#child_status').val() != "Yes") {
            $('#spouse_name').val("");
            $('#child_name').val("");
            $('#spouse_name').attr("readonly", true);
            $('#child_name').attr("readonly", true);
        } else {
            $('#spouse_name').attr("readonly", false);
            $('#child_name').attr("readonly", false);
        }
    });
</script>
<script>
    function userdatas(id, family_member_name, family_relationship, studying_course, family_dob) {
        $("#userid").val(id);
        $("#membername").val(family_member_name);
        $("#relatives").val(family_relationship);
        $("#course").val(studying_course);
        $("#dob").val(family_dob);
        $("#userdata").modal("show");
    }
    $('#dist_id').on('change', function () {
                  var idTaluk = this.value;
                  $("#taluk").html('');
                  $.ajax({
                      url: "{{url('/gettaluk')}}",
                      type: "POST",
                      data: {
                          taluk_id: idTaluk,
                          _token: '{{csrf_token()}}'
                      },
                      dataType: 'json',
                      success: function (result) {
                          $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
                          $.each(result, function (key, value) {
                              $("#taluk").append('<option value="' + value
                                  .id + '">' + value.taluk_name + '</option>');
                          });
                          $('#panchayath').html('<option value="">-- Select Panchayath --</option>');
                      }   
                  });
              });
              
          $('#taluk').on('change', function() {
              var taluk_id = this.value;
              $("#panchayath").html('');
              var url = "{{ url('/getpanchayathlimit') }}/" + taluk_id;
              $.ajax({
                  url: url,
                  type: "GET",
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
      @endpush
