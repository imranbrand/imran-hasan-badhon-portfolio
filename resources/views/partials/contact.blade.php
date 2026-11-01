<section id="contact" class="sec">
    <div class="wrap">
        <div class="contact rv">
            <div class="contact-info">
                <p class="label">Contact</p>
                <h2>Have a role or a project in mind? <em>Let&rsquo;s talk.</em></h2>
                <p class="sub">Tell me what you need and when. I read every message and reply by email.</p>

                <div class="mail">
                    <code id="mailText">{{ $p['profile']['email'] }}</code>
                    <button class="btn" id="copyMail" type="button">Copy</button>
                    <span class="note" id="copyNote" role="status" aria-live="polite"></span>
                </div>

                <nav class="social" aria-label="Profiles">
                    @foreach ($p['profile']['links'] as $link)
                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] }} &#8599;</a>
                    @endforeach
                    <a href="{{ route('cv') }}" target="_blank" rel="noopener">CV &#8599;</a>
                </nav>
            </div>

            <form class="form" method="POST" action="{{ route('contact.store') }}#contact" novalidate>
                @csrf

                @if (session('status'))
                    <p class="flash" role="status">{{ session('status') }}</p>
                @endif

                <div class="field">
                    <label for="name">Your name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="80" autocomplete="name" required>
                    @error('name')<p class="err">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="120" autocomplete="email" required>
                    @error('email')<p class="err">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="type">I am reaching out about</label>
                    <select id="type" name="type" required>
                        @foreach ($p['contact_types'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', 'job') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')<p class="err">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" maxlength="3000" required>{{ old('message') }}</textarea>
                    @error('message')<p class="err">{{ $message }}</p>@enderror
                </div>

                <div class="hp" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                <button class="btn solid wide" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>
