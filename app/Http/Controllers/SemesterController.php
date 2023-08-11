<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login');
    }

    public function lists()
    {
        return Semester::latest()->get();
    }
}
