<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Poin SMKN 1 Kawali</title>

    <link rel="stylesheet" href="{{ asset('app/main/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('app/main/css/ready.css') }}">
	<link rel="stylesheet" href="{{ asset('app/main/css/demo.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    
</head>
<body>
    <div class="wrapper">
		<div class="main-header">
			<div class="logo-header">
				<a href="{{ route('welcome') }}" class="logo">
					SMKN 1 KAWALI
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<img src="{{ asset('app/main/image/profile/user.jpg') }}" alt="user-img" width="36" class="img-circle">
								<span>{{ session('user')['nama'] }}</span></span>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="{{ asset('app/main/image/profile/user.jpg') }}" alt="user"></div>
										<div class="u-text">
											<h4>{{ session('user')['nama'] }}</h4>
											@if (session('user')['status'] == 'siswa')
												<p class="text-muted">Siswa SMK Negeri 1 Kawali</p>
												@else
												<p class="text-muted">Guru SMK Negeri 1 Kawali</p>
											@endif
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('user.logout') }}"><i class="fa fa-fw fa-power-off"></i> Keluar</a>
							</ul>
							<!-- /.dropdown-user -->
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="sidebar">
			<div class="scrollbar-inner sidebar-wrapper">
				<ul class="nav">
					@if (session('user')['status'] == 'siswa')
						<li class="nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
							<a href="{{ route('dashboard.user') }}">
								<i class="fas fa-fw fa-fire"></i>
								<p>Dashboard</p>
							</a>
						</li>
					@endif
					<li class="nav-item {{ request()->segment(1) == 'pengaduan' ? 'active' : '' }}">
						<a href="{{ route('pengaduan.create') }}">
							<i class="fas fa-fw fa-comments"></i>
							<p>Pengaduan</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'poin' ? 'active' : '' }}">
						<a href="{{ route('poin.cek') }}">
							<i class="fas fa-fw fa-user-times"></i>
							<p>Cek Poin</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<div class="content">
				<div class="container-fluid">
					<div id="app">
                        @yield('content')
                    </div>
				</div>
			</div>
		</div>
	</div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('app/main/js/ready.js') }}"></script>
</body>
</html>