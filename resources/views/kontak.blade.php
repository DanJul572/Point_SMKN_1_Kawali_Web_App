@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="{{ asset('app/landing/kontak.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/style.min.css') }}">
@endsection

@section('content')
    <section class="hero">
        <div class="container-grid">
            <div class="section-1">
                <h1><span class="h1-color">Ada Kendala Saat Menggunakan</span> Aplikasi Perhitungan Poin ?</h1>
                <p>Silahkan isi formulir dibawah ini</p>
            </div>
            <div class="section-2">
                <img src="{{ asset('app/lannding/assets/contact.svg') }}" alt="">
            </div>
        </div>
    </section>
    <section class="section-kontak">
        <div class="container-grid">
            <form action="{{ route('kontak.store') }}" method="post" class="kontak-form">
                @csrf
                <input type="email" placeholder="masukkan email..">
                <textarea name="" id="" cols="20" rows="10" placeholder="masukkan deksripsi.."></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('vendor/jquery/script.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/script.min.js') }}"></script>
    {!! Toastr::message() !!}
@endsection