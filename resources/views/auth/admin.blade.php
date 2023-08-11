<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('app/auth/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/style.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="hero-left">
            <img src="{{ asset('app/auth/admin/bekerja.svg') }}" alt="">
            <div class="head-left">
                <h1>Perhitungan Poin SMKN 1 Kawali</h1>
                <span>Bekerja lebih simpel dan efisien</span>
            </div>

        </div>
        <div class="hero-right">
            <form action="{{ route('admin.login.post') }}" method="post">
                @csrf
                <h1>Silahkan Login</h1>
                <div class="input">
                    <span>Username</span>
                    <input type="text" name="username" autocomplete="off">
                </div>
                <div class="input">
                    <span>Password</span>
                    <input type="password" name="password" autocomplete="off">
                </div>
                <button type="submit">Masuk</button>
                <a href="{{ route('role') }}" class="kembali">Kembali</a>
            </form>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/script.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/script.min.js') }}"></script>
    {!! Toastr::message() !!}
</body>

</html>