<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'customer_id',
        'description',
    ];

    /**
     * Get the company that customer work for
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the employee that  working in current project
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withPivot('start_date','end_date','role');
    }

    /**
     * Get the task in project
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
