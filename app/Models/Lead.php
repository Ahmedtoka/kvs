<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type', 'parent_name', 'student_name', 'phone', 'email', 'child_age',
        'stage', 'year_group', 'preferred_date', 'message', 'status', 'source', 'notes', 'assigned_to',
        'follow_up_at', 'tour_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'follow_up_at'   => 'datetime',
        'tour_at'        => 'datetime',
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

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }
}
