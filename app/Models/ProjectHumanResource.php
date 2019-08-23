<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHumanResource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'employee_id',
        'start_date',
        'end_date',
        'role',
    ];
}
