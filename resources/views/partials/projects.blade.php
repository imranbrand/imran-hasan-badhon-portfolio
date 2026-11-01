
<section id="work" class="sec">
    <div class="wrap">
        <div class="head rv">
            <p class="label">Selected work</p>
            <h2>Three projects, three kinds of problems.</h2>
            <p class="sub">
                E-commerce engineering, deep learning research and a Bengali-first family wellness application.
            </p>
        </div>

        @foreach ($p['projects'] as $project)
            <article class="feature rv {{ $loop->iteration % 2 === 0 ? 'flip' : '' }}">
                <div class="mock-wrap">
                    @if ($project['slug'] === 'ibl-cart-24')
                        @include('partials.mock-shop')
                    @elseif ($project['slug'] === 'image-caption-generator')
                        @include('partials.mock-cnn')
                    @elseif ($project['slug'] === 'dhukpuk-health-tracker')
                        @include('partials.mock-dhukpuk')
                    @endif
                </div>

                <div class="feature-copy">
                    <p class="kind">{{ $project['kind'] }}</p>

                    <h3>{{ $project['title'] }}</h3>

                    <p class="tagline">{{ $project['tagline'] }}</p>

                    <p class="muted">{{ $project['summary'] }}</p>

                    <ul class="chips">
                        @foreach ($project['stack'] as $tech)
                            <li>{{ $tech }}</li>
                        @endforeach
                    </ul>

                    <p class="statusline">
                        <b>Status</b> {{ $project['status'] }}
                    </p>

                    <div class="cta">
                        <a class="btn solid"
                           href="{{ route('project', ['slug' => $project['slug']]) }}">
                            Read the case study
                        </a>

                        @if (!empty($project['link']))
                            <a class="btn ghost"
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
            </article>
        @endforeach
    </div>
</section>

