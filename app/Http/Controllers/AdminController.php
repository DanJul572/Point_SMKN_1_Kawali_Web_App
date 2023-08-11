<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Str;
use App\Events\ImageProcess;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.login')->only('login');
        $this->middleware('admin.tidak.login')->only('logout');
    }

    public function login(Request $request)
    {
        $admin = Admin::first();
        if ((Hash::check($request->password, $admin->password)) && ($admin->username == $request->username)) {
            session()->put('admin', [
                'id' => $admin->id,
                'nama' => $admin->name,
                'gambar' => 'app/main/image/profile/' . $admin->gambar
            ]);
            return redirect()->route('dashboard.index');
        } else {
            Toastr::error('Username atau Password Salah.', '', $this->toastrOptions());
            return redirect()->route('admin.login');
        }
    }

    public function logout()
    {
        session()->forget('admin');
        Toastr::success('Anda berhasil logout.', '', $this->toastrOptions());
        return redirect()->route('admin.login')->with('message', 'Anda berhasil logout.');
    }

    public function cek (Request $request)
    {
        $admin = Admin::first();
        if ($request->username != $admin->username) {
            return [
                'status' => 'username salah'
            ];
        } else if (!Hash::check($request->password, $admin->password)) {
            return [
                'status' => 'password salah'
            ];
        } else {
            return [
                'status' => 'ok'
            ];
        }
    }

    public function update (Request $request)
    {
        $admin = Admin::first();
        if ($request->gambar != null) {
            $file_name = Str::random() . '.jpg';
            event(new ImageProcess('', 'app/main/image/profile/', $admin->gambar, 'destroy'));
            event(new ImageProcess($request->gambar, 'app/main/image/profile/', $file_name, 'put'));
        } else {
            $file_name = $admin->gambar;
        }
        $admin->update([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'gambar' => $file_name
        ]);
    }

    private function toastrOptions ()
    {
        return [
            "closeButton" => false,
            "debug" => false,
            "newestOnTop" => false,
            "progressBar" => false,
            "positionClass" => "toast-top-right",
            "preventDuplicates" => false,
            "onclick" => null,
            "showDuration" => "300",
            "hideDuration" => "1000",
            "timeOut" => "5000",
            "extendedTimeOut" => "1000",
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut"
        ];
    }
}
