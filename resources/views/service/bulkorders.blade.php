@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bulk Orders</h1>
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
                                    <th>S No</th>
                                    <th>District</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bulkorders as $key => $bulkorderslist)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $bulkorderslist->district_name }}</td>
                                    <td>{{ $bulkorderslist->full_name }}</td>
                                    <td>{{ $bulkorderslist->email }}</td>
                                    <td>{{ $bulkorderslist->phone }}</td>
                                    <td><a href="{{ url('viewbulkorders') }}/{{ $bulkorderslist->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
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
</div>
</section>
@endsection

@push('page_scripts')
<script>
    
</script>
@endpush
