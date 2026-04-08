<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function store(Request $request, Job $job): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'contact_info' => 'string|max:255',
                'resume'       => 'file|mimes:pdf,doc,docx|max:2048',
            'message'      => 'nullable|string|max:1000',
            ]);

            if($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
            }

        $application = new Applicant();
        $application->job_id = $job->id;
        $application->applicant_id = $job->applicant_id;
        $application->full_name = $validated['full_name'];
        $application->contact_info = $validated['contact_info'];
        $application->resume_path = $resumePath;
        $application->message = $validated['message'];
        $application->save();

        return back()->with('success', 'Your application has been submitted!');
    }
}
