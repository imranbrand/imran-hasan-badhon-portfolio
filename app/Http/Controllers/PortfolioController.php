<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    public function home(Request $request): View
    {
        // Temporary diagnostic: never log session IDs or CSRF tokens.
        $hasSession = $request->hasSession();

        Log::info('Portfolio session diagnostic', [
            'session_driver' => config('session.driver'),
            'session_cookie_configured' => filled(config('session.cookie')),
            'request_has_session' => $hasSession,
            'session_started' => $hasSession
                ? $request->session()->isStarted()
                : false,
            'request_is_secure' => $request->isSecure(),
        ]);

        $p = config('portfolio');

        return view('pages.home', [
            'p'      => $p,
            'jsonLd' => $this->personJsonLd($p),
        ]);
    }

    public function project(string $slug): View
    {
        $p = config('portfolio');

        $project = collect($p['projects'])->firstWhere('slug', $slug);
        abort_if($project === null, 404);

        $others = collect($p['projects'])->where('slug', '!=', $slug)->values()->all();

        return view('pages.project', [
            'p'       => $p,
            'project' => $project,
            'others'  => $others,
            'jsonLd'  => $this->personJsonLd($p),
        ]);
    }

    public function cv(): RedirectResponse
    {
        return redirect(config('portfolio.profile.cv'));
    }

    private function personJsonLd(array $p): string
    {
        $profile = $p['profile'];

        return json_encode([
            '@context'   => 'https://schema.org',
            '@type'      => 'Person',
            'name'       => $profile['name'],
            'jobTitle'   => $profile['headline'],
            'url'        => url('/'),
            'image'      => asset($profile['photo']),
            'email'      => $profile['email'],
            'sameAs'     => array_column($profile['links'], 'url'),
            'alumniOf'   => ['@type' => 'CollegeOrUniversity', 'name' => 'Jagannath University'],
            'knowsAbout' => ['Laravel', 'PHP', 'Machine Learning', 'Computer Vision', 'E-commerce'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }
}

