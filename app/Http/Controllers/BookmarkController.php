<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    //@desc Get all users bookmarked jobs
    //@route GET /bookmarks

    public function index():View{
        /** @var \App\Models\User $user */
        $user= Auth::user();
        $bookmarks = $user->bookmarkedJobs()->latest('job_user_bookmarks.created_at')->paginate(10);
        return view('jobs.bookmarked', compact('bookmarks'));
    }

     //@desc create new bookmarked job
    //@route POST /bookmarks

    public function store(Job $job):RedirectResponse{
        /** @var \App\Models\User $user */
        $user= Auth::user();

        //check if the job is already bookmark
        if($user->bookmarkedJobs()->where('job_id', $job->id)->exists()){
            return back()->with('error', ' job already bookmark');
        }

        // create new bookmark
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success','Job bookmarked succesfully');
    }


     //@desc remove a bookmarked job
    //@route DELETE /bookmarks/{job}

    public function destroy(Job $job):RedirectResponse{
        /** @var \App\Models\User $user */
        $user= Auth::user();

        //check if the job is not bookmark
        if(!$user->bookmarkedJobs()->where('job_id', $job->id)->exists()){
            return back()->with('error', ' job not bookmark');
        }

        // remove the bookmark
        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('success','Job unbookmarked succesfully');
    }
}
