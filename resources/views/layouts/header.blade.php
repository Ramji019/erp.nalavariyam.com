<!-- Main Header -->



<nav class="main-header navbar navbar-expand
@if (Auth::user()->colour == 1)
navbar-light navbar-white
@elseif(Auth::user()->colour == 2)
navbar-dark navbar-black
@endif
">



<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="https://nalavariyam.com/" class="nav-link">Home</a>
    </li>
    @foreach ($referencedata as $key => $referencedatas)
    <li class="nav-item d-none d-sm-inline-block">
        <a href="tel:{{ $referencedatas->phone }}" class="nav-link">+91 {{ $referencedatas->phone }} { 24/7 }</a>
    </li>
    @endforeach

</ul>

<ul class="navbar-nav ml-auto">
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#eye"><i class="fa fa-eye"></i></button>
</ul>
<ul class="navbar-nav ml-auto">


    @php
    $user_type="";
    if (Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3) {
        $user_type = 'B';
    } elseif (Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 5) {
        $user_type = 'C';
    } elseif (Auth::user()->user_type_id == 6 || Auth::user()->user_type_id == 7) {
        $user_type = 'D';
    } elseif (Auth::user()->user_type_id == 8 || Auth::user()->user_type_id == 9) {
        $user_type = 'E';
    } elseif (Auth::user()->user_type_id == 10 || Auth::user()->user_type_id == 11) {
        $user_type = 'F';
    } elseif (Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13) {
        $user_type = 'G';
    } elseif (Auth::user()->user_type_id == 16 || Auth::user()->user_type_id == 17) {
        $user_type = 'I';
    } elseif (Auth::user()->user_type_id == 18 || Auth::user()->user_type_id == 19) {
        $user_type = 'K';
    } elseif (Auth::user()->user_type_id == 20 || Auth::user()->user_type_id == 21) {
        $user_type = 'L';
    }

    $today = date('Y-m-d');
    if (Auth::user()->user_type_id == 1) {
        $sql = "Select * from notification where from_date>='$today' and to_date<='$today'  order by id";
    } else {
        $sql = "Select * from notification where user_type = '$user_type'  and from_date <='$today' and to_date >='$today' order by id";
        }

        $test = DB::select(DB::raw($sql));
        @endphp
        @foreach ($test as $row)

        @if (Auth::user()->user_type_id == 1)

        @else
        <style>
            #blink {
                font-size: 20px;
                font-weight: bold;
                font-family: sans-serif;
            }
        </style>
        <a id="blink" onclick="addopen('{{ $row->id }}','{{ $row->notification_name }}','{{ $row->notification_details }}','{{ $row->notification_img }}')" type="button" class="btn btn-default"><i class="fa fa-eye"></i></a>
        @endif
        @endforeach
        @if (Auth::user()->user_type_id >= 4 && Auth::user()->user_type_id <= 11)
        <a class="copy_text btn btn-sm btn-primary" data-toggle="tooltip" title="Copy to Clipboard" href="https://erp.nalavariyam.com/register/{{ Auth::user()->id }}">Share Link</a>
        @endif

    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="" onclick="window.open('{{ url('/chatusers') }}','MY Window','height=600,width=500,top=200,centeralign=200,left=900')">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{ $msgcount }}</span>
            </a>
        </li>
        @if (Auth::user()->user_type_id == 2 ||
        Auth::user()->user_type_id == 3 ||
        Auth::user()->user_type_id == 4 ||
        Auth::user()->user_type_id == 5 ||
        Auth::user()->user_type_id == 16 ||
        Auth::user()->user_type_id == 17)
        @php
        $group_id = "";
        if (Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 16) {
            $group_id = '14';
        } elseif (Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5 || Auth::user()->user_type_id == 17) {
            $group_id = '15';
        }
        $dist_id = Auth::user()->dist_id;
        if (Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 16 || Auth::user()->user_type_id == 17) {
            $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and customer_user_type_id= '$group_id'";
        } elseif (Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 5) {
            $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and dist_id='$dist_id' and customer_user_type_id= '$group_id'";
        }
        $pending = DB::select(DB::raw($sql));
        $wordcount = count($pending);
        @endphp
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="" href="{{ route('pending') }}">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ $wordcount }}</span>
            </a>
        </li>
        @endif

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
               <i class="fas fa-user"></i>
               <span class="d-none d-md-inline"> {{ Auth::user()->full_name }}</span>
           </a>
           <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
                <img src="{{ URL::to('/') }}/upload/user_photo/{{ Auth::user()->user_photo }}"
                class="img-circle elevation-2" alt="{{ Auth::user()->full_name }}">
                <p>
                    {{ Auth::user()->full_name }}
                    @if (Auth::user()->user_type_id == 1)
                    <h5>SuperAdmin -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 2)
                    <h5>Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 3)
                    <h5>Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 4)
                    <h5>District Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 5)
                    <h5>District Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 6)
                    <h5>Taluk Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 7)
                    <h5>Taluk Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 8)
                    <h5>Sub Block Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 9)
                    <h5>Sub Block Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 10)
                    <h5>Block Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 11)
                    <h5>Block Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 12)
                    <h5>Center Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 13)
                    <h5>Center Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 14)
                    <h5>Customers Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 15)
                    <h5>Customers Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 16)
                    <h5>Special Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 17)
                    <h5>Special Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 18)
                    <h5>Members Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 19)
                    <h5>Members Secretarys -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 20)
                    <h5>SpecialMember Presidents -- {{ Auth::user()->id }}</h5>
                    @elseif(Auth::user()->user_type_id == 21)
                    <h5>SpecialMember Secretarys -- {{ Auth::user()->id }}</h5>
                    @endif
                </p>
            </li>
            <!-- Menu Footer-->

            <li class="user-footer">

                <a href="{{ route('profile') }}" class="btn btn-default">Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @if(Auth::user()->colour == 1)
                <a onclick="bgfavorites(this,2)" class="btn btn-danger"><i class="fa fa-moon"></i></a>
                @else
                <a onclick="bgfavorites(this,1)" class="btn btn-success"><i class="fas fa-moon"></i></a>
                @endif

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="btn btn-default float-right text-muted text-sm">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form>
         </li>

     </ul>
 </li>
