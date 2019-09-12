<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
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
        'is'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'fullname',
        'type',
    ];
    /**
     * Get the company that customer work for
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function isCustomer()
    {
        return true;
    }

    /**
     * Get the customers work in company.
     */
    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function getFullnameAttribute()
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function getTypeAttribute()
    {
        return 'customer';
    }
}
