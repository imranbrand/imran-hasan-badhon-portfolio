<section id="home" class="hero">
    <div class="wrap hero-grid">
        <div class="hero-copy">
            @if ($p['profile']['available'])
                <p class="status"><i></i>{{ $p['profile']['status'] }}</p>
            @endif
            <h1>{{ $p['profile']['name_first'] }} <em>{{ $p['profile']['name_last'] }}</em></h1>
            <p class="headline">{{ $p['profile']['headline'] }}</p>
            <p class="roleline">
                @foreach ($p['profile']['roles'] as $role)
                    <span>{{ $role }}</span>
                @endforeach
            </p>
            <p class="lead">{{ $p['profile']['lead'] }}</p>
            <div class="cta">
                <a class="btn solid" href="#contact" data-type="job">Hire me</a>
                <a class="btn" href="#contact" data-type="freelance">Start a project</a>
                <a class="btn ghost" href="{{ route('cv') }}" target="_blank" rel="noopener">Download CV &#8599;</a>
            </div>
            <dl class="facts">
                @foreach ($p['facts'] as $fact)
                    <div><dt>{{ $fact['label'] }}</dt><dd>{{ $fact['value'] }}</dd></div>
                @endforeach
            </dl>
        </div>

        <div class="stage" id="stage">
            <div class="glow" aria-hidden="true"></div>
            <div class="card3d" id="card3d">
                <div class="plate" aria-hidden="true"></div>
                <div class="frame">
                    <img class="photo" id="photo" src="{{ asset($p['profile']['photo']) }}" alt="Portrait of {{ $p['profile']['name'] }}" width="1086" height="1448" fetchpriority="high">
                </div>
                <div class="float a" aria-hidden="true"><small>Now building</small><b>IBL CART 24</b></div>
                <div class="float b" aria-hidden="true"><small>Research</small><b>CNN-LSTM captions</b></div>
            </div>
            <div class="orbit" id="orbit" aria-hidden="true">
                @foreach ($p['stack_strip'] as $tag)
                    <span class="otag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
