<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="{{ route('memberdashboard') }}" class="brand-link">
   <img src="{{ asset('/upload/logo.png') }}" class="brand-image img-circle elevation-3">
   <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
   </a>
   <div class="sidebar">
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- need to remove -->
		<li class="nav-item">
			<a href="{{ route('memberdashboard') }}" class="nav-link {{ (request()->is('memberdashboard')) ? 'active' : '' }}">
			   <i class="far fa-circle nav-icon"></i>
			   <p>Dashboard</p>
			</a>
		 </li>
          
				</ul>
      </nav>
   </div>
</aside>
