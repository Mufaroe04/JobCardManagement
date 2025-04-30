<?php

namespace App\Http\Controllers;

use App\Models\JobCard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the job card reports page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = JobCard::query();

        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $jobCards = $query->get();

        $total = $jobCards->count();
        $approved = $jobCards->where('status', 'Approved')->count();
        $pending = $jobCards->where('status', 'Pending')->count();
        $rejected = $jobCards->where('status', 'Rejected')->count();

        return view('job-cards.reports', [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
        ]);
    }
}