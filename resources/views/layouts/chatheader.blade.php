<div class="header-area" id="headerArea">
    <div class="container">
        <!-- Header Content -->
        <div
            class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
            <!-- Logo Wrapper -->
            <div class="logo-wrapper">
                <a href="{{ url('/') }}">
                    <img src="{!! asset('logo.png') !!}" />
                </a>
            </div>
          
            <a id="current_locationtop" data-bs-toggle="offcanvas" data-bs-target="#map"
                aria-controls="offcanvasBottom">NalaVaryam Chat
            </a>
            <a  href="{{ url('/chatusers') }}" class="btn btn-primary btn-sm "><i class="bi bi-bootstrap-reboot"></i> Reload</a>
           
        </div>
    </div>
</div>


