<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type', 'parent_name', 'student_name', 'phone', 'email', 'child_age',
        'stage', 'year_group', 'preferred_date', 'message', 'status', 'source', 'notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public const STATUSES = [
        'new'         => 'New',
        'contacted'   => 'Contacted',
        'tour_booked' => 'Tour Booked',
        'toured'      => 'Toured',
        'applied'     => 'Applied',
        'enrolled'    => 'Enrolled',
        'lost'        => 'Lost',
    ];

    public const TYPES = [
        'callback' => 'Call Back',
        'tour'     => 'School Tour',
        'fees'     => 'Fees Request',
    ];
}
