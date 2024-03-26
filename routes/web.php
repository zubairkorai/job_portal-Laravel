<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;


Route::GET("/", [HomeController::class,"index"])->name("home");
Route::GET("/jobs", [JobsController::class,"index"])->name("jobs");
Route::GET("/jobs/detail/{id}", [JobsController::class,"detail"])->name("jobDetail");
Route::POST("/apply-job", [JobsController::class,"applyJob"])->name("applyJob");
Route::POST("/saved-job", [JobsController::class,"saveJob"])->name("saveJob");
Route::GET("/forgot-password", [AccountController::class,"forgotPassword"])->name("account.forgotPassword");
Route::POST("/process-forgot-password", [AccountController::class,"processForgotPassword"])->name("account.processForgotPassword");
Route::GET("/reset-password/{token}", [AccountController::class,"resetPassword"])->name("account.resetPassword");
Route::POST("/process-reset-password", [AccountController::class,"processResetPassword"])->name("account.processResetPassword");

Route::GROUP(['prefix' => 'admin', 'middleware' => 'checkRole'], function () {
        Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
        Route::get('/users', [UserController::class,'index'])->name('admin.users');
});

Route::GROUP(['account'], function() {

    // Guest Route
    Route::GROUP(['middleware' => 'guest'], function() {
        Route::GET("/register", [AccountController::class,"registration"])->name("account.registration");
        Route::POST("/process-register", [AccountController::class,"processRegistration"])->name("account.processRegistration");
        Route::GET("/login", [AccountController::class,"login"])->name("account.login");
        Route::POST("/authenticate", [AccountController::class,"authenticate"])->name("account.authenticate");
    });

    // Authenticated Routes
    Route::GROUP(['middleware' => 'auth'], function() {
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
        Route::POST('/remove-job-application', [AccountController::class,'removeJob'])->name('account.removeJob');
        Route::GET('/saved-job', [AccountController::class,'savedJobs'])->name('account.savedJobs');
        Route::POST('/remove-saved-job', [AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');
        Route::POST('/update-password', [AccountController::class,'updatePassword'])->name('account.updatePassword');

    });
    
});
