<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return view('pages.program-donasi.programs');
    }

    public function show()
    {
        return view('pages.program-donasi.single-program');
    }
}
