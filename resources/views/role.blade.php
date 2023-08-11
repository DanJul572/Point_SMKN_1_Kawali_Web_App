<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pilih Role</title>

    <link rel="stylesheet" href="{{ asset('app/landing/role.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pilih Role</h1>
            <a href="{{ route('welcome') }}">Kembali</a>
        </div>
        <div class="role-1">
            <img src="{{ asset('app/landing/assets/enter.svg') }}" alt="">
            <h2>Siswa / Guru</h2>
            <a href="{{ route('user.login') }}">
                <span>Masuk</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        <div class="role-2">
            <img src="{{ asset('app/landing/assets/noted.svg') }}" alt="">
            <h2>Admin</h2>
            <a href="{{ route('admin.login') }}">
                <span>Masuk</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</body>
</html>