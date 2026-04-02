<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    // @desc Show all jobs
    // @route GET /jobs

    public function index(): View
    {
        $jobs= Job::all();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // @desc Show job creation form
    // @route GET /jobs/create

    public function create():View
    {

        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // @desc Handle job creation form submission
    // @route POST /jobs
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer|min:0',
            'tags'=> 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'required|email',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'company_logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Map form field 'tags' to DB column 'strings'
        $validateData['strings'] = $validateData['tags'] ?? null;
        unset($validateData['tags']);

        // Convert job_type to lowercase to match DB enum values
        $validateData['job_type'] = strtolower($validateData['job_type']);

        $validateData['user_id'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/logos'), $filename);
            $validateData['company_logo'] = $filename;
        } else {
            unset($validateData['company_logo']);
        }



        // Create the job
        Job::create($validateData);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */

    // @desc Show job details
    // @route GET /jobs/{id}
    public function show(Job $job):View
    {
        return view('jobs.show')->with('job',$job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job) : View
    {
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */

    // @desc Handle job edit form submission
    // @route PUT /jobs/{id}
    public function update(Request $request, Job $job) : RedirectResponse
    {
        $this->authorize('update', $job);

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer|min:0',
            'tags'=> 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'company_website' => 'nullable|url',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'required|email',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'company_logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Map form field 'tags' to DB column 'strings'
        $validateData['strings'] = $validateData['tags'] ?? null;
        unset($validateData['tags']);

        // Convert job_type to lowercase to match DB enum values
        $validateData['job_type'] = strtolower($validateData['job_type']);

        // Handle file upload
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/logos'), $filename);
            $validateData['company_logo'] = $filename;
        } else {
            unset($validateData['company_logo']);
        }

        $job->update($validateData);

        return redirect()->route('jobs.show', $job->id)->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    // @desc Handle job deletion
    // @route DELETE /jobs/{id}
    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);


        // Delete company logo if it exists
        if ($job->company_logo) {
            $logoPath = storage_path('app/public/logos/' . $job->company_logo);
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }

        $job->delete();

        //check if the request came from dashboard
        if(request()->query('from') === 'dashboard'){
            return redirect()->route('dashboard')->with('success', 'Job deleted successfully.');
        }

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

}
