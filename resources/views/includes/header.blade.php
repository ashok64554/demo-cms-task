<div class="app-header header py-1 d-flex">
	<div class="container-fluid">
		<div class="d-flex">
			<a class="header-brand" href="{{route('dashboard')}}">
				<img src="{{url('/')}}/{{$appSetting->app_logo}}" class="front_header_logo" alt="">
			</a>
			<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
			<div class="d-none d-lg-block horizontal">
				<ul class="nav">

				</ul>
			</div>
           <!--  <div class="d-flex order-lg-2 ml-auto">
				<a href="javascript:;" data-toggle="modal" class="btn btn-primary btn-block" data-target="#getImage" id="getImageId" data-type="default"  class="d-flex nav-link pr-0  mt-3 country-flag1" data-toggle="dropdown" aria-expanded="false">Get Images</a>
			</div> -->
			<div class="d-flex order-lg-2 ml-auto"><!-- 
				<div class="mt-2">
					<div class="searching mt-2 ml-2 mr-3">
						<a href="javascript:void(0)" class="search-open mt-3">
							<i class="fa fa-search text-dark"></i>
						</a>
						<div class="search-inline">
							<form>
								<input type="text" class="form-control" placeholder="Search here">
								<button type="submit">
									<i class="fa fa-search"></i>
								</button>
								<a href="javascript:void(0)" class="search-close">
									<i class="fa fa-times"></i>
								</a>
							</form>
						</div>
					</div>
				</div> -->
				<div class="dropdown d-none d-md-flex " >
					<a  class="nav-link icon full-screen-link">
						<i class="mdi mdi-arrow-expand-all"  id="fullscreen-button"></i>
					</a>
				</div>
				<div class="dropdown">
					<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
						<span class="avatar avatar-md brround"><img src="{{url('/')}}/{{Auth::user()->companyLogo}}" alt="{{Auth::user()->companyName}}" class="avatar avatar-md brround"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
						<div class="text-center">
							<a href="#" class="dropdown-item text-center font-weight-sembold user">{{Auth::user()->name}}</a>

							<div class="dropdown-divider"></div>
						</div>
						<a class="dropdown-item @if(Request::segment(1)==='edit-profile') active @endif" href="{{ route('edit-profile') }}">
							<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
						</a>

						@can('role-list')
						<a class="dropdown-item @if(Request::segment(1)==='roles') active @endif" href="{{ route('roles.index') }}">
							<i class="dropdown-icon fa fa-folder"></i> 
							Manage Role
						</a>
						@endcan
						@can('permission-list')
                        <a class="dropdown-item @if(Request::segment(1)==='permissions') active @endif" href="{{ route('permissions.index') }}"> 
                        	<i class="dropdown-icon fa fa-folder-open"></i> 
                        	Manage Permission
                        </a>
	                 	@endcan
						@can('app-setting')
						<a class="dropdown-item @if(Request::segment(1)==='app-setting') active @endif" href="{{ route('app-setting') }}">
							<i class="dropdown-icon  mdi mdi-settings"></i> 
							App Setting
						</a>
						@endcan
						
						<div class="dropdown-divider"></div>
						<!-- <a class="dropdown-item @if(Request::segment(1)==='need-help') active @endif" href="{{ route('need-help') }}">
							<i class="dropdown-icon fa fa-question-circle"></i> Help & Support?
						</a> -->
						<a class="dropdown-item" href="{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}">
							<i class="dropdown-icon fa fa-lock"></i> Screen Lock
						</a>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="dropdown-icon mdi  mdi-logout-variant"></i>
                            {{ __('Sign out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>