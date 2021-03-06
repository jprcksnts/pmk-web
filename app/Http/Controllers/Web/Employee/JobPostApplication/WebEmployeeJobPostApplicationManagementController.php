<?php

namespace App\Http\Controllers\Web\Employee\JobPostApplication;

use App\Http\Controllers\Controller;
use App\Models\JobPost\JobPostApplication;

class WebEmployeeJobPostApplicationManagementController extends Controller
{
    public function displayListPage()
    {
        $employee_id = auth()->user()->employee->id;
        $job_post_applications = JobPostApplication::where('employee_id', $employee_id)
            // ->whereNotIn('job_post_application_status_id', array(JobPostApplicationStatus::$CANCELLED))
            ->get();

        return view('employee.job_post_application.list_job_post_applications')
            ->with('job_post_applications', $job_post_applications);
    }

    public function displayJobPostApplicationPage($job_post_application_id)
    {
        $job_post_application = JobPostApplication::where('id', $job_post_application_id)->first();

        return view('employee.job_post_application.view_job_post_application')
            ->with('job_post_application', $job_post_application);
    }
}
