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

    /**
     * Is this User-Agent a bot / crawler / link-preview fetcher / uptime monitor?
     *
     * These must NOT be counted as real visitors — otherwise every Google,
     * Facebook, WhatsApp-preview or crawler hit inflates the visitor numbers
     * (bots don't keep cookies, so each hit looks like a brand-new visitor).
     */
    public static function isBot(?string $ua): bool
    {
        $ua = trim((string) $ua);

        // Empty or absurdly short UA strings are almost always automated.
        if ($ua === '' || strlen($ua) < 12) {
            return true;
        }

        return (bool) preg_match(
            '/bot\b|crawl|spider|slurp|mediapartners|facebookexternalhit|facebookcatalog|'
            . 'whatsapp|telegram|telegrambot|slackbot|discordbot|twitterbot|linkedinbot|'
            . 'pinterest|redditbot|embedly|quora|vkshare|w3c_validator|'
            . 'googlebot|bingbot|yandex|baidu|duckduckbot|applebot|petalbot|sogou|exabot|'
            . 'ahrefs|semrush|mj12bot|dotbot|dataforseo|screaming ?frog|serpstat|'
            . 'gptbot|claudebot|claude-web|anthropic|ccbot|chatgpt|oai-searchbot|perplexitybot|'
            . 'bytespider|amazonbot|meta-externalagent|google-inspectiontool|'
            . 'headlesschrome|phantomjs|puppeteer|playwright|selenium|'
            . 'python-requests|python-urllib|aiohttp|httpx|go-http-client|okhttp|java\/|libwww|'
            . 'curl\/|wget\/|node-fetch|axios\/|guzzle|apache-httpclient|'
            . 'uptimerobot|pingdom|statuscake|site24x7|newrelic|datadog|monitor|'
            . 'lighthouse|gtmetrix|pagespeed|checkly|prerender/i',
            $ua
        );
    }
}
