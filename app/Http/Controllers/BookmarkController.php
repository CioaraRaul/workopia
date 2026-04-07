<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    //@desc Get all users bookmarked jobs
    //@route GET /bookmarks

    public function index():View{
        /** @var \App\Models\User $user */
        $user= Auth::user();
        $bookmarks = $user->bookmarkedJobs()->paginate(10);
        return view('jobs.bookmarked', compact('bookmarks'));
    }
}
