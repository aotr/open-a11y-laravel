@extends('workbench::layout')

@section('title', 'Blade component')
@section('page', 'blade')

@section('content')
    @include('workbench::partials.hero', [
        'number' => '01',
        'kicker' => 'Blade component',
        'headline' => 'Accessibility,<br><em>editorially</em> considered.',
        'lede' => 'A single Blade tag mounts the open-a11y widget. Pass a config array, publish one bundle, and let the page keep its own voice.',
        'surface' => 'Blade',
    ])

    <section class="oa-workbench" aria-labelledby="blade-demo-title">
        <div class="oa-explainer">
            <p class="oa-kicker">The component</p>
            <h2 id="blade-demo-title">The config is the component.</h2>
            <p class="oa-lede">
                The widget is a set of web components loaded once by the package.
                Blade only supplies a mount point and a JSON config; the interface
                itself is isolated inside a shadow root.
            </p>

            <ol class="oa-notes">
                <li>
                    <strong>Publish once.</strong>
                    Copy the browser bundle with
                    <code>vendor:publish --tag=open-a11y-assets</code>.
                </li>
                <li>
                    <strong>Pass only what changes.</strong>
                    Defaults live in <code>config/open-a11y.php</code>; the component
                    merges your array over them.
                </li>
                <li>
                    <strong>State survives.</strong>
                    Tool preferences and language persist in localStorage, even when
                    the widget is remounted with a new config.
                </li>
            </ol>

            <div class="oa-snippet">
                <div class="oa-snippet__head">
                    <span>Blade</span>
                    <span>resources/views</span>
                </div>
                <pre><code>&lt;x-open-a11y::widget
    :config="[
        'position' =&gt; 'bottom-right',
        'blur' =&gt; true,
        'brand' =&gt; ['primary' =&gt; '#0f6b4f'],
    ]"
