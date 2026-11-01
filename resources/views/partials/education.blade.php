<section id="education" class="sec">
    <div class="wrap">
        <div class="head rv">
            <p class="label">Education</p>
            <h2>Academic background.</h2>
        </div>
        <div class="rows rv">
            @foreach ($p['education'] as $row)
                <article class="row">
                    <div class="k">{{ $row['when'] }}</div>
                    <div>
                        <h3>{{ $row['title'] }}</h3>
                        @if ($row['text'] !== '')
                            <p class="muted">{{ $row['text'] }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
