@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="{{ asset('app/landing/tentang.css') }}">
@endsection

@section('content')
    <section class="hero">
        <div class="container-grid">
            <div class="section-1">
                <h1><span class="h1-color">Tentang Perhitungan Poin</span> SMKN 1 Kawali</h1>
                <p>SMK Hebat, SMK Pasti Bisa !</p>
            </div>
            <div class="section-2">
                <img src="{{ asset('app/landing/assets/tentang.svg') }}" alt="">
            </div>
        </div>
    </section>
    <section class="tentang-perhitungan-poin">
        <div class="container-grid">
            <div class="card-tentang">
                <div class="head-tentang">
                    <img src="{{ asset('app/landing/assets/since.svg') }}" alt="since">
                </div>
                <div class="body-tentang">
                    <h2>Berdiri Sejak 2020</h2>
                    <p>Perhitungan Poin SMKN 1 Kawali dibuat oleh Siswa RPL selama Praktek Kerja Lapangan</p>
                </div>
            </div>
            <div class="card-tentang">
                <div class="head-tentang">
                    <img src="{{ asset('app/landing/assets/segmentation.svg') }}" alt="segmentation">
                </div>
                <div class="body-tentang">
                    <h2>Mempermudah Pendataan</h2>
                    <p>Dengan adanya aplikasi Perhitungan Poin SMKN 1 Kawali, pendataan lebih mudah</p>
                </div>
            </div>
            <div class="card-tentang">
                <div class="head-tentang">
                    <img src="{{ asset('app/landing/assets/poin-terbuka.svg') }}" alt="poin-terbuka">
                </div>
                <div class="body-tentang">
                    <h2>Perhitungan Poin Lebih Terbuka</h2>
                    <p>Siswa SMKN 1 Kawali  sekarang bisa melihat poinnya sendiri di aplikasi Perhitungan Poin</p>
                </div>
            </div>
            <div class="card-tentang">
                <div class="head-tentang">
                    <img src="{{ asset('app/landing/assets/smk-teknologi.svg') }}" alt="smk-teknologi">
                </div>
                <div class="body-tentang">
                    <h2>Menjadi SMK Serba Teknologi</h2>
                    <p>SMKN 1 Kawali secara bertahap akan menjadi SMK serba Teknologi</p>
                </div>
            </div>
        </div>
    </section>
@endsection