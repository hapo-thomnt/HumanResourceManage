<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyAssign extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assign_id',
        'spent_time',
        'daily_report_id',
    ];
}
