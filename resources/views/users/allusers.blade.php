@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
           
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View Taluk Users Details</h3>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th> S No</th>
                                        <th> referral</th>
                                        <th> usertype</th>
                                        <th> District</th>
                                        <th> Taluk </th>
                                        <th> panchayath </th>
                                        <th> user</th>
                                        <th> Name</th>
                                        <th> phone</th>
                                        <th> status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allusers as $alluserslist)
                                        <tr>
                                            <td>{{ $alluserslist->id}}</td>
                                            <td>{{ $alluserslist->referral_id}}</td>
                                            <td>{{ $alluserslist->user_type_id}}</td>
                                            <td>{{ $alluserslist->district_name}}</td>
                                            <td>{{ $alluserslist->taluk_name }}</td>
                                            <td>{{ $alluserslist->panchayath_name }}</td>
                                            <td>{{ $alluserslist->username }}</td>
                                            <td>{{ $alluserslist->full_name }}</td>
                                            <td>{{ $alluserslist->phone }}</td>
                                            <td>{{ $alluserslist->status }}</td>
                                           
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
@endsection
@push('page_scripts')
    <script>
        function userdatas(id,username,pas, full_name, user_photo, username, district_name, taluk_name, email, pas, phone, status) {
            $("#id").text(id);
            $("#full_name").text(full_name);
            $("#user_photo").text(user_photo);
            $("#username").text(username);
            $("#district_name").text(district_name);
            $("#talukname").text(taluk_name);
            $("#emails").text(email);
            $("#pas").text(pas);
            $("#phones").text(phone);
            $("#status").text(status);
            $("#userdata").modal("show");
            $('#msgbtn').attr('href','https://api.whatsapp.com/send?phone=91'+phone+'&text=Sir, We are from NalaVariyam , Your Login UserName : '+username+', Password : '+pas+', Contact Us : Mobile 7598984380 Email : ramjitrust039@gmail.com, Websit : www.nalavariyam.com. I have attached your Login website  link below https://nalavariyam.com/apps/')
        }
        $('#dist_id').on('change', function() {
            var district_id = this.value;
            $("#taluk").html('');
            var url = "{{ url('/gettaluklimit') }}/" + district_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
                    $.each(result, function(key, value) {
                        $("#taluk").append('<option value="' + value
                            .id + '">' + value.taluk_name + '</option>');
                    });
                }
            });
        });
    </script>
<script>
    function userwallet(id, full_name,wallet){
        $("#id").text(id);
        $("#name").text(full_name);
        $("#userwallet").text(wallet);
        $("#wallets").modal("show");
    }
	function userstatus(id, full_name,fromto_date,status){
		$("#statusid").val(id);
        $("#statusname").text(full_name);
		$("#fromdate").val(fromto_date);
		$("#userstatus").val(status);
		$("#userstatusmodal").modal("show");
		
	}
</script>
@endpush
