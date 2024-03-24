<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;


Route::get("/", [HomeController::class,"index"])->name("home");
Route::get("/jobs", [JobsController::class,"index"])->name("jobs");
Route::get("/jobs/detail/{id}", [JobsController::class,"detail"])->name("jobDetail");
Route::post("/apply-job", [JobsController::class,"applyJob"])->name("applyJob");

Route::group(['account'], function() {

    // Guest Route
    Route::group(['middleware' => 'guest'], function() {
        Route::get("/register", [AccountController::class,"registration"])->name("account.registration");
        Route::post("/process-register", [AccountController::class,"processRegistration"])->name("account.processRegistration");
        Route::get("/login", [AccountController::class,"login"])->name("account.login");
        Route::post("/authenticate", [AccountController::class,"authenticate"])->name("account.authenticate");
    });

    // Authenticated Routes
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/profile', [AccountController::class,'profile'])->name('account.profile');
        Route::put('/update-profile', [AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class,'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-job', [AccountController::class,'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class,'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs',[AccountController::class,'myJob'])->name('account.myJob');
        Route::get('/my-jobs/edit/{jobId}',[AccountController::class,'jobEdit'])->name('account.jobEdit');
        Route::post('/update-job/{jobId}', [AccountController::class,'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [AccountController::class,'deleteJob'])->name('account.deleteJob');
        Route::post('/my-job-applications', [AccountController::class,'myJobApplications'])->name('account.myJobApplications');
        Route::post('/remove-job-application', [AccountController::class,'removeJob'])->name('account.removeJob');

    });

});
