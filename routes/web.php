<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('welcome');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/role', 'role')->name('role');

Route::group([
    'prefix' => 'kontak',
], function () {
    Route::view('', 'kontak')->name('kontak');
    Route::post('/store', 'KontakController@store')->name('kontak.store');
});

Route::group([
    'prefix' => 'dashboard',
], function () {
    Route::view('/admin', 'content.dashboard.index')->name('dashboard.index')->middleware('admin.tidak.login');
    Route::get('/data', 'DashboardController@data');
    Route::view('/user', 'content.dashboard.user')->name('dashboard.user')->middleware(['akses.user', 'user.tidak.login', 'hanya.siswa']);
});

Route::group([
    'prefix' => 'guru'
], function () {
    Route::view('', 'content.guru.index')->name('guru.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'GuruController@lists');
    Route::post('/store', 'GuruController@store');
    Route::post('/update/{guru}', 'GuruController@update');
    Route::post('/ubah-kode/{guru}', 'GuruController@ubahKode');
    Route::get('/destroy/{guru}', 'GuruController@destroy');
    Route::post('/import', 'GuruController@import')->name('guru.import');
});

Route::group([
    'prefix' => 'siswa'
], function () {
    Route::view('', 'content.siswa.index')->name('siswa.index')->middleware('admin.tidak.login');
    Route::post('/lists', 'SiswaController@lists');
    Route::get('/form', 'SiswaController@form');
    Route::post('/store', 'SiswaController@store');
    Route::post('/update/{siswa}', 'SiswaController@update');
    Route::post('/ubah-kode/{siswa}', 'SiswaController@ubahKode');
    Route::post('/search', 'SiswaController@search');
    Route::post('/poin', 'SiswaController@poin');
    Route::post('/penebusan', 'SiswaController@penebusan');
    Route::post('/penebusan/{siswa}', 'SiswaController@penebusan');
    Route::get('/destroy/{siswa}', 'SiswaController@destroy');
    Route::post('/hapus-banyak', 'SiswaController@hapusBanyak');
    Route::post('/import', 'SiswaController@import')->name('siswa.import');
});

Route::group([
    'prefix' => 'kelas'
], function () {
    Route::view('', 'content.kelas.index')->name('kelas.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'KelasController@lists');
    Route::post('/store', 'KelasController@store');
    Route::post('/update/{kelas}', 'KelasController@update');
    Route::get('/destroy/{kelas}', 'KelasController@destroy');
});

Route::group([
    'prefix' => 'poin'
], function () {
    Route::view('', 'content.poin.index')->name('poin.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'PoinController@lists');
    Route::post('/search', 'PoinController@search');
    Route::view('/create', 'content.poin.create')->name('poin.create')->middleware('admin.tidak.login');
    Route::post('/store', 'PoinController@store');
    Route::post('/update/{poin}', 'PoinController@update');
    Route::get('/destroy/{poin}', 'PoinController@destroy');
    Route::view('/cek', 'content.poin.cek')->name('poin.cek')->middleware('user.tidak.login');
    Route::post('/cek', 'PoinController@cek');
    Route::view('/siswa', 'content.poin.siswa')->name('poin.siswa')->middleware('admin.tidak.login');
    Route::post('/siswa', 'PoinController@siswa');
});

Route::group([
    'prefix' => 'penebusan'
], function () {
    Route::view('', 'content.penebusan.index')->name('penebusan.index')->middleware('admin.tidak.login');
    Route::post('/siswa', 'PenebusanController@siswa');
});


Route::group([
    'prefix' => 'sanksi'
], function () {
    Route::view('', 'content.sanksi.index')->name('sanksi.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'SanksiController@lists');
    Route::post('/store', 'SanksiController@store');
    Route::post('/update/{sanksi}', 'SanksiController@update');
    Route::get('/destroy/{sanksi}', 'SanksiController@destroy');
});

Route::group([
    'prefix' => 'penghargaan'
], function () {
    Route::view('', 'content.penghargaan.index')->name('penghargaan.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'PenghargaanController@lists');
    Route::post('/store', 'PenghargaanController@store');
    Route::post('/update/{penghargaan}', 'PenghargaanController@update');
    Route::get('/destroy/{penghargaan}', 'PenghargaanController@destroy');
    Route::post('/search', 'PenghargaanController@search');
});

Route::group([
    'prefix' => 'semester'
], function () {
    Route::view('', 'content.semester.index')->name('semester.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'SemesterController@lists');
});


Route::group([
    'prefix' => 'pengaduan'
], function () {
    Route::view('', 'content.pengaduan.index')->name('pengaduan.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'PengaduanController@lists');
    Route::get('/konfirmasi/{pengaduan}', 'PengaduanController@konfirmasi');
    Route::view('/create', 'content.pengaduan.create')->name('pengaduan.create')->middleware('user.tidak.login');
    Route::post('/store', 'PengaduanController@store');
    Route::get('/destroy/{pengaduan}', 'PengaduanController@destroy');
});

Route::group([
    'prefix' => 'operasi'
], function () {
    Route::view('', 'content.operasi.index')->name('operasi.index')->middleware('admin.tidak.login');
    Route::get('/lists', 'OperasiController@lists');
    Route::get('/ubah-akses-user', 'OperasiController@ubahAksesUser');
    Route::get('/naikan-semester', 'OperasiController@naikanSemester');
    Route::post('/get-laporan', 'OperasiController@getLaporan');
    Route::get('/bersih-data-siswa', 'OperasiController@bersihDataSiswa');
    Route::get('/bersih-data-pengaduan', 'OperasiController@bersihDataPengaduan');
});

Route::group([
    'prefix' => 'user',
    'middleware' => 'akses.user'
], function () {
    Route::get('/data', 'UserController@data');
    Route::view('/login', 'auth.user')->name('user.login');
    Route::post('/login', 'UserController@login')->name('user.login.post');
    Route::get('/logout', 'UserController@logout')->name('user.logout');
    Route::post('/ubah-kode', 'UserController@ubahKode');
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::view('/login', 'auth.admin')->name('admin.login')->middleware('admin.login');
    Route::post('/login', 'AdminController@login')->name('admin.login.post');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    Route::view('/profile', 'content.profile.index')->name('admin.profile')->middleware('admin.tidak.login');
    Route::post('/cek', 'AdminController@cek');
    Route::post('/update', 'AdminController@update');
});