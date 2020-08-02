<?php

namespace App\Models\JobPost;

use App\Models\Employer\Employer;
use App\Models\JobOffer\JobOffer;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employer_id', 'job_post_status_id', 'position', 'description', 'max_applicants', 'approved_applicants',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobPostStatus()
    {
        return $this->belongsTo(JobPostStatus::class);
    }

    public function jobPostApplications()
    {
        return $this->hasMany(JobPostApplication::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function hasApplication($employee_id)
    {
        $job_post_applications = JobPostApplication::where('job_post_id', $this->id)->get();

        foreach ($job_post_applications as $job_post_application) {
            if ($job_post_application->employee_id == $employee_id)
                return true;
        }

        return false;
    }

    public function allowsApplication()
    {
        $job_post_applications_count = JobPostApplication::where('job_post_id', $this->id)
            ->whereNotIn('job_post_application_status_id', [JobPostApplicationStatus::$CANCELLED, JobPostApplicationStatus::$REJECTED, JobPostApplicationStatus::$RETRACTED_JOB_OFFER])
            ->count();

        return ($this->max_applicants > $job_post_applications_count) ? true : false;
    }
}
