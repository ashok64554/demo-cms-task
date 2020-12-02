<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
	<div class="app-sidebar__user">
		<div class="dropdown user-pro-body">
			<div>
				<img src="{{url('/')}}/{{Auth::user()->companyLogo}}" alt="{{Auth::user()->companyName}}" class="avatar avatar-xl brround mCS_img_loaded">
				<a href="{{ route('edit-profile') }}" class="profile-img">
				<span class="fa fa-pencil" aria-hidden="true"></span>
				</a>
			</div>
			<div class="user-info mb-2">
				<h4 class="font-weight-semibold text-dark mb-1">{{Auth::user()->name}}</h4>
				<span class="mb-0 text-muted">{{Auth::user()->companyName}}</span>
			</div>
			@can('app-setting')
			<a href="{{ route('app-setting') }}" title="" class="user-button" data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="setting"><i class="fa fa-cog"></i></a>
			@endif
			<a href="{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}" title="" class="user-button"  data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="Screen Lock"><i class="fa fa-lock"></i></a>
			<a href="{{url('logout')}}" title="" class="user-button"  data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="Sign Out" ><i class="fa fa-power-off"></i></a>
			
			
		</div>
	</div>
	<ul class="side-menu">
		
		<li>
			<a class="side-menu__item menu-c" href="{{ route('dashboard') }}"><i class="side-menu__icon fa fa-desktop"></i><span class="side-menu__label">Dashboard</span></a>
		</li>
		@can('users-list')
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon si si-people"></i><span class="side-menu__label">User Management</span><i class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				@can('users-list')
				<li>
					<a href="{{ route('users-list') }}" class="slide-item menu-c">Users</a>
				</li>
				@endcan
			</ul>
		</li>
		@endcan
		@can('manage-box')
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon si si-people"></i><span class="side-menu__label">Manage Boxes </span><i class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				@can('boxes')
				<li>
					<a href="{{ route('box') }}" class="slide-item menu-c">Boxes</a>
				</li>
				@endcan
				
			</ul>
		</li>
		@endcan
		@can('products')
		<li>
			<a class="side-menu__item" href="{{ route('products') }}"><i class="side-menu__icon fa fa-file"></i><span class="side-menu__label">Manange Product </span></a>
		</li>
		@endcan

		<li>
			<a class="side-menu__item" href="{{ route('payment-system') }}"><i class="side-menu__icon fa fa-money"></i><span class="side-menu__label">Payment System </span></a>
		</li>
		
		
	</ul>
</aside>