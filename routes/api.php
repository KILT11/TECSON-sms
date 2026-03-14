<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tecson Scholarship Management System - API Routes
|--------------------------------------------------------------------------
*/

// =============================================================
// FEATURE 1 - AUTHENTICATION (Public - No Token Needed)
// =============================================================
Route::post('/register', [AuthController::class, 'register']); // 1.1 Register
Route::post('/login',    [AuthController::class, 'login']);    // 1.2 Login

// =============================================================
// PROTECTED ROUTES (Token Required - Bearer Token)
// =============================================================
Route::middleware('auth:sanctum')->group(function () {

    // 1.3 Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // =============================================================
    // FEATURE 2 - MANAGE STUDENTS/APPLICANTS
    // =============================================================
    Route::get('/students',         [StudentController::class, 'index']);   // 2.1.1 Get/Display all
    Route::post('/students',        [StudentController::class, 'store']);   // 2.1.2 Add
    Route::get('/students/{id}',    [StudentController::class, 'show']);    // 2.1.1 Get single
    Route::put('/students/{id}',    [StudentController::class, 'update']); // 2.1.3 Edit/Update
    Route::patch('/students/{id}',  [StudentController::class, 'update']); // 2.1.3 Edit/Update
    Route::delete('/students/{id}', [StudentController::class, 'destroy']); // 2.1.4 Delete

    // =============================================================
    // FEATURE 3 - MANAGE SCHOLARSHIPS
    // =============================================================
    Route::get('/scholarships',         [ScholarshipController::class, 'index']);   // 3.1.1 Get/Display all
    Route::post('/scholarships',        [ScholarshipController::class, 'store']);   // 3.1.2 Add
    Route::get('/scholarships/{id}',    [ScholarshipController::class, 'show']);    // 3.1.1 Get single
    Route::put('/scholarships/{id}',    [ScholarshipController::class, 'update']); // 3.1.3 Edit/Update
    Route::patch('/scholarships/{id}',  [ScholarshipController::class, 'update']); // 3.1.3 Edit/Update
    Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy']); // 3.1.4 Delete

    // =============================================================
    // FEATURE 4 - APPLICATION MANAGEMENT
    // =============================================================
    Route::get('/applications',         [ApplicationController::class, 'index']);   // 4.1.2 View all
    Route::post('/applications',        [ApplicationController::class, 'store']);   // 4.1.1 Submit
    Route::get('/applications/{id}',    [ApplicationController::class, 'show']);    // 4.1.2 View status
    Route::put('/applications/{id}',    [ApplicationController::class, 'update']); // 4.2.1 Approve / 4.2.2 Reject
    Route::patch('/applications/{id}',  [ApplicationController::class, 'update']); // 4.2.1 Approve / 4.2.2 Reject
    Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']); // Delete
});