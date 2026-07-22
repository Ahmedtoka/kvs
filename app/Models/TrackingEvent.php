<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'visitor_id', 'session_id', 'event', 'page', 'label',
        'referrer', 'utm_source', 'utm_medium', 'utm_campaign', 'device',
    ];

    /**
     * Client-side events accepted by the /track endpoint.
     *
     * @var list<string>
     */
    public const CLIENT_EVENTS = [
        'cta_click',        // any [data-track] CTA button
        'see_all_click',    // "See All" section links
        'form_view',        // lead form scrolled into view
        'form_submit',      // lead form submitted (client-side)
        'whatsapp_click',   // wa.me link
        'call_click',       // tel: link
        'scroll_75',        // reached 75% of the page
        'nav_click',        // main navigation click
    ];

    /**
     * Classify a User-Agent string into desktop | mobile | tablet.
     */
    public static function deviceFrom(?string $ua): string
    {
        $ua = (string) $ua;

        if (preg_match('/iPad|Tablet|PlayBook|Silk|Kindle/i', $ua) || preg_match('/Android(?!.*Mobile)/i', $ua)) {
            return 'tablet';
        }

        if (preg_match('/Mobile|Android|iPhone|iPod|BlackBerry|Opera Mini|IEMobile/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }
}
