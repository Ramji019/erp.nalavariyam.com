<!-- Main Header -->


<nav
    class="main-header navbar navbar-expand
@if (Session::get('colour') == 1) navbar-light navbar-white 
@elseif(Session::get('colour') == 2)
navbar-dark navbar-black @endif
">



    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://nalavariyam.com/" class="nav-link">Home</a>
        </li>
        {{-- @foreach ($referencedata as $key => $referencedatas)
        <li class="nav-item d-none d-sm-inline-block">
            <a href="tel:{{ $referencedatas->phone }}" class="nav-link">+91 {{ $referencedatas->phone }} { 24/7 }</a>
        </li>
		 @endforeach --}}

    </ul>

    <ul class="navbar-nav ml-auto">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#eye"><i
                class="fa fa-eye"></i></button>
    </ul>
    <ul class="navbar-nav ml-auto">
        <style>
            #blink {
                font-size: 20px;
                font-weight: bold;
                font-family: sans-serif;
            }
        </style>
        <button id="blink" type="button" class="btn btn-default" data-toggle="modal" data-target="#eye"><i
                class="fa fa-eye"></i></button>

    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href=""
                onclick="window.open('{{ url('/chatusers') }}','MY Window','height=600,width=500,top=200,centeralign=200,left=900')">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">msg</span>
            </a>
        </li>
        @if (Session::get('user_type') == 18 ||
                Session::get('user_type') == 19 ||
                Session::get('user_type') == 20 ||
                Session::get('user_type') == 21)
            @php
                $dist_id = '';
                if (Session::get('user_type') == 18 || Session::get('user_type') == 19) {
                    $dist_id = '18';
                } elseif (Session::get('user_type') == 20 || Session::get('user_type') == 21) {
                    $dist_id = '19';
                }
                $dist_id = Session::get('dist_id');
                if (Session::get('user_type') == 18 || Session::get('user_type') == 20) {
                    $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and customer_user_type_id= '$dist_id'";
                } elseif (Session::get('user_type') == 19 || Session::get('user_type') == 21) {
                    $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and dist_id='$dist_id' and customer_user_type_id= '$dist_id'";
                }
                $pending = DB::select(DB::raw($sql));
                $wordcount = count($pending);
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="" href="{{ route('memberpending') }}">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ $wordcount }}</span>
                </a>
            </li>
        @endif

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fas fa-user"></i>
                <span class="d-none d-md-inline"> {{ Session::get('name') }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ URL::to('/') }}/upload/member_photo/{{ Session::get('member_photo') }}"
                        class="img-circle elevation-2" alt="{{ Session::get('name') }}">
                    <p>
                        {{ Session::get('name') }}
                        @if (Session::get('user_type') == 18)
                            <h5>-- Member -- {{ Session::get('customer_id') }}</h5>
                        @elseif(Session::get('user_type') == 19)
                            <h5>-- Members -- {{ Session::get('customer_id') }}</h5>
                        @elseif(Session::get('user_type') == 20)
                            <h5>-- SpecialMember -- {{ Session::get('customer_id') }}</h5>
                        @elseif(Session::get('user_type') == 21)
                            <h5>-- SpecialMembers -- {{ Session::get('customer_id') }}</h5>
                        @endif
                    </p>
                </li>
                <!-- Menu Footer-->

                <li class="user-footer">

                    <a href="{{ route('memberprofile') }}"
                        class="btn btn-default">Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if (Session::get('colour') == 1)
                        <a onclick="bgfavorites(this,2)" class="btn btn-danger"><i class="fa fa-moon"></i></a>
                    @else
                        <a onclick="bgfavorites(this,1)" class="btn btn-success"><i class="fas fa-moon"></i></a>
                    @endif

                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-default float-right text-muted text-sm">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </li>
    </ul>
</nav>

<style>
    marquee {
        font-size: 30px;
        font-weight: 800;
        color: #8ebf42;
        font-family: sans-serif;
    }
</style>
@php
    $user_type = '';
    if (Session::get('user_type') == 18 || Session::get('user_type') == 19) {
        $user_type = 'B';
    } elseif (Session::get('user_type') == 20 || Session::get('user_type') == 21) {
        $user_type = 'C';
    }
    
    $today = date('Y-m-d');
    if (Session::get('user_type') == 18 || Session::get('user_type') == 19 || Session::get('user_type') == 20 || Session::get('user_type') == 21) {
        $sql = "Select * from notification where from_date>='$today' and to_date<='$today'  order by id";
    } else {
        $sql = "Select * from notification where user_type = '$user_type'  and from_date <='$today' and to_date >='$today' order by id";
    }
    
    $test = DB::select(DB::raw($sql));
@endphp
@foreach ($test as $row)
    <br>
    <br>
    @if (Session::get('user_type') == 18 ||
            Session::get('user_type') == 19 ||
            Session::get('user_type') == 20 ||
            Session::get('user_type') == 21)
    @else
        <marquee>
            <a href="" data-toggle="modal" data-target="#adds{{ $row->id }}"
                class="small-box-footer">{{ $row->notification_name }} <i class="fas fa-eye"></i></a>
        </marquee>
    @endif
    @if (Session::get('user_type') == 18 ||
            Session::get('user_type') == 19 ||
            Session::get('user_type') == 20 ||
            Session::get('user_type') == 21)
    @else
        <div class="modal fade" id="adds{{ $row->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Notification</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <center>
                            {{ $row->notification_name }}</br>
                            {{ $row->notification_details }}</br>
                            <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/notification_img/{{ $row->notification_img }}"
                                </center>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach


<div class="modal fade" id="eye">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">தொழிற்சங்க விபரம்</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- @foreach ($unionusers as $union)
                <div class="modal-body">
                    <center>
                        தமிழ்நாடு ராம்ஜி கட்டுமானம் மற்றும் அமைப்புசார்ந்த அமைப்புசாரா பொது தொழிலாளர்கள் நலசங்கம்</br>
                        பதிவு எண் : 713/KKM</br>
                        இபடிவம் தேதி : {{ $union->e_form_date }}<br>
                        {{ $union->signature_owner }}<br>
                        {{ $union->signature_phone }}
                    </center>
                </div>
            @endforeach --}}
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Active</button>
                </form>
            </div>
        </div>
    </div>
</div>
