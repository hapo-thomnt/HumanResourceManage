<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'report_date',
        'note',
    ];

    /**
     * Get the employee that report  belong to
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the task that this report has
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('spent_time');
    }
}
