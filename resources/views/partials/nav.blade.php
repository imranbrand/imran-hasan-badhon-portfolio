<header class="bar">
    <div class="bar-in">
        <a class="logo" href="{{ route('home') }}" aria-label="{{ $p['profile']['name'] }}, home">
            <span class="mark" aria-hidden="true">IH</span>{{ $p['profile']['name'] }}
        </a>
        <nav class="nav" aria-label="Sections">
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('home') }}#services">Services</a>
            <a href="{{ route('home') }}#work">Work</a>
            <a href="{{ route('home') }}#lab">Vision Lab</a>
            <a href="{{ route('home') }}#skills">Skills</a>
        </nav>
        <a class="pill" href="{{ route('home') }}#contact">Hire me</a>
    </div>
</header>
