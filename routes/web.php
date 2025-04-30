<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobCardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController; // Add this import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//  Remove the duplicate '/' route
Route::get('/', function () {
    if (auth()->check()) {
        return app(HomeController::class)->index(); // Use the HomeController to fetch data
    } else {
        return redirect()->route('login');
    }
});


Route::get('/api/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::post('/api/job-cards', [JobCardController::class, 'store']);
Route::post('/api/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/api/logout', [UserController::class, 'logout']);
Route::get('/register', function () {
    return view('auth.register');
});
Auth::routes();  //Keep this


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/job-cards/create', [JobCardController::class, 'create'])->name('job-cards.create')->middleware('auth'); // Added middleware
Route::post('/job-cards', [JobCardController::class, 'store'])->name('job-cards.store')->middleware('auth');  // Added middleware
Route::post('/job-cards/{jobCard}/approve', [JobCardController::class, 'approve'])->name('job-cards.approve')->middleware('auth'); // Added middleware
Route::post('/job-cards/{jobCard}/reject', [JobCardController::class, 'approve'])->name('job-cards.reject')->middleware('auth');  // Added middleware
Route::get('/reports', [ReportController::class, 'index'])->name('reports')->middleware('auth'); // Keep middleware
// Route::get('/admin/users', [UserController::class, 'index'])->name('users.index')->middleware('auth', 'is_admin');
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
Route::put('/admin/toggleAdmin/{id}', [UserController::class, 'toggleAdmin'])->name('users.toggleAdmin')->middleware('auth');