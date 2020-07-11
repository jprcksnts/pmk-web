<?php

namespace App\Models\JobOffer;

use App\Models\Employee\Employee;
use App\Models\JobPost\JobPostApplication;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_offer_status_id', 'job_post_application_id', 'job_post_id', 'company_id', 'employer_id', 'employee_id', 'description', 'date_due',
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

    public function jobOfferStatus()
    {
        return $this->belongsTo(JobOfferStatus::class);
    }

    public function jobPostApplication()
    {
        return $this->belongsTo(JobPostApplication::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}