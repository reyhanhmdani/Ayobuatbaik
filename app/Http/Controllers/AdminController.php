<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_amount = 25000;
        $stats = [
            "total_programs" => 25,
            "total_donations" => 1250,
            "total_amount" => $total_amount,
            "total_users" => 3450,
        ];

        $recent_donations = [
            [
                "name" => "Ahmad S.",
                "amount" => 500000,
                "program" => "Beasiswa Santri Selfa",
                "time" => "2 jam lalu",
            ],
            [
                "name" => "Siti M.",
                "amount" => 250000,
                "program" => "Si Jum On The Road",
                "time" => "5 jam lalu",
            ],
            [
                "name" => "Rina W.",
                "amount" => 100000,
                "program" => "Wakaf Produktif",
                "time" => "1 hari lalu",
            ],
        ];
        $recent_programs = [
            ["title" => "Beasiswa Santri Selfa", "progress_percentage" => 85],
            ["title" => "Si Jum On The Road", "progress_percentage" => 60],
            ["title" => "Wakaf Produktif", "progress_percentage" => 40],
        ];

        return view(
            "pages.admin.dashboard",
            compact("stats", "recent_donations", "recent_programs"),
        );
    }

    public function programs()
    {
        //   $programs = Program::latest()->paginate(10);
        // return view('pages.admin.programs', compact('programs'));
        return view("pages.admin.programs");
    }

    public function donations()
    {
        return view("pages.admin.donations");
    }

    public function users()
    {
        return view("pages.admin.users");
    }
}