</ul>
</nav>
</br>


<div class="modal fade" id="eye">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">தொழிற்சங்க விபரம்</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                தமிழ்நாடு ராம்ஜி கட்டுமானம் மற்றும் அமைப்புசார்ந்த அமைப்புசாரா பொது தொழிலாளர்கள் நலசங்கம்</br>
            பதிவு எண் : 713/KKM</br>
            @foreach ($unionusers as $union)

            இபடிவம் தேதி : {{ $union->e_form_date }}<br>
            {{ $union->full_name }}<br>
            {{ $union->signature_phone }}
        </center>
		 @endforeach
    </div>
   
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Active</button>
    </form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="adds">
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
                   <p id="not_name"> </p></br>
                   <p id="not_details"> </p></br>
                   <img style="width:200px" src="" id="not_img"/>
               </center>
           </div>
           <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="email_confirmation" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6>Email Verification</h6>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email</label>
                    <input maxlength="50" required value="{{ Auth::user()->email }}" class="form-control" name="email" id="uemail" type="email" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Aadhaar No</label>
                    <input maxlength="12" required value="{{ Auth::user()->aadhaar_no }}" class="form-control number" name="aadhaar_no" id="uaadhaar_no" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Phone</label>
                    <input maxlength="10" required value="{{ Auth::user()->phone }}" class="form-control number" name="phone" id="uphone" />
                    <input type="hidden" id="otpsent" value="0">
                </div>
            </div>


        </div>

        <div class="row" id="otpdiv" style="display: none">
        <div class="col-lg-4 col-md-4"></div>
        <div class="col-lg-4 col-md-4 text-center">
            <label style="color:green" id="otpsent">An OTP is sent to your email</label>
            <div class="input-group mb-3 otp-input-group">
                <input type="hidden" name="otpgenerated" value="0"
                    id="otpgenerated" />
                <input id="otp1" required="required" size="1" maxlength="1"
                    name="otp1" class="inputs number form-control">
                <input id="otp2" required="required" size="1" maxlength="1"
                    name="otp2" class="inputs number form-control">
                <input id="otp3" required="required" size="1" maxlength="1"
                    name="otp3" class="inputs number form-control">
                <input id="otp4" required="required" size="1" maxlength="1"
                    name="otp4" class="inputs number form-control">
            </div>
        </div>
    </div>

    </div>
    <div class="modal-footer text-center">
        <span id="plswait"></span>
        <input style="display:none" onclick="resendotpemail()" value="Resend OTP" type="button" class="btn btn-danger" id="resendbutton" />
        <input onclick="sendotpemail()" value="Submit" type="button" class="btn btn-primary" />
    </div>
</div>
</div>
</div>

