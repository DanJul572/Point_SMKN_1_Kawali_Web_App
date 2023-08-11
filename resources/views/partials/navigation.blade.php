<nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="nav-item nav-link" href="{{ route('guru.index') }}">Guru</a>
                <a class="nav-item nav-link" href="{{ route('siswa.index') }}">Siswa</a>
                <a class="nav-item nav-link" href="{{ route('kelas.index') }}">Kelas</a>
                <a class="nav-item nav-link" href="{{ route('poin.index') }}">Poin</a>
                <a class="nav-item nav-link" href="{{ route('sanksi.index') }}">Sanksi</a>
                <a class="nav-item nav-link" href="{{ route('penghargaan.index') }}">Penghargaan</a>
                <a class="nav-item nav-link" href="{{ route('semester.index') }}">Semester</a>
                <a class="nav-item nav-link" href="{{ route('pengaduan.index') }}">Pengaduan</a>
                <a class="nav-item nav-link" href="{{ route('poin.siswa') }}">Poin Siswa</a>
                <a class="nav-item nav-link" href="{{ route('penebusan.index') }}">Penebusan Siswa</a>
                <a class="nav-item nav-link" href="{{ route('operasi.index') }}">Operasi</a>
                <div class="dropdown">
                    <a class="nav-item nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ session('admin')['nama'] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>