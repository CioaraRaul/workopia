<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    //@desc Show homepage with latest jobs
    //@route GET /
    
    public function index():View
    {
        $jobs= Job::latest()->limit(6)->get();

        return view('pages.index', compact('jobs'));
    }
}
