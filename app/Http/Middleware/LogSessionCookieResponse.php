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

        return $response;
    }
}
