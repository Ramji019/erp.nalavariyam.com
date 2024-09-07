<div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
      aria-label="Close"></button>
    <div class="offcanvas-body p-0">
      <div class="sidenav-wrapper">
      @if(Auth::user())
        <div class="sidenav-profile bg-gradient">
          <div class="sidenav-style1"></div>
          <div class="user-profile">
            <img src="{{ URL::to('/') }}/uploads/photo/{{ Auth::user()->photo }}" alt="">
          </div>
          <div class="user-info">
            <h6 class="user-name mb-0">{{ Auth::user()->name }}</h6>
          </div>
        </div>
		@endif
        <!-- Sidenav Nav -->
        <ul class="sidenav-nav ps-0">
          <li>
            <a href="{{ url('/user/dashboard') }}"><i class="bi bi-border-top"></i> Dashboard</a>
          </li>
          <li>
            <a href="{{ url('/user/profile') }}"><i class="bi bi-person-square"></i> My Profile</a>
          </li>
          <li>
            <a href="{{ url('/purchase') }}"><i class="bi bi-box-seam-fill"></i>Purchase Plan</a>
          </li>
          <li>
            <a href="{{ url('/user/my_products') }}"><i class="bi bi-layers"></i>My ADS</a>
          </li>
          
          <li>
            <a href="{{ url('/user/add_product') }}"><i class="bi bi-plus"></i>Sell Products</a>
          </li> 
		  <li>
            <a href="{{ url('/user/wish') }}"><i class="bi bi-heart"></i>Wish List</a>
          </li>
          <li>
            <a href="{{ url('/user/sold_products') }}"><i class="bi bi-layers"></i>Sold Products</a>
          </li>
          <li>
            <a href="{{ url('/user/change_password') }}"> <i class="bi bi-key"></i> Change Password</a>
          </li>
		  <li>
            <div class="night-mode-nav">
              <i class="bi bi-moon"></i> Night Mode
              <div class="form-check form-switch">
                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
              </div>
            </div>
          </li>
          <li>
            <a href="{{ url('/sellerlogout') }}"><i class="bi bi-box-arrow-right"></i>Log Out</a>
          </li>
		</ul>
	  </li>
	</ul>
  </div>
 </div>
</div>
