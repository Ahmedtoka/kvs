<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'position', 'cv_path', 'status', 'notes',
    ];

    public const STATUSES = [
        'new'         => 'New',
        'reviewed'    => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'rejected'    => 'Rejected',
    ];
}
