@extends('layouts.app')
@section('content')
<section class="content-header">
 <div class="container-fluid">
  <div class="row mb-2">
   <div class="col-sm-6">
    <h1>User Types</h1>
  </div>
  <div class="col-sm-6">
    @if((Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 4) || (Auth::user()->user_type_id == 1) )
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#usertypes"><i class="fa fa-plus"> Add </i></button></li>
   </ol>
   @else
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
                           <th> UserType Name</th>
                           <th> User Discount</th>
                           <th> Other Discount</th>
                           <th> Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($usertypes as $key=>$list)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $list->group_name }}</td>
                           <td>{{ $list->user_discount }}</td>
                           <td>{{ $list->other_discount }}</td>
                           <td>
						   
                              <a onclick="edit_usertype('{{ $list->id }}','{{ $list->group_name }}','{{ $list->user_discount }}','{{ $list->other_discount }}','{{ $list->user_payment }}','{{ $list->renew_payment }}')" class="btn btn-info btn-sm"><i class="fa fa-edit"> Edit </i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
                  <div class="modal fade" id="editusertype">
                     <div class="modal-dialog modal-md">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title"> Edit User Type</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <form action="{{url('/editusertype')}}" method="post">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" id="usertype_id" value="" />
                              <div class="modal-body">
                                 <div class="form-group">
                                  <label for="group_name">User Type Name</label>
                                  <input maxlength="50" type="text" value="" class="form-control"  name="group_name" id="group_name" placeholder="" >
                               </div>
      <div class="row">
         <div class="col-6">
                               <div class="form-group">
                                  <label for="group_name">Commision Amount for 120 </label>
                                  <input maxlength="3" type="text" class="form-control number"  name="user_discount_amt" id="user_discount_amt" placeholder="" >
                               </div> 
                               </div> 
							   <div class="col-6">
                               <div class="form-group">
                                  <label for="group_name">Percentage</label>
                                  <input readonly type="text" value="" class="form-control"  name="user_discount" id="user_discount" placeholder="" >
                               </div> 
                               </div> 

                              
                               </div> 
      <div class="row">
         <div class="col-6">
                               <div class="form-group">
                                  <label for="group_name">Other Commision for 120</label>
                                  <input maxlength="3" type="text" class="form-control number"  name="other_discount_amt" id="other_discount_amt" placeholder="" >
                               </div> 
                               </div> 
							            <div class="col-6">

                               <div class="form-group">
                                  <label for="group_name">Other Percentage</label>
                                  <input readonly type="text" value="" class="form-control"  name="other_discount" id="other_discount" placeholder="" >
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
