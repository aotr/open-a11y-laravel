<aside class="oa-panel oa-panel--livewire" aria-labelledby="livewire-customizer-title">
    <header class="oa-panel__head">
        <div class="oa-panel__row">
            <p class="oa-kicker">Livewire controls</p>
            <span class="oa-live">
                <span class="oa-live__dot" aria-hidden="true"></span>
                <span wire:loading.remove>Ready</span>
                <span wire:loading>Syncing…</span>
            </span>
        </div>
        <h2 id="livewire-customizer-title">Change a property.</h2>
        <p class="oa-panel__hint">Server round-trip, then a fresh mount. State stays put.</p>
    </header>

    <div class="oa-form">
        <div class="oa-field">
            <label for="lw-position">Position</label>
            <select id="lw-position" wire:model.live="position">
                <option value="bottom-right" @selected($position === 'bottom-right')>Bottom right</option>
                <option value="bottom-left" @selected($position === 'bottom-left')>Bottom left</option>
                <option value="top-right" @selected($position === 'top-right')>Top right</option>
                <option value="top-left" @selected($position === 'top-left')>Top left</option>
            </select>
        </div>

        <div class="oa-field">
            <label for="lw-side">Panel side</label>
            <select id="lw-side" wire:model.live="side">
                <option value="right" @selected($side === 'right')>Right</option>
                <option value="left" @selected($side === 'left')>Left</option>
            </select>
        </div>

        <div class="oa-field">
            <span class="oa-label">Offset <span class="oa-label__hint">pixels from the edge</span></span>
            <div class="oa-split">
                <label class="oa-mini" for="lw-offset-x">
                    <span>X</span>
                    <input id="lw-offset-x" type="number" wire:model.live="offsetX" min="0" max="120">
                </label>
                <label class="oa-mini" for="lw-offset-y">
                    <span>Y</span>
                    <input id="lw-offset-y" type="number" wire:model.live="offsetY" min="0" max="120">
                </label>
            </div>
        </div>

        <div class="oa-field">
            <label for="lw-size">Button size <output for="lw-size">{{ $buttonSize }} px</output></label>
            <input id="lw-size" type="range" wire:model.live="buttonSize" min="40" max="80" step="2">
        </div>

        <div class="oa-field oa-field--colors">
            <label for="lw-primary">Primary</label>
            <div class="oa-color">
                <input id="lw-primary" type="color" wire:model.live="primary">
                <span class="oa-color__value">{{ $primary }}</span>
            </div>
            <label for="lw-accent">Accent</label>
            <div class="oa-color">
                <input id="lw-accent" type="color" wire:model.live="accent">
                <span class="oa-color__value">{{ $accent }}</span>
            </div>
        </div>

        <div class="oa-field">
            <label for="lw-menu-title">Menu title</label>
            <input id="lw-menu-title" type="text" wire:model.live.debounce.500ms="menuTitle">
        </div>

        <div class="oa-field">
            <label for="lw-footer-name">Footer name</label>
            <input id="lw-footer-name" type="text" wire:model.live.debounce.500ms="footerName">
        </div>

        <div class="oa-field">
            <label for="lw-footer-url">Footer URL</label>
            <input id="lw-footer-url" type="url" wire:model.live.debounce.500ms="footerUrl">
        </div>

        <div class="oa-field">
            <label for="lw-footer-text">Footer text</label>
            <input id="lw-footer-text" type="text" wire:model.live.debounce.500ms="footerText">
        </div>

        <div class="oa-field">
            <label for="lw-language">Language</label>
            <select id="lw-language" wire:model.live="language">
                <option value="en" @selected($language === 'en')>English</option>
                <option value="hi" @selected($language === 'hi')>हिन्दी (Hindi)</option>
            </select>
        </div>

        <div class="oa-toggles">
            <label class="oa-toggle" for="lw-blur">
                <input id="lw-blur" type="checkbox" wire:model.live="blur">
                <span class="oa-toggle__track" aria-hidden="true"></span>
                <span>Soften the page behind the panel</span>
            </label>

            <label class="oa-toggle" for="lw-show-button">
                <input id="lw-show-button" type="checkbox" wire:model.live="showButton">
                <span class="oa-toggle__track" aria-hidden="true"></span>
                <span>Keep the floating button visible</span>
            </label>
        </div>

        <div class="oa-form__foot">
            <button type="button" class="oa-button oa-button--quiet" wire:click="resetControls">Restore defaults</button>
        </div>
    </div>

    <div class="oa-snippet oa-snippet--state">
        <div class="oa-snippet__head">
            <span>Current config</span>
            <span>{{ $position }} · {{ $language }}</span>
        </div>
        <pre class="oa-code">{{ json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
    </div>

    <livewire:open-a11y::widget
        :position="$position"
        :side="$side"
        :offset-x="$offsetX"
        :offset-y="$offsetY"
        :blur="$blur"
        :button-size="$buttonSize"
        :show-button="$showButton"
        :primary="$primary"
        :primary-dark="$primary"
        :accent="$accent"
        :footer-name="$footerName"
        :footer-url="$footerUrl"
        :footer-text="$footerText"
        :menu-title="$menuTitle"
        :language="$language"
        :widget-key="$widgetKey"
    />
</aside>
