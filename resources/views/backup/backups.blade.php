@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Backup Database</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 2) || (Auth::user()->user_type_id == 4) || (Auth::user()->user_type_id == 1) )
            <ol class="breadcrumb float-sm-right">
               <form action="{{ url('backup/create') }}" method="GET" enctype="multipart/form-data" id="CreateBackupForm">
                  {{ csrf_field() }}
                  <input type="submit" name="submit" class="btn btn-secondary btn-sm float-right"  value="Create Database Backup">
               </form>
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
                  @if(session()->has('success'))
                  <div class="alert alert-success alert-dismissable">
                     <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong> {{ session('success') }} </strong>
                  </div>
                  @endif
                  @if ( Session::has('update') )
                  <div class="alert alert-success alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>
                  @endif
                  @if ( Session::has('delete') )
                  <div class="alert alert-danger alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                     {{ Session::get('delete') }}
                  </div>
                  @endif
                  @if (count($backups))
                  <table id="example2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>File Name</th>
                           <th>File Size</th>
                           <th>Created Date</th>
                           <th>Created Age</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($backups as $backup)
                        <tr>
                           <td>{{ $backup['file_name'] }}</td>
                           <td>{{ \App\Http\Controllers\BackupController::humanFilesize($backup['file_size']) }}</td>
                           <td>
                              {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                           </td>
                           <td>
                              {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                           </td>
                           <td>
                              <a class="btn btn-success"
                                 href="{{ url('backup/download/'.substr($backup['file_name'],11)) }}"><i
                                 class="fa fa-cloud-download"></i> Download</a>
                              <a class="btn btn-danger" onclick="return confirm('Do you really want to delete this file')" data-button-type="delete"
                                 href="{{ url('/backup/delete/'. substr($backup['file_name'],11)) }}"><i class="fa fa-trash-o"></i>
                              Delete</a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  @else
                  <div class="well">
                     <h4 class="text-center">No backups</h4>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection