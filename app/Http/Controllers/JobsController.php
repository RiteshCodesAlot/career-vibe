<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;
use Illuminate\Support\Facades\Log;


class JobsController extends Controller
{
    // This method will show jobs page
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // Search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title', 'like', '%'.$request->keyword.'%');
                $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }

        // Search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // Search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Search using Job Type
        if (!empty($request->job_type)) {
            $jobTypeArray = $request->job_type;
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // Search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with(['jobType', 'category'])->orderBy('created_at', 'DESC')->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
        ]);

    }   

    
    // This method will show job detail page
        public function detail($id) {

            $job = Job::where(['id' => $id,
                                'status' => 1 
                            ])->with(['jobType', 'category'])->first();


            if (empty($job)) {
                abort(404);            
            }

            $count = 0;
            if (Auth::user()) {
                $count = SavedJob::where([
                    'user_id' => Auth::user()->id,
                    'job_id' => $id
                ])->count();
            }

            //Fetch Applications

            $applications = JobApplication::where('job_id', $id)->with('user')->get();

            return view('front.jobDetail',['job' => $job,
                                             'count' => $count, 
                                             'applications' => $applications]);
        }
    
        public function applyJob(Request $request) {
            $id = $request->id;
        
            $job = Job::where('id', $id)->first();
        
            // If job not found in DB
            if (empty($job)) {
                return response()->json([
                    'status' => false,
                    'message'=> 'Job does not exist'
                ]);
            }
        
            // You can't apply on your own job
            $employer_id = $job->user_id;
        
            if ($employer_id == Auth::user()->id) {
                return response()->json([
                    'status' => false,
                    'message'=> 'You cannot apply for your own job'
                ]);
            }
        
            // You cannot apply for a job twice
            $jobApplicationCount = JobApplication::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
        
            if ($jobApplicationCount > 0) {
                return response()->json([
                    'status' => false,
                    'message'=> 'You already applied for this job'
                ]);
            }
        
            // Save the job application
            $application = new JobApplication();
            $application->job_id = $id;
            $application->user_id = Auth::user()->id;
            $application->employer_id = $employer_id;
            $application->applied_date = now();
            $application->save();
        
            // Send Notification Email to Employer
            $employer = User::where('id', $employer_id)->first();
            $mailData = [
                'employer' => $employer,
                'user' => Auth::user(),
                'job' => $job,
            ];
        
            Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        
            return response()->json([
                'status' => true,
                'message'=> 'You have successfully applied'
            ]);
        }
        

        public function saveJob(Request $request)
        {
            $id = $request->input('job_id');
    
            $job = Job::find($id);
    
            if ($job == null) {
                return redirect()->back()->with('error', 'Job not found');
            }
    
            // Check if the user has already saved this job
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
    
            if ($count > 0) {
                return redirect()->back()->with('error', 'You have already saved this job.');
            }
    
            // Save the job
            $savedJob = new SavedJob;
            $savedJob->job_id = $id;
            $savedJob->user_id = Auth::user()->id;
            $savedJob->save();
    
            return redirect()->back()->with('success', 'Job saved successfully.');
        }
        
        
        
}
