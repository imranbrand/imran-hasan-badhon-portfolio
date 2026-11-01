<section id="services" class="sec">
    <div class="wrap">
        <div class="head rv">
            <p class="label">Work with me</p>
            <h2>Hire me for a role, or for a project.</h2>
            <p class="sub">Whether you need a developer on your team or a product built end to end, these are the areas where I can start on day one.</p>
        </div>
        <div class="grid4 rv">
            @foreach ($p['services'] as $service)
                <article class="card tilt">
                    <small>{{ $service['code'] }}</small>
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
