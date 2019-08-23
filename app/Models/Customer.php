<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'company_id',
        'firstname',
        'lastname',
        'phone',
        'birthday',
        'avatar',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the company that customer work for
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the customers work in company.
     */
    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
