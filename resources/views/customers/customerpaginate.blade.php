@foreach ($viewcustomers as $key => $viewcustomerslist)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>C{{ $viewcustomerslist->userID }}</td>
        <td>{{ $viewcustomerslist->district_name }}</td>
        <td>{{ $viewcustomerslist->full_name_tamil }}</td>
        <td>{{ $viewcustomerslist->phone }}</td>
        <td>{{ $viewcustomerslist->status }}</td>
        <td>
            <a class="btn btn-primary btn-sm fa fa-edit"
                href="{{ url('/editcustomers', $viewcustomerslist->userID) }}">Edit</a>
            @if (Auth::user()->user_type_id > 1 && Auth::user()->user_type_id < 12)
                <a class="btn btn-sm btn-primary" href="{{ url('goto', $viewcustomerslist->userID) }}"><i
                        class="fas fa-arrow-circle-right"></i>Go To</a>
            @endif
            @if (Auth::user()->user_type_id != 1 && Auth::user()->user_type_id != 2 && Auth::user()->user_type_id != 3)
                <a class="btn btn-sm btn-primary" onclick="show_purchase_modal()"
                    href="{{ url('viewservices', $viewcustomerslist->userID) }}"><i
                        class="fas fa-arrow-circle-right"></i>Services</a>
                <a class="btn btn-sm btn-primary"
                    onclick="documents('{{ $viewcustomerslist->id }}','{{ $viewcustomerslist->userID }}','{{ $viewcustomerslist->aadhaarfile }}','{{ $viewcustomerslist->nalavariyam_card }}','{{ $viewcustomerslist->rationfile }}','{{ $viewcustomerslist->member_signature }}','{{ json_encode($viewcustomerslist->documents, true) }}')"><i
                        class="fas fa-arrow-circle-right"></i>Documents</a>
            @endif
        </td>
    </tr>
@endforeach
<tr>
    <td colspan="7" class="mt-2">
        {!! $viewcustomers->links('pagination::bootstrap-4') !!}
    </td>
</tr>
