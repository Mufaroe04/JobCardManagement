<?php

namespace App\Services;

use App\Models\JobCard;
use Illuminate\Support\Facades\Auth;

class JobCardService
{
    public function getJobCardsWithUser()
    {
        $user = Auth::user();
        $jobCards = JobCard::all(); // Fetch all job cards
        return ['jobCards' => $jobCards, 'user' => $user];
    }
}