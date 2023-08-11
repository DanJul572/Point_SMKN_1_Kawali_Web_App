<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perhitungan Poin | SMKN 1 Kawali</title>

    <link rel="stylesheet" href="{{ asset('app/landing/style.css') }}">
    
    @yield('style')
    
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav>
            <div class="container-flex">
                <a href="{{ route('welcome') }}" class="logo">
                    <img src="{{ asset('app/landing/assets/terbaru-logo.png') }}" alt="logo SMKN 1 Kawali">
                    <h3>SMKN 1 Kawali</h3>
                </a>
                <div class="menu-btn">
                    <div class="menu-btn__burger"></div>
                </div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('tentang') }}"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222">
                                    </path>
                                </svg>Tentang
                            </a>
                        </li>
                    <li><a href="#"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>Web</a></li>
                    <li><a href="{{ route('kontak') }}"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>Kontak</a></li>
                    <li><a href="./login/">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>Login</a></li>
                </ul>
                <a href="{{ route('role') }}" class="btn-login">Login</a>
            </div>
        </nav>

        @yield('content')

        <footer>
            <div class="container-grid">
                <div class="head-f">
                    <div class="tentang">
                        <h3>Tentang SMKN 1 Kawali</h3>
                        <p>SMKN 1 Kawali merupakan sebuah SMK Negeri di kawasan Ciamis Utara yang mulai berdiri tahun
                            2005
                        </p>
                    </div>
                    <div class="tautan">
                        <h3>Tautan</h3>
                        <ul>
                            <li><a href="#">SMKN 1 Kawali</a></li>
                            <li><a href="#">Perhitungan Poin SMKN 1 Kawali</a></li>
                        </ul>
                    </div>
                    <div class="info-kontak">
                        <h3>Info Kontak</h3>
                        <ul>
                            <li>Alamat: Jl. Talagasari No.35 Kawali-Kabupaten Ciamis-Jawa Barat 46253</li>
                            <li>Phone: 0265-791727</li>
                            <li>Email: smkn1kawali@gmail.com</li>
                        </ul>
                    </div>
                    <div class="smk-hebat">
                        <img src="{{ asset('app/landing/assets/smk-hebat.png') }}" alt="smk hebat">
                    </div>
                </div>
                <div class="body-f">
                    <p>Copyright 2020 by SMKN 1 Kawali</p>
                </div>
            </div>

        </footer>


    </div>
    <script src="{{ asset('app/landing/script.js') }}"></script>
    @yield('script')
</body>

</html>