<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSessionCookieResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $cookies = $response->headers->getCookies();

        Log::info('Portfolio response cookie diagnostic', [
            'response_cookie_count' => count($cookies),
            'has_set_cookie_header' => $response->headers->has('Set-Cookie'),
        ]);

        $headersBeforeSend = headers_list();
        $cookieNamesBeforeSend = [];

        foreach ($headersBeforeSend as $header) {
            if (preg_match(
                '/^Set-Cookie:\s*([^=;]+)/i',
                $header,
                $matches
            )) {
                $cookieNamesBeforeSend[] = $matches[1];
            }
        }

        Log::info('Portfolio PHP headers before response return', [
            'sapi_header_count' => count($headersBeforeSend),
            'sapi_set_cookie_count' => count($cookieNamesBeforeSend),
            'sapi_cookie_names' => $cookieNamesBeforeSend,
            'headers_sent' => headers_sent(),
        ]);

        $registered = header_register_callback(
            static function (): void {
                $headersAtSend = headers_list();
                $cookieNamesAtSend = [];

                foreach ($headersAtSend as $header) {
                    if (preg_match(
                        '/^Set-Cookie:\s*([^=;]+)/i',
                        $header,
                        $matches
                    )) {
                        $cookieNamesAtSend[] = $matches[1];
                    }
                }

                Log::info('Portfolio PHP SAPI header callback executed', [
                    'sapi_header_count' => count($headersAtSend),
                    'sapi_set_cookie_count' => count($cookieNamesAtSend),
                    'sapi_cookie_names' => $cookieNamesAtSend,
                    'headers_sent' => headers_sent(),
                ]);
            }
        );

        Log::info('Portfolio PHP header callback registration', [
            'registered' => $registered,
        ]);

        return $response;
    }
}