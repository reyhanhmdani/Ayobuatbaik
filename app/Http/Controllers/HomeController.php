<?php

namespace App\Http\Controllers;

use App\Models\ProgramDonasi;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPrograms = ProgramDonasi::where('featured', 1)->where('status', 'published')->orderBy('id', 'desc')->take(3)->get();

        $otherPrograms = ProgramDonasi::where('featured', 0)->orderBy('id', 'desc')->take(7)->get();

        return view('pages.home', compact('featuredPrograms', 'otherPrograms'));
    }

    public function programs()
    {
        return view('pages.program-donasi.programs');
    }

    public function program()
    {
        return view('pages.program-donasi.single-program');
    }
}
