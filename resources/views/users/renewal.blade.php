@extends('layouts.app')
@section('content')
<section class="content-header">
 <div class="container-fluid">
  <div class="row mb-2">
   <div class="col-sm-6">
    <h1>Activation Amount</h1>
  </div>
  <div class="col-sm-6">
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
                  <form method="post" action="updaterenewamount">
                     {{ csrf_field() }}
                  <table id="example6" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Renewal By</th>
                           <th>Activation Amount</th>
                           <th>Renewal Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td style="font-weight:bold" colspan="4" align="center">District</td>
                        </tr>  
                        @foreach($district as $key => $list)
                        <tr>
                           <td>{{ $types[$list->renewal_by] }}</td>
                           <td><input type="hidden" name="id[]" value="{{ $list->id }}" /><input name="reg_amount[]" class="number" type="text" maxlength="6" value="{{ $list->reg_amount }}" /></td>
                           <td><input class="number" name="renew_amount[]" type="text" maxlength="6" value="{{ $list->renew_amount }}" /></td>
                        </tr>
                        @endforeach
                        <tr>
                           <td style="font-weight:bold" colspan="4" align="center">Taluk</td>
                        </tr>  
                        @foreach($taluk as $key => $list)
                        <tr>
                           <td>{{ $types[$list->renewal_by] }}</td>
                           <td><input type="hidden" name="id[]" value="{{ $list->id }}" /><input name="reg_amount[]" class="number" type="text" maxlength="6" value="{{ $list->reg_amount }}" /></td>
                           <td><input class="number" name="renew_amount[]" type="text" maxlength="6" value="{{ $list->renew_amount }}" /></td>
                        </tr>
                        @endforeach
                        <tr>
                           <td style="font-weight:bold" colspan="4" align="center">Block</td>
                        </tr>  
                        @foreach($block as $key => $list)
                        <tr>
                           <td>{{ $types[$list->renewal_by] }}</td>
                           <td><input type="hidden" name="id[]" value="{{ $list->id }}" /><input name="reg_amount[]" class="number" type="text" maxlength="6" value="{{ $list->reg_amount }}" /></td>
                           <td><input class="number" name="renew_amount[]" type="text" maxlength="6" value="{{ $list->renew_amount }}" /></td>
                        </tr>
                        @endforeach
                        <tr>
                           <td style="font-weight:bold" colspan="4" align="center">Sub Block</td>
                        </tr>  
                        @foreach($panchayath as $key => $list)
                        <tr>
                           <td>{{ $types[$list->renewal_by] }}</td>
                           <td><input type="hidden" name="id[]" value="{{ $list->id }}" /><input name="reg_amount[]" class="number" type="text" maxlength="6" value="{{ $list->reg_amount }}" /></td>
                           <td><input class="number" name="renew_amount[]" type="text" maxlength="6" value="{{ $list->renew_amount }}" /></td>
                        </tr>
                        @endforeach
                        <tr>
                           <td style="font-weight:bold" colspan="4" align="center">Center</td>
                        </tr>  
                        @foreach($center as $key => $list)
                        <tr>
                           <td>{{ $types[$list->renewal_by] }}</td>
                           <td><input type="hidden" name="id[]" value="{{ $list->id }}" /><input name="reg_amount[]" class="number" type="text" maxlength="6" value="{{ $list->reg_amount }}" /></td>
                           <td><input class="number" name="renew_amount[]" type="text" maxlength="6" value="{{ $list->renew_amount }}" /></td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="row">
                     <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="Submit" >
                     </div>
                  </div>
                  </form>
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
 function edit_usertype(usertype_id, group_name, user_discount, other_discount,user_payment,renew_payment) {
   $("#usertype_id").val(usertype_id);
   $("#group_name").val(group_name);
   $("#user_discount").val(user_discount);
   $("#other_discount").val(other_discount);
   $("#user_payment").val(user_payment);
   $("#renew_payment").val(renew_payment);
   $("#editusertype").modal("show");
}
$('#user_discount_amt').on('input',function() {
    var amt = parseInt($('#user_discount_amt').val());
    var percentage = 100 - parseFloat(amt*100/120);
    $('#user_discount').val(percentage);
});
$('#other_discount_amt').on('input',function() {
    var amt = parseInt($('#other_discount_amt').val());
    var percentage = 100 - parseFloat(amt*100/120);
    $('#other_discount').val(percentage);
});
</script>
@endpush
