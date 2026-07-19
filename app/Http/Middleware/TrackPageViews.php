<?php

namespace App\Http\Middleware;

use App\Models\TrackingEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Records a server-side "pageview" for every public GET page and ensures
 * every visitor carries an anonymous visitor_id cookie (1 year).
 */
class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $visitorId = $request->cookie('kvs_vid');
        $isNew = false;

        if (! is_string($visitorId) || strlen($visitorId) !== 36) {
            $visitorId = (string) Str::uuid();
            $isNew = true;
        }

        // Make the id available to the request lifecycle (views, /track fallback).
        $request->attributes->set('kvs_visitor_id', $visitorId);

        $response = $next($request);

        if ($isNew) {
            $response->headers->setCookie(
                Cookie::create('kvs_vid', $visitorId)
                    ->withExpires(now()->addYear())
                    ->withPath('/')
                    ->withSecure($request->isSecure())
                    ->withHttpOnly(false) // JS tracker reads it
                    ->withSameSite('lax'),
            );
        }

        if ($this->shouldTrack($request, $response)) {
            try {
                TrackingEvent::create([
                    'visitor_id'   => $visitorId,
                    'session_id'   => $request->hasSession() ? $request->session()->getId() : null,
                    'event'        => 'pageview',
                    'page'         => '/' . ltrim($request->path() === '/' ? '/' : $request->path(), '/'),
                    'label'        => null,
                    'referrer'     => Str::limit((string) $request->headers->get('referer'), 180, ''),
                    'utm_source'   => Str::limit((string) $request->query('utm_source'), 90, '') ?: null,
                    'utm_medium'   => Str::limit((string) $request->query('utm_medium'), 90, '') ?: null,
                    'utm_campaign' => Str::limit((string) $request->query('utm_campaign'), 90, '') ?: null,
                    'device'       => preg_match('/Mobile|Android|iPhone/i', (string) $request->userAgent()) ? 'mobile' : 'desktop',
                ]);
            } catch (\Throwable $e) {
                report($e); // Tracking must never break the page.
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        return $request->isMethod('GET')
            && $response->getStatusCode() === 200
            && ! $request->is('admin', 'admin/*', 'track', 'up', 'build/*', 'images/*', 'favicon.ico');
    }
}
