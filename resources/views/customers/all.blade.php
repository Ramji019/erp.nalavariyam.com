@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>View Customers</h1>
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
                  <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th> id</th>
                           <th> usertype</th>
                           <th> District</th>
                           <th> taluk</th>
                           <th> panchayath</th>
                           <th> Full Name</th>
						   
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($allcustomers as $key => $allcustomerslist)
                        <tr>
                           <td>{{ $allcustomerslist->id }}</td>
                           <td>{{ $allcustomerslist->user_type_id }}</td>
                           <td>{{ $allcustomerslist->district_name }}</td>
                           <td>{{ $allcustomerslist->taluk_name }}</td>
                           <td>{{ $allcustomerslist->panchayath_name }}</td>
                           <td>{{ $allcustomerslist->full_name_tamil }}</td>
                        
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