<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('memberdashboard') }}" class="brand-link">
        <img src="{{ asset('/upload/logo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- need to remove -->

                <li class="nav-item has-treeview {{ request()->segment(1) == 'memberdashboard' ? 'menu-open' : '' }}">
                    <a href="{{ route('memberdashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->segment(1) == 'services' ? 'menu-open' : '' }}">
                    <a href="{{ route('memberservices') }}" class="nav-link">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>Services</p>
                    </a>
                </li>
                <li id="Output"
                    class="nav-item has-treeview {{ request()->segment(1) == 'memberpending' || request()->is('memberrejected') || request()->is('memberstatuscompleted') ? 'menu-open' : '' }}">
                    <a id="OutputApplication" href="" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Output Application
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('memberpending') }}"
                                class="nav-link {{ request()->is('memberpending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('memberrejected') }}"
                                class="nav-link {{ request()->is('memberrejected') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Resubmit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="Completed"
                                href="{{ url('memberstatuscompleted') }}/{{ date('Y-m-d', strtotime('-3 days')) }}/{{ date('Y-m-d') }}"
                                class="nav-link {{ request()->is('memberstatuscompleted') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Completed</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li id="Output"
                    class="nav-item has-treeview {{ request()->segment(1) == 'wallet' || request()->is('viewrequestamount') || request()->is('memberstatuscompleted') ? 'menu-open' : '' }}">
                    <a id="OutputApplication" href="" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Wallet & Payment
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/memberwallet') }}/{{ date('Y-m-d', strtotime('-1 days')) }}/{{ date('Y-m-d') }}"
                                class="nav-link {{ request()->is('memberwallet') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>MemberWallet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('memberrequestamount') }}"
                                class="nav-link {{ request()->is('memberrequestamount') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Request Amount</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li
                    class="nav-item has-treeview {{ request()->segment(1) == 'profile' || request()->is('changepassword') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{ Session::get('name') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('memberprofile') }}"
                                class="nav-link {{ request()->is('memberprofile') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('memberchangepassword') }}"
                                class="nav-link {{ request()->is('memberchangepassword') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('memberlogout') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
