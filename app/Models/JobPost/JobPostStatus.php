<?php

namespace App\Models\JobPost;

use Illuminate\Database\Eloquent\Model;

class JobPostStatus extends Model
{
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

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
}
