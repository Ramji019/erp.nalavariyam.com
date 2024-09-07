@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Customers</h1>
                </div>
                <div class="col-sm-6">
                    @if (Auth::user()->user_type_id == 1)
                    @else
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                                    data-toggle="modal" data-target="#Addcustomers"><i class="fa fa-plus"> Add </i></button>
                            </li>&nbsp;
                             @if (Auth::user()->id == 41 ||
                            Auth::user()->id == 65 ||
                            Auth::user()->id == 97 ||
                            Auth::user()->id == 201 ||
                            Auth::user()->id == 11719 )
                             <a href="" data-toggle="modal" data-target="#Addowncustomers"
                                            class="btn btn-primary btn-sm"><i class="fas fa-plus">
                                                Own Customer</i> </a>
                                                @endif
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
                            <div class="col-md-12">
                                <div class="row">
                                    <div style="padding-top: 3px">
                                        <P>page per</P>
                                    </div>
                                    <div class="col-md-1">
                                        <select class="form-control" id="pageper">
                                            <option value="1">1</option>
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div style="padding-top: 3px">
                                        <P>Sort By</P>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" id="sortby">
                                            <option value="product_id-ASC">date(Oldest First)</option>
                                            <option value="product_id-desc">date(Latest First)</option>

                                        </select>
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                    <div style="padding-top: 3px">
                                        <P>Search</P>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="serach" id="serach" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> S No</th>
                                            <th> ID</th>
                                            <th> District</th>
                                            <th> Full Name</th>
                                            <th> Phone</th>
                                            <th> Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('customers/customerpaginate')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="Addcustomers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customers Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addcustomer') }}" method="post">
                    {{ csrf_field() }}
                    @if (Auth::user()->user_type_id == 2 ||
                            Auth::user()->user_type_id == 4 ||
                            Auth::user()->user_type_id == 6 ||
                            Auth::user()->user_type_id == 10 ||
                            Auth::user()->user_type_id == 8 ||
                            Auth::user()->user_type_id == 12)
                        <input type="hidden" name="user_type_id" value="14">
                    @elseif(Auth::user()->user_type_id == 3 ||
                            Auth::user()->user_type_id == 5 ||
                            Auth::user()->user_type_id == 7 ||
                            Auth::user()->user_type_id == 11 ||
                            Auth::user()->user_type_id == 9 ||
                            Auth::user()->user_type_id == 13)
                        <input type="hidden" name="user_type_id" value="15">
                    @endif
                    <div class="modal-body">

                                @if (Auth::user()->user_type_id == 2 ||
                                        Auth::user()->user_type_id == 3 ||
                                        Auth::user()->user_type_id == 4 ||
                                        Auth::user()->user_type_id == 5)
                                    <div class="form-group">
                                        <label>District Name</label>
                                        <select required="required" class="form-control select2" name="dist_id" id="dist_id"
                                            style="width: 100%;">
                                            <option value="">Select District Name</option>
                                            @foreach ($authdistrict as $district)
                                                <option value="{{ $district->id }}">{{ $district->district_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif(Auth::user()->user_type_id == 6 ||
                                        Auth::user()->user_type_id == 7 ||
                                        Auth::user()->user_type_id == 8 ||
                                        Auth::user()->user_type_id == 9 ||
                                        Auth::user()->user_type_id == 10 ||
                                        Auth::user()->user_type_id == 11 ||
                                        Auth::user()->user_type_id == 12 ||
                                        Auth::user()->user_type_id == 13)
                                    <div class="form-group">
                                        <label>District Name</label>
                                        <select required="required" class="form-control select2" name="dist_id" id="dist_id"
                                            style="width: 100%;">
                                            <option value="">Select District Name</option>
                                            @foreach ($authdistrict as $authdistrictlist)
                                                <option value="{{ $authdistrictlist->id }}">
                                                    {{ $authdistrictlist->district_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Taluk Name</label>
                                    <select required="required" class="form-control select2" name="taluk_id" id="taluk"
                                        style="width: 100%;">
                                        <option value="">Select Taluk Name</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input required="required" onkeydown="return /[a-z]/i.test(event.key)" type="text" class="form-control" maxlength="50" name="full_name_tamil" id="full_name_tamil" placeholder="Enter Full Name">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Aadhaar Number</label>
                                    <input required="required" onkeyup="checkaadhar(0)" type="text" maxlength="12" class="form-control number" name="aadhaar_no" id="aadhar" placeholder="Enter Aadhaar Number">
                                     <span id="duplicateaadhar" style="color:red"></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input required="required" type="text" class="form-control number" name="phone" id="phone" placeholder="Enter Phone" onkeyup="checkphone(0)" maxlength="10">
                                    <span id="duplicatephone" style="color:red"></span>
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

        <div class="modal fade" id="Addowncustomers">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customers Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/addowncustomer') }}" method="post">
                    {{ csrf_field() }}
                     @if (Auth::user()->user_type_id == 2 ||
                            Auth::user()->user_type_id == 4 ||
                            Auth::user()->user_type_id == 6 ||
                            Auth::user()->user_type_id == 10 ||
                            Auth::user()->user_type_id == 8 ||
                            Auth::user()->user_type_id == 12)
                        <input type="hidden" name="user_type_id" value="14">
                    @elseif(Auth::user()->user_type_id == 3 ||
                            Auth::user()->user_type_id == 5 ||
                            Auth::user()->user_type_id == 7 ||
                            Auth::user()->user_type_id == 11 ||
                            Auth::user()->user_type_id == 9 ||
                            Auth::user()->user_type_id == 13)
                        <input type="hidden" name="user_type_id" value="15">
                    @endif
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="dist_id" value="{{ $authdistrictown->id }}">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" name="full_name"
                                        placeholder="Enter Full Name">
                                </div>
                                 <div class="form-group">
                                    <label for="full_name">Mobile Number</label>
                                    <input type="text" class="form-control" name="phone"
                                        placeholder="Enter Mobile Number">
                                </div>
                                 <div class="form-group">
                                    <label for="full_name">Application No</label>
                                    <input type="text" class="form-control" name="application_no"
                                        placeholder="Enter Application Number">
                                </div>
                                  <div class="form-group">
                                    <label>Service Name</label>
                                    <select class="form-control select2" name="service_name"
                                        style="width: 100%;">
                                        <option value="">Select Service Name</option>
                                        <option value="பதிவு">பதிவு</option>
                                        <option value="புதுப்பித்தல்">புதுப்பித்தல்</option>
                                         <option value="6வது பயில">6வது பயில</option>
                                         <option value="7வது பயில">7வது பயில</option>
                                         <option value="8வது பயில">8வது பயில</option>
                                         <option value="9வது பயில">9வது பயில</option>
                                         <option value="10வது பயில">10வது பயில</option>
                                         <option value="10வது தேர்ச்சி">10வது தேர்ச்சி</option>
                                         <option value="11வது பயில">11வது பயில</option>
                                         <option value="12வது பயில">12வது பயில</option>
                                         <option value="12வது தேர்ச்சி">12வது தேர்ச்சி</option>
                                         <option value="பட்டபடிப்பு 1">பட்டபடிப்பு 1</option>
                                         <option value="பட்டபடிப்பு 2">பட்டபடிப்பு 2</option>
                                         <option value="பட்டபடிப்பு 3">பட்டபடிப்பு 3</option>
                                         <option value="பட்டபடிப்பு 4">பட்டபடிப்பு 4</option>
                                         <option value="பட்ட மேற்படிப்பு 1">பட்ட மேற்படிப்பு 1</option>
                                         <option value="பட்ட மேற்படிப்பு 2">பட்ட மேற்படிப்பு 2</option>
                                         <option value="திருமணம்">திருமணம்</option>
                                         <option value="மகப்பேறு">மகப்பேறு</option>
                                         <option value="ஓய்வூதியம்">ஓய்வூதியம்</option>
                                         <option value="இயற்கை மரணம்">இயற்கை மரணம்</option>
                                         <option value="விபத்து மரணம்">விபத்து மரணம்</option>
                                         <option value="ஆயுள் சான்று">ஆயுள் சான்று</option>
                                    </select>
                                </div>
                            </div>
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

    <div class="modal fade" id="document">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="full_name"></h4>
                    <h3>Customer Documents</h3>
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
                    <span style="color: red">Signature</span>
                    <center>
                        <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="sign" />
                    </center>
                    <a id="signdownload" href="" type="button" class="btn btn-primary btn-sm"
                        download>Download</a>
                    <hr>
                </div>
                <div class="modal-footer justify-content-between">
                    <a type="" class=""></a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        $('#dist_id').on('change', function() {
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

        function documents(customer_id, id, aadhaarfile, nalavariyam_card, rationfile, member_signature,
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

            $("#sign").attr("src", "../upload/member_signature/" + member_signature);
            $('a#signdownload').attr({
                href: '../upload/member_signature/' + member_signature
            });

            $("#document").modal("show");
        }

        $(document).ready(function() {


function fetch_data(page, query, limit, sortby, sortorder) {
    var cururl = "{{ url('/') }}";
    $.ajax({
        url: cururl + "/customerpagination/fetch_data?page=" + page + "&query=" + query +
            "&perpage=" +
            limit + "&sortby=" + sortby + "&sortorder=" + sortorder,
        success: function(data) {
            console.log(data);
            $('tbody').html('');
            $('tbody').html(data);
        }
    })
}

$(document).on('change', '#pageper', function() {
    var query = $('#serach').val();
    var page = $('#hidden_page').val();
    var limit = $("#pageper").val();
    var sortby = $("#sortby").val().split("-")[0];
    var sortorder = $("#sortby").val().split("-")[1];
    fetch_data(page, query, limit, sortby, sortorder);
});

$(document).on('change', '#sortby', function() {
    var query = $('#serach').val();
    var page = $('#hidden_page').val();
    var limit = $("#pageper").val();
    var sortby = $("#sortby").val().split("-")[0];
    var sortorder = $("#sortby").val().split("-")[1];
    fetch_data(page, query, limit, sortby, sortorder);
});


$(document).on('keyup', '#serach', function() {
    var query = $('#serach').val();
    var page = $('#hidden_page').val();
    var limit = $("#pageper").val();
    var sortby = $("#sortby").val().split("-")[0];
    var sortorder = $("#sortby").val().split("-")[1];
    fetch_data(page, query, limit, sortby, sortorder);
});


$(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    $('#hidden_page').val(page);

    var query = $('#serach').val();
    var limit = $("#pageper").val();
    var sortby = $("#sortby").val().split("-")[0];
    var sortorder = $("#sortby").val().split("-")[1];

    $('li').removeClass('active');
    $(this).parent().addClass('active');
    fetch_data(page, query, limit, sortby, sortorder);
});

});
    </script>
@endpush
