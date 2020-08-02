<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    static $JOB_APPLICATION_NEW = 1;
    static $JOB_APPLICATION_UPDATE = 2;
    static $JOB_OFFER_RECEIVED = 3;
    static $JOB_OFFER_ACCEPTED = 4;
    static $JOB_OFFER_DECLINED = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
