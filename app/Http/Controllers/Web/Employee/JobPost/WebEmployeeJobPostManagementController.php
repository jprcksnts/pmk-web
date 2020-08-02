<?php

namespace App\Http\Controllers\Web\Employee\JobPost;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\JobPost\JobPostController;
use App\Models\JobPost\JobPost;
use App\Models\JobPost\JobPostApplication;

class WebEmployeeJobPostManagementController extends Controller
{
    public function displayListPage()
    {
        if (request()->query('position') != null) {
            $job_posts = JobPost::with('jobPostApplications')
                ->where('position', 'like', '%' . request()->query('position') . '%')
                ->orderBy('created_at', 'desc')
                ->get();

        } else {
            $job_posts = JobPost::orderBy('created_at', 'desc')->get();
        }

        $job_applications = JobPostApplication::where('employee_id', auth()->user()->employee->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('employee.job_post.list_job_posts')
            ->with('job_posts', $job_posts)
            ->with('job_applications', $job_applications);
    }

    public function displayJobPostPage($job_post_id)
    {
        $job_post = JobPost::where('id', $job_post_id)->first();

        return view('employee.job_post.view_job_post')
            ->with('job_post', $job_post);
    }
}
