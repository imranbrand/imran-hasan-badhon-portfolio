

@extends('layouts.app')

@section('title')
{{ $project['title'] }} | {{ config('portfolio.profile.name') }}
@endsection

@section('description', $project['tagline'])

@section('content')
    <section class="sec case-hero">
        <div class="wrap">
            <a class="back" href="{{ route('home') }}#work">
                &larr; All projects
            </a>

            <p class="label">{{ $project['kind'] }}</p>

            <h1 class="case-title">{{ $project['title'] }}</h1>

            <p class="lead">{{ $project['tagline'] }}</p>

            <dl class="case-meta">
                <div>
                    <dt>Role</dt>
                    <dd>{{ $project['role'] }}</dd>
                </div>

                <div>
                    <dt>Status</dt>
                    <dd>{{ $project['status'] }}</dd>
                </div>
            </dl>

            <div class="cta">
                @if (!empty($project['link']))
                    <a class="btn solid"
                       href="{{ $project['link'] }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        Live Demo &#8599;
                    </a>
                @endif

                @if (!empty($project['github']))
                    <a class="btn ghost"
                       href="{{ $project['github'] }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        GitHub &#8599;
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="sec">
        <div class="wrap case-body">
            <div class="case-mock rv">
                @if ($project['slug'] === 'ibl-cart-24')
                    @include('partials.mock-shop')
                @elseif ($project['slug'] === 'image-caption-generator')
                    @include('partials.mock-cnn')
                @elseif ($project['slug'] === 'dhukpuk-health-tracker')
                    @include('partials.mock-dhukpuk')
                @endif
            </div>

            <div class="rv">
                <h2>Overview</h2>

                <p class="muted big">{{ $project['summary'] }}</p>

                <ul class="chips">
                    @foreach ($project['stack'] as $tech)
                        <li>{{ $tech }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="sec">
        <div class="wrap">
            <div class="head rv">
                <p class="label">How it works</p>
                <h2>The flow.</h2>
            </div>

            <ol class="flow rv">
                @foreach ($project['flow'] as $step)
                    <li>
                        <b>{{ $step[0] }}</b>
                        <small>{{ $step[1] }}</small>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="sec">
        <div class="wrap">
            <div class="head rv">
                <p class="label">What is inside</p>
                <h2>Features and decisions.</h2>
            </div>

            <div class="grid2 rv">
                @foreach ($project['features'] as $feature)
                    <article class="card tilt">
                        <small>{{ $feature[0] }}</small>
                        <p>{{ $feature[1] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="sec">
        <div class="wrap">
            <div class="next rv">
                <div>
                    <p class="label">Explore other projects</p>

                    @foreach ($others as $other)
                        <h3>{{ $other['title'] }}</h3>
                        <p class="muted">{{ $other['tagline'] }}</p>
                    @endforeach
                </div>

                <div class="cta">
                    @foreach ($others as $other)
                        <a class="btn"
                           href="{{ route('project', ['slug' => $other['slug']]) }}">
                            {{ $other['title'] }}
                        </a>
                    @endforeach

                    <a class="btn solid" href="{{ route('home') }}#contact">
                        Work with me
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
