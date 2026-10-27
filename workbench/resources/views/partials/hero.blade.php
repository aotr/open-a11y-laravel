<header class="oa-hero">
    <div class="oa-hero__main">
        <p class="oa-kicker"><span>{{ $number }}</span> {{ $kicker }}</p>
        <h1>{!! $headline !!}</h1>
        <p class="oa-hero__lede">{{ $lede }}</p>
    </div>

    <aside class="oa-hero__aside" aria-label="About this demo">
        <p class="oa-aside-label">The demo</p>
        <p class="oa-aside-copy">
            Change the widget in place. Every control writes a new config; the runtime
            rebuilds the interface without touching the visitor's saved preferences.
        </p>
        <dl class="oa-spec">
            <div>
                <dt>Surface</dt>
                <dd>{{ $surface }}</dd>
            </div>
            <div>
                <dt>Runtime</dt>
                <dd>Web components</dd>
            </div>
            <div>
                <dt>State</dt>
                <dd>localStorage</dd>
            </div>
            <div>
                <dt>Bundle</dt>
                <dd>Standalone IIFE</dd>
            </div>
        </dl>
    </aside>
</header>
