<?php

namespace App\Http\Controllers;
use App\Models\JobCard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $jobCards = JobCard::all(); // Fetch all job cards from the database

        return view('home', ['jobCards' => $jobCards, 'user' => $user]);
    }
}
