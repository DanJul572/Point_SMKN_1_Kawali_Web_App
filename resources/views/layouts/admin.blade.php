<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Poin SMKN 1 Kawali</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('app/main/css/ready.css') }}">
	<link rel="stylesheet" href="{{ asset('app/main/css/demo.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
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
								<img src="{{ asset(session('admin')['gambar']) }}" alt="user-img" width="36" class="img-circle">
								<span>{{ session('admin')['nama'] }}</span></span>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="{{ asset(session('admin')['gambar']) }}" alt="user"></div>
										<div class="u-text">
											<h4>{{ session('admin')['nama'] }}</h4>
											<p class="text-muted">BK SMK Negeri 1 Kawali</p>
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item {{ request()->segment(2) == 'profile' ? 'active' : '' }}" href="{{ route('admin.profile') }}">
									<i class="fas fa-fw fa-user-cog"></i> Pengatuan Akun
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('admin.logout') }}">
									<i class="fa fa-fw fa-power-off"></i> Keluar
								</a>
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
					<li class="nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
						<a href="{{ route('dashboard.index') }}">
							<i class="fas fa-fw fa-fire"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'guru' ? 'active' : '' }}">
						<a href="{{ route('guru.index') }}">
							<i class="fas fa-fw fa-chalkboard-teacher"></i>
							<p>Guru</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'siswa' ? 'active' : '' }}">
						<a href="{{ route('siswa.index') }}">
							<i class="fas fa-fw fa-user-graduate"></i>
							<p>Siswa</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'kelas' ? 'active' : '' }}">
						<a href="{{ route('kelas.index') }}">
							<i class="fas fa-fw fa-list-ol"></i>
							<p>Kelas</p>
						</a>
					</li>
					<li class="nav-item {{ (request()->segment(1) == 'poin') && (request()->segment(2) == '') ? 'active' : '' }}">
						<a href="{{ route('poin.index') }}">
							<i class="fas fa-fw fa-exclamation-triangle"></i>
							<p>Poin</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'penghargaan' ? 'active' : '' }}">
						<a href="{{ route('penghargaan.index') }}">
							<i class="fas fa-fw fa-certificate"></i>
							<p>Penghargaan</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'sanksi' ? 'active' : '' }}">
						<a href="{{ route('sanksi.index') }}">
							<i class="fas fa-fw fa-gavel"></i>
							<p>Sanksi</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'pengaduan' ? 'active' : '' }}">
						<a href="{{ route('pengaduan.index') }}">
							<i class="fas fa-fw fa-comments"></i>
							<p>Pengaduan</p>
						</a>
					</li>
					<li class="nav-item {{ ((request()->segment(1) == 'poin') && (request()->segment(2) == 'siswa')) || ((request()->segment(1) == 'poin') && (request()->segment(2) == 'create')) ? 'active' : '' }}">
						<a href="{{ route('poin.siswa') }}">
							<i class="fas fa-fw fa-user-times"></i>
							<p>Poin Siswa</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'penebusan' ? 'active' : '' }}">
						<a href="{{ route('penebusan.index') }}">
							<i class="fas fa-fw fa-user-check"></i>
							<p>Penebusan Siswa</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'semester' ? 'active' : '' }}">
						<a href="{{ route('semester.index') }}">
							<i class="far fa-fw fa-calendar-check"></i>
							<p>Semester</p>
						</a>
					</li>
					<li class="nav-item {{ request()->segment(1) == 'operasi' ? 'active' : '' }}">
						<a href="{{ route('operasi.index') }}">
							<i class="fas fa-fw fa-cogs"></i>
							<p>Operasi</p>
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