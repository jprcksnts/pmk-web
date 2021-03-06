<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'skill',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
