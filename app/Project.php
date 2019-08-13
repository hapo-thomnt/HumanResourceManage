<?php

namespace App;

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
        return $this->belongsTo('App\Customer');
    }
}
