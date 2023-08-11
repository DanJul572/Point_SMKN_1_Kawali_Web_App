@extends('layouts.landing')

@section('content')
    <section class="hero">
        <div class="container-grid">
            <div class="section-1">
                <h1><span class="h1-color">Perhitungan Poin Siswa</span> SMKN 1 Kawali</h1>
                <p>SMK Hebat, SMK Pasti Bisa !</p>
                <a href="{{ route('role') }}" class="btn-register">Mulai Sekarang !
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                            d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
            <div class="section-2">
                <img src="{{ asset('app/landing/assets/study.svg') }}" alt="">
            </div>
        </div>
    </section>
    <!-- service text -->
    <section class="service-text">
        <div class="container-grid">
            <div class="head-service">
                <h2>Beragam fitur yang diberikan</h2>
            </div>
        </div>
    </section>
    <section class="body-service">
        <div class="container-flex-2">
            <div class="card-service">
                <svg fill="none" stroke="#cf3f38" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
                <h3>Pengaduan</h3>
                <p>Memudahkan untuk melapor bila melihat kesalahan</p>
            </div>
            <div class="card-service">
                <svg fill="none" stroke="#cf3f38" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3>Kelola Data</h3>
                <p>Memudahkan untuk mengelola data setiap harinya</p>
            </div>
            <div class="card-service">
                <svg fill="none" stroke="#cf3f38" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3>Laporan Data</h3>
                <p>Membuat laporan lebih simpel menggunakan aplikasi ini</p>
            </div>
        </div>
    </section>
    <section class="cara-login">
        <div class="container-grid">
            <h2>Bagaimana cara menggunakan aplikasi Perhitungan Poin SMKN 1 Kawali ?</h2>
            <div class="konten-login">
                <div class="text-login">
                    <span>1</span>
                    <h3>Masukkan NIS / NIP</h3>
                    <p>Pengguna yang ingin login ke aplikasi poin SMKN 1 Kawali harus memasukkan NIS / NIP yang
                        sudah disediakan </p>
                </div>
                <img src="{{ asset('app/landing/assets/text-field.svg') }}" alt="text-field" alt="text">
            </div>
            <div class="konten-login">
                <div class="text-login">
                    <span>2</span>
                    <h3>Masukkan Password</h3>
                    <p>Pengguna yang baru pertama kali menggunakan aplikasi poin SMKN 1 Kawali akan diberi code
                        default oleh Admin</p>
                </div>
                <img src="{{ asset('app/landing/assets/auth.svg') }}" alt="text-field">
            </div>
            <div class="konten-login">
                <div class="text-login">
                    <span>3</span>
                    <h3>Selamat Berhasil Login</h3>
                    <p>Jika berhasil login menggunakan akun yang anda miliki, otomatis akan diarahkan ke halaman
                        utama</p>
                </div>
                <img src="{{ asset('app/landing/assets/done.svg') }}" alt="text-field">
            </div>
        </div>
    </section>
    <section class="alamat">
        <div class="container-grid">
            <div class="text-alamat">
                <h3>SMKN 1 Kawali</h3>
                <p>JL Talagasari, No. 35, Kawalimukti, Kawali, Kawalimukti, Ciamis, Kabupaten Ciamis, Jawa Barat
                    46253
                </p>
            </div>

            <div class="map-alamat">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.4716914219107!2d108.36043621431992!3d-7.186894072531966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f43087e24f9d3%3A0x34cfd3589f2615d0!2sSMK%20Negeri%201%20Kawali!5e0!3m2!1sid!2sid!4v1602471655418!5m2!1sid!2sid"
                    width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                    aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </section>
@endsection