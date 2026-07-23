<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Meta Conversions API (server-side) sender.
 *
 * Sends conversions straight from the server to Meta so they are counted even
 * when the browser Pixel is blocked. Each event carries an event_id that matches
 * the browser Pixel's eventID, so Meta de-duplicates the pair automatically.
 *
 * All failures are swallowed — a Graph API hiccup must never break a form submit.
 */
class MetaConversions
{
    private const GRAPH_VERSION = 'v21.0';

    public static function enabled(): bool
    {
        return filled(config('services.meta.pixel_id')) && filled(config('services.meta.capi_token'));
    }

    /**
     * Send a "Lead" conversion.
     *
     * @param array{email?:?string,phone?:?string,name?:?string,content_name?:?string,content_category?:?string} $params
     */
    public static function sendLead(Request $request, string $eventId, array $params = []): void
    {
        self::send($request, 'Lead', $eventId, $params);
    }

    public static function send(Request $request, string $eventName, string $eventId, array $params = []): void
    {
        if (! self::enabled()) {
            return;
        }

        try {
            $pixel = config('services.meta.pixel_id');
            $token = config('services.meta.capi_token');

            $userData = array_filter([
                'em'                => self::hash($params['email'] ?? null),
                'ph'                => self::hash(self::normalizePhone($params['phone'] ?? null)),
                'fn'                => self::hash($params['name'] ?? null),
                'client_ip_address' => $request->ip(),
                'client_user_agent' => $request->userAgent(),
                'fbp'               => $request->cookie('_fbp'),
                'fbc'               => self::fbc($request),
            ], fn ($v) => $v !== null && $v !== '' && $v !== []);

            $event = array_filter([
                'event_name'       => $eventName,
                'event_time'       => time(),
                'event_id'         => $eventId,
                'action_source'    => 'website',
                'event_source_url' => (string) url()->previous(),
                'user_data'        => $userData,
                'custom_data'      => array_filter([
                    'content_name'     => $params['content_name'] ?? null,
                    'content_category' => $params['content_category'] ?? null,
                ], fn ($v) => $v !== null && $v !== ''),
            ], fn ($v) => $v !== null && $v !== '' && $v !== []);

            $payload = ['data' => [$event]];
            if ($code = config('services.meta.test_event_code')) {
                $payload['test_event_code'] = $code;
            }

            Http::timeout(4)->post(
                'https://graph.facebook.com/' . self::GRAPH_VERSION . '/' . $pixel . '/events?access_token=' . $token,
                $payload
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /** SHA-256 of a normalised (lower-cased, trimmed) value, or null. */
    private static function hash(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }
        $value = strtolower(trim($value));
        if ($value === '') {
            return null;
        }

        return [hash('sha256', $value)];
    }

    /** Egyptian local 01XXXXXXXXX -> E.164 20XXXXXXXXXX; strips non-digits. */
    private static function normalizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }
        $digits = preg_replace('/\D+/', '', $phone);
        if ($digits === '') {
            return null;
        }
        if (strlen($digits) === 11 && str_starts_with($digits, '01')) {
            $digits = '20' . substr($digits, 1);
        }

        return $digits;
    }

    /** Meta click-id cookie, or reconstructed from an fbclid query param. */
    private static function fbc(Request $request): ?string
    {
        $fbc = $request->cookie('_fbc');
        if (is_string($fbc) && $fbc !== '') {
            return $fbc;
        }
        $fbclid = $request->query('fbclid');
        if (is_string($fbclid) && $fbclid !== '') {
            return 'fb.1.' . (int) (microtime(true) * 1000) . '.' . $fbclid;
        }

        return null;
    }
}
