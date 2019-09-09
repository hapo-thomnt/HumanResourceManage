<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'employee_id',
        'code',
        'name',
        'description',
        'status',
    ];

    /**
     * Get the company that customer work for
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the employee that  working in current project
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the report that  this task is assigned
     */
    public function reports()
    {
        return $this->belongsToMany(Report::class)->withPivot('spent_time');
    }
}
