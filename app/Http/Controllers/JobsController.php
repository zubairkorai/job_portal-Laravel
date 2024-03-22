<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Job;
use App\Models\jobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    // This method will show jobs page
    public function index() {

        $categories = category::where("status",1)->get();
        $jobTypes = jobType::where("status",1)->get();

        $jobs = Job::where("status",1)->with("jobType")->orderBy("created_at", "DESC")->paginate(6);

        return view("front.jobs", [
            "categories"=> $categories,
            "jobTypes"=> $jobTypes,
            "jobs"=> $jobs
        ]);
    }
}
