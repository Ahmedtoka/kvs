<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public const GROUPS = [
        'contact'      => 'Contact Details',
        'social'       => 'Social Media',
        'integrations' => 'Integrations',
    ];

    public const LABELS = [
        'phone_admissions' => 'Admissions phone',
        'phone_school'     => 'School phone(s)',
        'whatsapp_number'  => 'WhatsApp number (with country code, e.g. 2010…)',
        'email_info'       => 'General email',
        'email_admission'  => 'Admissions email',
        'address'          => 'Address',
        'working_hours'    => 'Working hours',
        'social_facebook'  => 'Facebook URL',
        'social_instagram' => 'Instagram URL',
        'social_linkedin'  => 'LinkedIn URL',
        'ga4_id'           => 'Google Analytics 4 ID (G-XXXXXXX)',
    ];
}