/&gt;</code></pre>
            </div>

            <div class="oa-snippet oa-snippet--state">
                <div class="oa-snippet__head">
                    <span>Current config</span>
                    <span id="customizer-status">Loaded from server</span>
                </div>
                <pre id="config-preview" class="oa-code" aria-live="polite">{{ json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
        </div>

        <aside class="oa-panel" aria-labelledby="customizer-title">
            <header class="oa-panel__head">
                <p class="oa-kicker">Live customizer</p>
                <h2 id="customizer-title">Shape the widget.</h2>
                <p class="oa-panel__hint">Every change remounts the widget and keeps its state.</p>
            </header>

            <form id="blade-customizer" class="oa-form">
                <div class="oa-field">
                    <label for="oa-position">Position</label>
                    <select id="oa-position" name="position">
                        @foreach (['bottom-right' => 'Bottom right', 'bottom-left' => 'Bottom left', 'top-right' => 'Top right', 'top-left' => 'Top left'] as $value => $label)
                            <option value="{{ $value }}" @selected($config['position'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="oa-field">
                    <label for="oa-side">Panel side</label>
                    <select id="oa-side" name="side">
                        <option value="right" @selected($config['side'] === 'right')>Right</option>
                        <option value="left" @selected($config['side'] === 'left')>Left</option>
                    </select>
                </div>

                <div class="oa-field">
                    <span class="oa-label">Offset <span class="oa-label__hint">pixels from the edge</span></span>
                    <div class="oa-split">
                        <label class="oa-mini" for="oa-offset-x">
                            <span>X</span>
                            <input id="oa-offset-x" type="number" name="offsetX" min="0" max="120" value="{{ $config['offset'][0] }}">
                        </label>
                        <label class="oa-mini" for="oa-offset-y">
                            <span>Y</span>
                            <input id="oa-offset-y" type="number" name="offsetY" min="0" max="120" value="{{ $config['offset'][1] }}">
                        </label>
                    </div>
                </div>

                <div class="oa-field">
                    <label for="oa-size">Button size <output id="oa-size-value" for="oa-size">{{ $config['buttonSize'] }} px</output></label>
                    <input id="oa-size" type="range" name="buttonSize" min="40" max="80" step="2" value="{{ $config['buttonSize'] }}">
                </div>

                <div class="oa-field oa-field--colors">
                    <label for="oa-primary">Primary</label>
                    <div class="oa-color">
                        <input id="oa-primary" type="color" name="primary" value="{{ $config['brand']['primary'] }}">
                        <span class="oa-color__value">{{ $config['brand']['primary'] }}</span>
                    </div>
                    <label for="oa-accent">Accent</label>
                    <div class="oa-color">
                        <input id="oa-accent" type="color" name="accent" value="{{ $config['brand']['accent'] }}">
                        <span class="oa-color__value">{{ $config['brand']['accent'] }}</span>
                    </div>
                </div>

                <div class="oa-field">
                    <label for="oa-menu-title">Menu title</label>
                    <input id="oa-menu-title" type="text" name="menuTitle" value="{{ $config['labels']['widget.menuTitle'] }}">
                </div>

                <div class="oa-field">
                    <label for="oa-footer-name">Footer name</label>
                    <input id="oa-footer-name" type="text" name="footerName" value="{{ $config['brand']['name'] }}">
                </div>

                <div class="oa-field">
                    <label for="oa-footer-url">Footer URL</label>
                    <input id="oa-footer-url" type="url" name="footerUrl" value="{{ $config['brand']['url'] }}">
                </div>

                <div class="oa-field">
                    <label for="oa-footer-text">Footer text</label>
                    <input id="oa-footer-text" type="text" name="footerText" value="{{ $config['brand']['footerText'] }}">
                </div>

                <div class="oa-field">
                    <label for="oa-language">Language</label>
                    <select id="oa-language" name="language">
                        <option value="en" @selected($config['lang'] === 'en')>English</option>
                        <option value="hi" @selected($config['lang'] === 'hi')>हिन्दी (Hindi)</option>
                    </select>
                </div>

                <div class="oa-toggles">
                    <label class="oa-toggle" for="oa-blur">
                        <input id="oa-blur" type="checkbox" name="blur" @checked($config['blur'])>
                        <span class="oa-toggle__track" aria-hidden="true"></span>
                        <span>Soften the page behind the panel</span>
                    </label>

                    <label class="oa-toggle" for="oa-show-button">
                        <input id="oa-show-button" type="checkbox" name="showButton" @checked($config['showButton'])>
                        <span class="oa-toggle__track" aria-hidden="true"></span>
                        <span>Keep the floating button visible</span>
                    </label>
                </div>

                <div class="oa-form__foot">
                    <button type="reset" class="oa-button oa-button--quiet">Restore defaults</button>
                </div>
            </form>
        </aside>
    </section>

    <x-open-a11y::widget :config="$config" widget-key="blade-demo" />
@endsection

@push('scripts')
    <script>
        (function () {
            var form = document.getElementById('blade-customizer');
            var preview = document.getElementById('config-preview');
            var status = document.getElementById('customizer-status');
            var mount = document.querySelector('[data-open-a11y]');
            var sizeOutput = document.getElementById('oa-size-value');
            var colorOutputs = document.querySelectorAll('.oa-color__value');

            if (!form || !preview || !mount) {
                return;
            }

            var key = mount.getAttribute('data-open-a11y');

            function currentConfig() {
                var data = new FormData(form);

                return {
                    position: data.get('position'),
                    side: data.get('side'),
                    offset: [Number(data.get('offsetX')), Number(data.get('offsetY'))],
                    blur: data.get('blur') === 'on',
                    buttonSize: Number(data.get('buttonSize')),
                    showButton: data.get('showButton') === 'on',
                    lang: data.get('language'),
                    brand: {
                        name: data.get('footerName'),
                        url: data.get('footerUrl'),
                        footerText: data.get('footerText'),
                        primary: data.get('primary'),
                        primaryDark: data.get('primary'),
                        accent: data.get('accent')
                    },
                    labels: {
                        'widget.menuTitle': data.get('menuTitle')
                    }
                };
            }

            function paint() {
                if (sizeOutput) {
                    sizeOutput.textContent = form.elements.buttonSize.value + ' px';
                }

                colorOutputs.forEach(function (output) {
                    var input = output.previousElementSibling;

                    if (input) {
                        output.textContent = input.value;
                    }
                });
            }

            function update(remount) {
                var config = currentConfig();
                preview.textContent = JSON.stringify(config, null, 2);
                paint();

                if (remount) {
                    window.dispatchEvent(new CustomEvent('open-a11y:update', {
                        detail: { key: key, config: config }
                    }));

                    if (status) {
                        status.textContent = 'Remounted · state kept';
                    }
                }
            }

            form.addEventListener('input', function () {
                update(true);
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();
            });

            form.addEventListener('reset', function () {
                window.setTimeout(function () {
                    update(true);
                }, 0);
            });

            update(false);
        })();
    </script>
@endpush
