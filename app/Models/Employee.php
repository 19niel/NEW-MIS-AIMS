<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'department',
        'position',
        'email',
        'contact_number',
        'date_hired',
        'date_separated',
        'employment_status',
        'remarks',
        'location',
        'accountability_form'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }
}
