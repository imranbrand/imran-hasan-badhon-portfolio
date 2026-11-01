<section id="about" class="sec">
    <div class="wrap about rv">
        <div>
            <p class="label">About</p>
            <h2>From CSE fundamentals to products that ship.</h2>
        </div>
        <div class="copy">
            @foreach ($p['profile']['about'] as $line)
                <p>{{ $line }}</p>
            @endforeach
            <dl class="mini">
                <div><dt>Languages</dt><dd>{{ $p['profile']['languages'] }}</dd></div>
                <div><dt>Location</dt><dd>{{ $p['profile']['location'] }}</dd></div>
                <div><dt>Contact</dt><dd>{{ $p['profile']['email'] }}</dd></div>
            </dl>
        </div>
    </div>
</section>
