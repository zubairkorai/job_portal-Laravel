<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Job;
use App\Models\jobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    // This method will show jobs page
    public function index(Request $request) {

        $categories = category::where("status",1)->get();
        $jobTypes = jobType::where("status",1)->get();

        $jobs = Job::where("status",1);
        
        // Search using keyword
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere("name","like","%".$request->keyword."%");
                $query->orWhere("keywords","like","%".$request->keyword."%");
            });
        }

        // Search using location
        if(!empty($request->location)){
            $jobs = $jobs->where("location", $request->location);
        }

        // Search using category
        if(!empty($request->category)){
            $jobs = $jobs->where("category_id", $request->category);
        }

        $jobTypeArray = [];
        // Search using jobType
        if(!empty($request->jobType)){
            $jobTypeArray = explode(',',$request->jobType);
            $jobs = $jobs->whereIn("job_type_id", $jobTypeArray);
        }

        // Search using experience
        if(!empty($request->experience)){
            $jobs = $jobs->where("experience", $request->experience);
        }

        $jobs = $jobs->with(["jobType","category"]);

        if($request->sort == '0'){
            $jobs = $jobs->orderBy("created_at", "ASC");
        } else {
            $jobs = $jobs->orderBy("created_at","DESC");
        }

        $jobs = $jobs->paginate(6);

        return view("front.jobs", [
            "categories"=> $categories,
            "jobTypes"=> $jobTypes,
            "jobs"=> $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id){

        $job = Job::where(['id' => $id, 'status'=> 1])->with(['jobType', 'category'])->first();

        if(empty($job)){
            return redirect('404');
        }

        return view('front.jobDetail',['job' => $job]);
    }

}
