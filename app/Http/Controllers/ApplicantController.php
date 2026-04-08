<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function store(Request $request, \App\Models\Job $job)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'resume'       => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        \App\Models\Applicant::create([
            'job_id'       => $job->id,
            'user_id'      => auth()->id(),
            'full_name'    => $validated['full_name'],
            'contact_info' => $validated['contact_info'],
            'resume_path'  => $resumePath,
        ]);

        return back()->with('success', 'Your application has been submitted!');
    }
}
