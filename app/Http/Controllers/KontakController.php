<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        Toastr::info('Mohon maaf, fitur ini masih belum berfungsi', '', $this->toastrOptions());
        return redirect()->route('kontak');
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
