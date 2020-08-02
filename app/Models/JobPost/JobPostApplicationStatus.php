<?php

namespace App\Models\JobPost;

use Illuminate\Database\Eloquent\Model;

class JobPostApplicationStatus extends Model
{
    // job application submitted by employee
    public static $PENDING = 1;
    // job application is cancelled by employee
    public static $CANCELLED = 6;

    // job application status put under review by employer
    public static $UNDER_REVIEW = 2;

    // if accepted or rejected by employee
    public static $HIRED = 4;
    public static $REJECTED = 5;

    // job offer is sent or retracted by employer
    public static $SENT_JOB_OFFER = 3;
    public static $RETRACTED_JOB_OFFER = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
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

    public function jobPostApplications()
    {
        return $this->hasMany(JobPostApplication::class);
    }
}
