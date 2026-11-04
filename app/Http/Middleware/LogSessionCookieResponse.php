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
            'response_has_cookies' => count($cookies) > 0,
            'response_cookie_count' => count($cookies),
            'has_set_cookie_header' => $response->headers->has('Set-Cookie'),
        ]);

        $registered = header_register_callback(
            static function (): void {
                $headers = headers_list();
                $cookieNames = [];
                $cookieCount = 0;

                foreach ($headers as $header) {
                    if (preg_match(
                        '/^Set-Cookie:\s*([^=;]+)/i',
                        $header,
                        $matches
                    )) {
                        $cookieCount++;
                        $cookieNames[] = $matches[1];
                    }
                }

                Log::info('Portfolio PHP SAPI header diagnostic', [
                    'sapi_header_count' => count($headers),
                    'sapi_set_cookie_count' => $cookieCount,
                    'sapi_cookie_names' => $cookieNames,
                ]);
            }
        );

        Log::info('Portfolio PHP header callback registration', [
            'registered' => $registered,
        ]);

        return $response;
    }
}
