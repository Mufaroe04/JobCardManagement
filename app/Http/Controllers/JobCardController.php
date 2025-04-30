<?php

namespace App\Http\Controllers;

use App\Models\JobCard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
class JobCardController extends Controller
{
    /**
     * Show the form for creating a new job card.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('job-cards.create');
    }

    /**
     * Store a newly created job card in storage (for API requests).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeApi(Request $request): JsonResponse
    {
        // 1. Validate the incoming data
        $validator = Validator::make($request->all(), [
            'job_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'job_description' => 'required|string',
            'assigned_technician' => 'nullable|string|max:255',
            'estimated_completion_date' => 'nullable|date',
            'status' => 'string|in:Pending,In Progress,Completed,Rejected,Approved', // Added status validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation error',
            ], 422); // Use 422 for validation errors
        }

        // 2. Create the job card
        $jobCard = JobCard::create([
            'job_title' => $request->input('job_title'),
            'client_name' => $request->input('client_name'),
            'job_description' => $request->input('job_description'),
            'assigned_technician' => $request->input('assigned_technician'),
            'estimated_completion_date' => $request->input('estimated_completion_date'),
            'status' => $request->input('status', 'Pending'), // Default status if not provided
        ]);

        // 3. Return a JSON response
        return response()->json([
            'message' => 'Job card created successfully',
            'job_card' => $jobCard,
        ], 201); // Use 201 for successful creation
    }

    /**
     * Store a newly created job card in storage (for web form submission).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the incoming data
        $request->validate([
            'job_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'job_description' => 'required|string',
            'assigned_technician' => 'nullable|string|max:255',
            'estimated_completion_date' => 'nullable|date',
            // 'status' can be omitted here as it defaults in the model/migration
        ]);

        // 2. Create the job card
        JobCard::create([
            'job_title' => $request->input('job_title'),
            'client_name' => $request->input('client_name'),
            'job_description' => $request->input('job_description'),
            'assigned_technician' => $request->input('assigned_technician'),
            'estimated_completion_date' => $request->input('estimated_completion_date'),
            'status' => 'Pending', // Set default status for web creation
        ]);

        // 3. Redirect the user
        return redirect()->route('home')->with('success', 'Job card created successfully!');
    }
     /**
     * Approve a pending job card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCard  $jobCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, JobCard $jobCard): RedirectResponse
    {
        if ($jobCard->status === 'Pending') {
            $jobCard->update([
                'status' => 'Approved',
                'admin_comments' => $request->input('admin_comments'), // Save approval comments
            ]);
            Session::flash('success', "Job card '{$jobCard->job_title}' approved successfully.");
        } else {
            Session::flash('error', "Job card '{$jobCard->job_title}' is not pending.");
        }
    
        return redirect()->route('home');
    }

    /**
     * Reject a pending job card and add admin comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCard  $jobCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, JobCard $jobCard): RedirectResponse
    {
        if ($jobCard->status === 'Pending') {
            $request->validate(['admin_comments' => 'required|string']);
            $jobCard->update([
                'status' => 'Rejected',
                'admin_comments' => $request->input('admin_comments'),
            ]);
            Session::flash('success', "Job card '{$jobCard->job_title}' approved successfully.");
        } else {
            Session::flash('error', "Job card '{$jobCard->job_title}' is not pending.");
        }

        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified job card.
     *
     * @param  \App\Models\JobCard  $jobCard
     * @return \Illuminate\View\View
     */
    public function edit(JobCard $jobCard): View
    {
        return view('job-cards.edit', compact('jobCard'));
    }

    /**
     * Update the specified job card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCard  $jobCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, JobCard $jobCard): RedirectResponse
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'job_description' => 'required|string',
            'assigned_technician' => 'nullable|string|max:255',
            'estimated_completion_date' => 'nullable|date',
            'status' => 'required|in:Pending,Approved,Rejected', // Add other valid statuses if needed
        ]);

        $jobCard->update($request->all());

        return redirect()->route('home')->with('success', "Job card '{$jobCard->job_title}' updated successfully!");
    }
    
}