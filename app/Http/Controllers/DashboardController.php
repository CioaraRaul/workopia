<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //@ desc show all users job listings
    //@ route GET /dashboard
    public function index():View
    {
       $user = Auth::user();
       // get the user listings
       $jobs = Job::where('user_id', $user->id)->latest()->get();
        return view('components.dashboard.index', compact('user', 'jobs'));
    }
}
