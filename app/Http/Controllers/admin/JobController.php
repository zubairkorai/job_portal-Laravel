<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $jobs = Job::orderBy('created_at', 'DESC')->with('user', 'applications')->paginate(10);
        return view('admin.jobs.list', [
            'jobs' => $jobs,
        ]);
    }

    public function destroy(Request $request){
        $id = $request->id;

        $job = Job::find($id);

        if($job == null) {
            session()->flash('error', 'Either job deleted or not found');
            return response()->json([
                "status" => false,
            ]);
        }

        $job->delete();
        session()->flash('success', 'Job deleted Successfully.');
        return response()->json([
            'status' => true,
        ]);

    }
}
