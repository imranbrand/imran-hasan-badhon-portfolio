<section id="skills" class="sec">
    <div class="wrap">
        <div class="head rv">
            <p class="label">Skills</p>
            <h2>The tools behind the work.</h2>
        </div>
        <div class="grid3 rv">
            @foreach ($p['skills'] as $group)
                <article class="card tilt">
                    <small>{{ $group['group'] }}</small>
                    <ul class="chips">
                        @foreach ($group['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </div>
</section>
