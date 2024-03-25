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
        Route::GET("/register", [AccountController::class,"registration"])->name("account.registration");
        Route::POST("/process-register", [AccountController::class,"processRegistration"])->name("account.processRegistration");
        Route::GET("/login", [AccountController::class,"login"])->name("account.login");
        Route::POST("/authenticate", [AccountController::class,"authenticate"])->name("account.authenticate");
    });

    // Authenticated Routes
    Route::group(['middleware' => 'auth'], function() {
        Route::GET('/profile', [AccountController::class,'profile'])->name('account.profile');
        Route::PUT('/update-profile', [AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::GET('/logout', [AccountController::class,'logout'])->name('account.logout');
        Route::POST('/update-profile-pic', [AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');
        Route::GET('/create-job', [AccountController::class,'createJob'])->name('account.createJob');
        Route::POST('/save-job', [AccountController::class,'saveJob'])->name('account.saveJob');
        Route::GET('/my-jobs',[AccountController::class,'myJob'])->name('account.myJob');
        Route::GET('/my-jobs/edit/{jobId}',[AccountController::class,'jobEdit'])->name('account.jobEdit');
        Route::POST('/update-job/{jobId}', [AccountController::class,'updateJob'])->name('account.updateJob');
        Route::POST('/delete-job', [AccountController::class,'deleteJob'])->name('account.deleteJob');
        Route::GET('/my-job-applications', [AccountController::class,'myJobApplications'])->name('account.myJobApplications');
        Route::POST('/remove-job-application', [AccountController::class,'removeJobs'])->name('account.removeJobs');

    });
    
});
