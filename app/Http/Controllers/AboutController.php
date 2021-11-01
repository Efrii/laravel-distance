<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    public function about()
    {
        return view('about', [
            "title" => "About",
            "data" => About::about()
        ]);
    }
}
