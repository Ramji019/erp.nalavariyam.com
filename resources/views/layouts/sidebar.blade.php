<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('/upload/logo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- need to remove -->
                @if (Auth::user()->pas == '12345678')
                    <li class="nav-item">
                        <a href="{{ route('changepassword') }}"
                            class="nav-link {{ request()->is('changepassword') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Change Password</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item has-treeview {{ request()->segment(1) == 'dashboard' ? 'menu-open' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
					
					 @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 4 || Auth::user()->user_type_id == 5)
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'signature' ? 'menu-open' : '' }}">
                            <a href="{{ route('signature') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Signature</p>
                            </a>
                        </li>
					@endif
                    @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'districts' ? 'menu-open' : '' }}">
                            <a href="{{ route('districts') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Districts</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'services' ? 'menu-open' : '' }}">
                            <a href="{{ route('services') }}" class="nav-link">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>Services</p>
                            </a>
                        </li>
                    @endif
                     @if(Auth::user()->user_type_id !== 2 || Auth::user()->user_type_id !== 3)
                    <li class="nav-item has-treeview {{ request()->segment(1) == 'performers' ? 'menu-open' : '' }}">
                        <a href="{{ url('performers') }}/{{ date('Y-m-d') }}/{{ date('Y-m-d') }}" class="nav-link">
                            <i class="nav-icon fas fa fa-flag"></i>
                            <p>Performers</p>
                        </a>
                    </li>
                    @endif 
                    <li id="Customer"
                        class="nav-item has-treeview {{ request()->segment(1) == 'customers' || request()->is('members') || request()->is('specialmembers') ? 'menu-open' : '' }}">
                        <a id="Customers" href="" class="nav-link">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Customers
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::user()->user_type_id == 1)
                                <li class="nav-item">
                                    <a id="ViewCustomers" href="{{ route('allcustomers') }}"
                                        class="nav-link {{ request()->is('customers') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Customers</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a id="ViewCustomers" href="{{ route('customers') }}"
                                    class="nav-link {{ request()->is('customers') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Customers</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('members') }}"
                                    class="nav-link {{ request()->is('members') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Members</p>
                                </a>
                                </ li>
                            <li class="nav-item">
                                <a href="{{ route('specialmembers') }}"
                                    class="nav-link {{ request()->is('specialmembers') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Special Members</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::user()->user_type_id == 12 || Auth::user()->user_type_id == 13)
                    @else
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'primaryusers' || request()->is('specialusers') || request()->is('districtusers') || request()->is('talukusers') || request()->is('blockusers') || request()->is('panchayathusers') || request()->is('centerusers') || request()->is('avilableposting') ? 'menu-open' : '' }}">

                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('primaryusers') }}"
                                            class="nav-link {{ request()->is('primaryusers') ? 'active' : '' }}">
                                    @endif
                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Primary Users</p>
                                    @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('allusers') }}"
                                            class="nav-link {{ request()->is('allusers') ? 'active' : '' }}">
                                    @endif
                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Users</p>
                                    @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('specialusers') }}"
                                            class="nav-link {{ request()->is('specialusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2)
                                            <a href="{{ route('specialusers') }}"
                                                class="nav-link {{ request()->is('specialusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3)
                                                <a href="{{ route('specialusers') }}"
                                                    class="nav-link {{ request()->is('specialusers') ? 'active' : '' }}">
                                    @endif
                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Special Users</p>
                                    @elseif(Auth::user()->user_type_id == 2)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Special Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Special Secretarys</p>
                                    @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('districtusers') }}"
                                            class="nav-link {{ request()->is('districtusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2)
                                            <a href="{{ route('districtusers') }}"
                                                class="nav-link {{ request()->is('districtusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3)
                                                <a href="{{ route('districtusers') }}"
                                                    class="nav-link {{ request()->is('districtusers') ? 'active' : '' }}">
                                    @endif
                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>District Users</p>
                                    @elseif(Auth::user()->user_type_id == 2)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>District Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>District Secretarys</p>
                                    @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('talukusers') }}"
                                            class="nav-link {{ request()->is('talukusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4)
                                            <a href="{{ route('talukusers') }}"
                                                class="nav-link {{ request()->is('talukusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5)
                                                <a href="{{ route('talukusers') }}"
                                                    class="nav-link {{ request()->is('talukusers') ? 'active' : '' }}">
                                    @endif

                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Taluk Users</p>
                                    @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Taluk Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Taluk Secretarys</p>
                                    @endif

                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('blockusers') }}"
                                            class="nav-link {{ request()->is('blockusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4)
                                            <a href="{{ route('blockusers') }}"
                                                class="nav-link {{ request()->is('blockusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5)
                                                <a href="{{ route('blockusers') }}"
                                                    class="nav-link {{ request()->is('blockusers') ? 'active' : '' }}">
                                    @endif

                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Block Users</p>
                                    @elseif(Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 4)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Block Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3 || Auth::user()->user_type_id == 5)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Block Secretarys</p>
                                    @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('panchayathusers') }}"
                                            class="nav-link {{ request()->is('panchayathusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 4 ||
                                                Auth::user()->user_type_id == 6 ||
                                                Auth::user()->user_type_id == 10)
                                            <a href="{{ route('panchayathusers') }}"
                                                class="nav-link {{ request()->is('panchayathusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3 ||
                                                    Auth::user()->user_type_id == 5 ||
                                                    Auth::user()->user_type_id == 7 ||
                                                    Auth::user()->user_type_id == 11)
                                                <a href="{{ route('panchayathusers') }}"
                                                    class="nav-link {{ request()->is('panchayathusers') ? 'active' : '' }}">
                                    @endif

                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Sub Block Users</p>
                                    @elseif(Auth::user()->user_type_id == 2 ||
                                            Auth::user()->user_type_id == 4 ||
                                            Auth::user()->user_type_id == 6 ||
                                            Auth::user()->user_type_id == 10)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Panchayath Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3 ||
                                            Auth::user()->user_type_id == 5 ||
                                            Auth::user()->user_type_id == 7 ||
                                            Auth::user()->user_type_id == 11)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Sub Block Secretarys</p>
                                    @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('centerusers') }}"
                                            class="nav-link {{ request()->is('centerusers') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2 ||
                                                Auth::user()->user_type_id == 4 ||
                                                Auth::user()->user_type_id == 6 ||
                                                Auth::user()->user_type_id == 8 ||
                                                Auth::user()->user_type_id == 10)
                                            <a href="{{ route('centerusers') }}"
                                                class="nav-link {{ request()->is('centerusers') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3 ||
                                                    Auth::user()->user_type_id == 5 ||
                                                    Auth::user()->user_type_id == 7 ||
                                                    Auth::user()->user_type_id == 9 ||
                                                    Auth::user()->user_type_id == 11)
                                                <a href="{{ route('centerusers') }}"
                                                    class="nav-link {{ request()->is('centerusers') ? 'active' : '' }}">
                                    @endif

                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Center Users</p>
                                    @elseif(Auth::user()->user_type_id == 2 ||
                                            Auth::user()->user_type_id == 4 ||
                                            Auth::user()->user_type_id == 6 ||
                                            Auth::user()->user_type_id == 8 ||
                                            Auth::user()->user_type_id == 10)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Center Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3 ||
                                            Auth::user()->user_type_id == 5 ||
                                            Auth::user()->user_type_id == 7 ||
                                            Auth::user()->user_type_id == 9 ||
                                            Auth::user()->user_type_id == 11)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Center Secretarys</p>
                                    @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if (Auth::user()->user_type_id == 1)
                                        <a href="{{ route('avilableposting') }}"
                                            class="nav-link {{ request()->is('avilableposting') ? 'active' : '' }}">
                                        @elseif(Auth::user()->user_type_id == 2)
                                            <a href="{{ route('avilableposting') }}"
                                                class="nav-link {{ request()->is('avilableposting') ? 'active' : '' }}">
                                            @elseif(Auth::user()->user_type_id == 3)
                                                <a href="{{ route('avilableposting') }}"
                                                    class="nav-link {{ request()->is('avilableposting') ? 'active' : '' }}">
                                    @endif

                                    @if (Auth::user()->user_type_id == 1)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Posting Users</p>
                                    @elseif(Auth::user()->user_type_id == 2)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Posting Presidents</p>
                                    @elseif(Auth::user()->user_type_id == 3)
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Posting Secretarys</p>
                                    @endif
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    
                    <li
                        class="nav-item has-treeview {{  request()->is('bulkorders') || request()->is('billing') ? 'menu-open' : '' }}">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Orders & Billing
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::user()->user_type_id == 1 ||
                                    Auth::user()->user_type_id == 2 ||
                                    Auth::user()->user_type_id == 3 ||
                                    Auth::user()->user_type_id == 4 ||
                                    Auth::user()->user_type_id == 5)
                                <li class="nav-item">
                                    <a href="{{ route('bulkorders') }}"
                                        class="nav-link {{ request()->is('bulkorders') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bulk Orders</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('pendingbulkservice') }}"
                                    class="nav-link {{ request()->is('pendingbulkservice') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending Bulk Order</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('deliveredbulkservice') }}"
                                    class="nav-link {{ request()->is('deliveredbulkservice') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Delivered Bulk Order</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li id="onlinestatus" class="nav-item has-treeview ">
                   <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-heart"></i>
                      <p>
                        Online Status
                         <i class="fas fa-angle-left right"></i>
                      </p>
                   </a>
                   <ul class="nav nav-treeview">
                      @foreach ($onlinestatus_menu as $onlinestatus)
                      <li class="nav-item">
                         <a href="{{ url('/onlinestatus') }}/{{ $onlinestatus->online_status_id }}/{{ date('Y-m-d', strtotime('-3 days')) }}/{{ date('Y-m-d') }}" class="nav-link {{ ((request()->segment(2) == $onlinestatus->online_status_id )) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ $onlinestatus->online_status_id }}</p>
                         </a>
                      </li>
                      @endforeach
                   </ul>
                </li>
                    <li id="Output"
                        class="nav-item has-treeview {{ request()->segment(1) == 'pending' || request()->is('rejected') || request()->is('completed') ? 'menu-open' : '' }}">
                        <a id="OutputApplication" href="" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Output Application
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pending') }}"
                                        class="nav-link {{ request()->is('pending') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('rejected') }}"
                                        class="nav-link {{ request()->is('rejected') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Resubmit</p>
                                    </a>
                                </li>
                                <li class="nav-item">
				          	@if((Auth::user()->user_type_id == 1 ) ||(Auth::user()->user_type_id == 2 ) || (Auth::user()->user_type_id == 3 ))
                                    <a id="Completed" href="{{ url('onlinestatus') }}/Completed/{{ date('Y-m-d', strtotime('-3 days')) }}/{{ date('Y-m-d') }}" class="nav-link {{ request()->is('completed') ? 'active' : '' }}"> <i class="far fa-circle nav-icon"></i>
                                        <p>Completed</p>
                                    </a>
							 @else
									<a id="Completed" href="{{ url('onlinestatus') }}/Completed/{{ date('Y-m-d', strtotime('-700 days')) }}/{{ date('Y-m-d') }}" class="nav-link {{ request()->is('completed') ? 'active' : '' }}"> <i class="far fa-circle nav-icon"></i>
                                        <p>Completed</p>
                                    </a>
								 @endif	
                                </li>
                        </ul>
                    </li>
                    <li id="Output"
                        class="nav-item has-treeview {{ request()->segment(1) == 'wallet' || request()->is('viewrequestamount') || request()->is('completed') || request()->is('walletamount') ? 'menu-open' : '' }}">
                        <a id="OutputApplication" href="" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Wallet & Payment
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('wallet') }}/{{ date('Y-m-d', strtotime('-1 days')) }}/{{ date('Y-m-d') }}"
                                    class="nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Wallet</p>
                                </a>
                            </li>
                            @if(Auth::user()->user_type_id == 1)
                             <li class="nav-item">
                                <a href="{{ url('walletamount') }}"
                                    class="nav-link {{ request()->is('walletamount') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Wallet Amount</p>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('viewrequestamount') }}"
                                    class="nav-link {{ request()->is('viewrequestamount') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Request Amount</p>
                                </a>
                            </li>
                            @if(Auth::user()->id == 1)
							  <li class="nav-item">
								<a class="nav-link {{ (request()->is('withdrawal')) ? 'active' : '' }}" href="{{ route('withdrawal') }}">
								  <i class="far fa-circle nav-icon"></i>
								  <p> Withdrawal</p>
								</a>
							  </li>
                              @endif
                        </ul>
                    </li>
                    @if (Auth::user()->user_type_id == 1)
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'usertypes' || request()->segment(1) == 'renewal' || request()->is('notification') || request()->is('backup') || request()->is('advertisement') ? 'menu-open' : '' }}">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Setting
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('backup') }}"
                                        class="nav-link {{ request()->is('backup') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Backup</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('usertypes') }}"
                                        class="nav-link {{ request()->is('usertypes') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User Types</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('renewal') }}"
                                        class="nav-link {{ request()->is('renewal') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Activation Amount</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('notification') }}"
                                        class="nav-link {{ request()->is('notification') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Notification</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('advertisement') }}"
                                        class="nav-link {{ request()->is('advertisement') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Advertisement</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    @endif
                    <li class="nav-item has-treeview {{ request()->segment(1) == 'meetings' ? 'menu-open' : '' }}">
                        <a href="{{ route('meetings') }}" class="nav-link">
                            <i class="nav-icon fas fa-flag"></i>
                            <p>Meetings</p>
                        </a>
                    </li>

                    <li
                        class="nav-item has-treeview {{ request()->segment(1) == 'profile' || request()->is('changepassword') ? 'menu-open' : '' }}">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{ Auth::user()->full_name }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile') }}"
                                    class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Edit Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('changepassword') }}"
                                    class="nav-link {{ request()->is('changepassword') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Change Password</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logout</p>
                                </a>
                            </li>

                @endif

            </ul>
            </li>
            </ul>
        </nav>
    </div>
</aside>
