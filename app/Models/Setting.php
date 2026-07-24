<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public const GROUPS = [
        'contact'      => 'Contact Details',
        'social'       => 'Social Media',
        'integrations' => 'Tracking & Integrations',
    ];

    /** Short description shown under each group heading. */
    public const GROUP_HELP = [
        'contact'      => 'Phone numbers, emails and address shown across the website.',
        'social'       => 'Links to your official social profiles.',
        'integrations' => 'Advertising & analytics IDs. Paste the ID only — the code is wired for you. Leave blank to disable a platform.',
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
        'ga4_id'           => 'Google Analytics 4 ID',
        'google_ads_id'    => 'Google Ads ID',
        'google_ads_label' => 'Google Ads Conversion Label',
        'meta_pixel_id'    => 'Meta / Facebook Pixel ID',
        'tiktok_pixel_id'  => 'TikTok Pixel ID',
    ];

    /** Optional per-field hint shown under the input. */
    public const HELP = [
        'ga4_id'           => 'Format: G-XXXXXXXXXX — from Google Analytics → Admin → Data streams.',
        'google_ads_id'    => 'Format: AW-XXXXXXXXX — from Google Ads → Goals → Conversions.',
        'google_ads_label' => 'The conversion label paired with the Google Ads ID above.',
        'meta_pixel_id'    => 'A 15–16 digit number from Meta Events Manager → Data sources.',
        'tiktok_pixel_id'  => 'From TikTok Ads Manager → Assets → Events.',
        'whatsapp_number'  => 'Digits only, including country code. Used for the floating WhatsApp button.',
    ];
}
