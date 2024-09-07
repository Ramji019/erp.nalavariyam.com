@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Family Member</h1>
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
                                                    '{{ $familymemberlist->studying_course }}',
                                                    '{{ $familymemberlist->academic_year }}',
                                                    '{{ $familymemberlist->family_dob }}'
                                                    )"
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
                                                    '{{ $familymemberlist->family_relationship }}',
                                                    '{{ $familymemberlist->studying_course }}',
                                                    '{{ $familymemberlist->academic_year }}',
                                                    '{{ $familymemberlist->family_dob }}'
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
                                        <label for="academic_year">Academic Year</label>
                                        <div class="input-group">
                                            <select class="form-control" name="academic_year" style="width: 100%;">
                                                <option value="">Select  Academic Year</option>
                                                <option value="2023 - 2024">2023 - 2024</option>
                                                <option value="2024 - 2025">2024 - 2025</option>
                                                <option value="2025 - 2026">2025 - 2026</option>
                                                <option value="2026 - 2027">2026 - 2027</option>
                                                <option value="2028 - 2029">2028 - 2029</option>
                                                <option value="2029 - 2030">2029 - 2030</option>
                                            </select>
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
                                <label for="academic_year">Academic Year</label>
                                <div class="input-group">
                                    <select class="form-control" name="academic_year" id="academic" style="width: 100%;">
                                        <option value="">Select  Academic Year</option>
                                        <option value="2023 - 2024">2023 - 2024</option>
                                        <option value="2024 - 2025">2024 - 2025</option>
                                        <option value="2025 - 2026">2025 - 2026</option>
                                        <option value="2026 - 2027">2026 - 2027</option>
                                        <option value="2028 - 2029">2028 - 2029</option>
                                        <option value="2029 - 2030">2029 - 2030</option>
                                    </select>
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
    function userdatas(id, family_member_name, family_relationship, studying_course, academic_year, family_dob) {
        $("#userid").val(id);
        $("#membername").val(family_member_name);
        $("#relatives").val(family_relationship);
        $("#course").val(studying_course);
        $("#academic").val(academic_year);
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
