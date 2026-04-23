<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Ibeka</title>
	<link rel="stylesheet" href="{{asset('backend/fonts/fontawesome/css/fontawesome-all.min.css')}}">
	<!-- animation css -->
	<link rel="stylesheet" href="{{asset('backend/plugins/animation/css/animate.min.css')}}">

	<!-- vendor css -->
	<link rel="stylesheet" href="{{asset('backend/css/style.css')}}">

	<link rel="stylesheet" href="{{asset('backend/plugins/data-tables/css/datatables.min.css')}}">
	
</head>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menupos-fixed menu-dark menu-item-icon-style6 ">
		<div
			class="navbar-wrapper ">
			<div class="navbar-brand header-logo">
				<a href="/dashboard" class="b-brand">

					<img src="{{asset('backend/images/logo.svg')}}" alt="logo" class="logo images">
					<img src="{{asset('backend/images/logo-icon.svg')}}" alt="logo" class="logo-thumb images">
				</a>
				<a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
			</div>
			<div class="navbar-content scroll-div   "
				id="layout-sidenav" >
				<ul class="nav pcoded-inner-navbar sidenav-inner">
					<li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li data-username="dashboard default ecommerce sales Helpdesk ticket CRM analytics project"
                        class="nav-item">
                        <a href="/dashboard" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Frontend</label>
                    </li>
                    <li data-username="basic components button alert badges breadcrumb pagination progress tooltip popovers carousel cards collapse tabs pills modal spinner grid system toasts typography extra shadows embeds"
                        class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-box"></i></span><span class="pcoded-mtext">Frontend Menu</span></a>
                        <ul class="pcoded-submenu">
                            <!-- Add new view to showing product type such as plakat, banner, etc -->
                            <li class=""><a href="{{ url('/dashboard/jenis-produk') }}" class="">Product Type</a></li>
                            <li class=""><a href="{{ url('/dashboard/kategori-product') }}"
                                    class="">Product Category</a></li>
                            <li class=""><a href="{{ url('/dashboard/daftar-product') }}" class="">Product List</a></li>
                            <li class=""><a href="{{ route('machine.index') }}" class="">Machine List</a></li>


                        </ul>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Backend</label>
                    </li>
                    <li data-username="basic components button alert badges breadcrumb pagination progress tooltip popovers carousel cards collapse tabs pills modal spinner grid system toasts typography extra shadows embeds"
                        class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-grid"></i></span><span class="pcoded-mtext">Backend
                                Menu</span></a>
                        <ul class="pcoded-submenu">
                            <li class=""><a href="{{ url(path: '/dashboard/partnership') }}"
                                    class="">Partner
                                    List</a></li>
                            <li class=""><a href="{{ url(path: '/dashboard/review') }}" class="">Review
                                    List</a></li>
                            <li class=""><a href="{{ route('banner.index') }}" class="">Banner List</a></li>
                        </ul>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>User</label>
                    </li>
                    <li data-username="basic components button alert badges breadcrumb pagination progress tooltip popovers carousel cards collapse tabs pills modal spinner grid system toasts typography extra shadows embeds"
                        class="nav-item">
                        <a href="{{ url(path: '/dashboard/Daftar-User') }}" class="nav-link"><span
                                class="pcoded-micon"><i class="feather icon-user"></i></span><span
                                class="pcoded-mtext">User List</span></a>
                    </li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
		
			<div class="m-header">
				<a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
				<a href="index.html" class="b-brand">

					<img src="backend/images/logo.svg" alt="" class="logo images">
					<img src="backend/images/logo-icon.svg" alt="" class="logo-thumb images">
				</a>
			</div>
			<a class="mobile-menu" id="mobile-header" href="#!">
				<i class="feather icon-more-horizontal"></i>
			</a>
			<div class="collapse navbar-collapse">
				<a href="#!" class="mob-toggler"></a>
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<div class="main-search open">
							<div class="input-group">
								<input type="text" id="m-search" class="form-control" placeholder="Search . . .">
								<a href="#!" class="input-group-append search-close">
									<i class="feather icon-x input-group-text"></i>
								</a>
								<span class="ms-1 input-group-append search-btn btn btn-primary">
									<i class="feather icon-search input-group-text"></i>
								</span>
							</div>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav ms-auto">
					<li>
					
					<li>
						<div class="dropdown drp-user">
							<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
								<i class="icon feather icon-settings"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end profile-notification">
								<div class="pro-head">
								
									<span>
										<span class="h6">{{ Auth::user()->username }}</span>

									</span>
								</div>
								<ul class="pro-body">
								<li>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
								</form>
								
								<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<i class="feather icon-power text-danger"></i> Logout
								</a>
							</li>
								</ul>
							</div>
						</div>
					</li>
				</ul>
			</div>
			
	</header>
	<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
      @yield('content')
<!-- [ Main Content ] end -->

<!-- Required Js -->
<script src="{{asset('backend/js/vendor-all.min.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/js/pcoded.min.js')}}"></script>

<!-- am chart js -->
<script src="{{asset('backend/plugins/chart-am4/js/core.js')}}"></script>
<script src="{{asset('backend/plugins/chart-am4/js/animated.js')}}"></script>

@yield('scripts')

<!-- datatable js -->
<script src="{{asset('backend/plugins/data-tables/js/datatables.min.js')}}"></script>
<script src="{{asset('backend/js/pages/data-basic-custom.js')}}"></script>

<!-- dashboard-custom js -->
<script src="{{asset('backend/js/pages/dashboard-analytics.js')}}"></script>

<script src="{{ asset('backend/js/webp-converter.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>


</body>

</html>