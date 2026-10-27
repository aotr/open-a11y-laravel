<script lang="ts">
    import type { IAccessibilityConfig } from "@aotr/open-a11y";
    import { accessibilityWidget, createAccessibilityStore } from "@aotr/open-a11y/svelte";
    import { engine } from "../accessibility-engine";
    import {
        defaultState,
        stateFromConfig,
        toConfig,
        type DemoState,
    } from "../demo-config";

    let { config } = $props<{ config: Partial<IAccessibilityConfig> }>();
    // Inertia sends the initial server config once per page visit.
    // svelte-ignore state_referenced_locally
    let state = $state<DemoState>(stateFromConfig(config));
    const a11y = createAccessibilityStore(engine);
    const widgetOptions = $derived({ engine, config: toConfig(state) });

    $effect(() => {
        void engine.setLanguage(state.language);
    });

    function reset() {
        state = { ...defaultState };
    }
</script>

<header class="oa-hero">
    <div class="oa-hero__main">
        <p class="oa-kicker"><span>05</span> Inertia + Svelte</p>
        <h1>Server props.<br /><em>Store control.</em></h1>
        <p class="oa-hero__lede">
            Laravel sends the initial config through Inertia. Svelte takes over with a
            readable store, a reactive object, and the same open-a11y engine.
        </p>
    </div>

    <aside class="oa-hero__aside" aria-label="About this demo">
        <p class="oa-aside-label">The demo</p>
        <p class="oa-aside-copy">
            This is a real Inertia Svelte page. Its controls mutate reactive state; the
            widget mounts through the Svelte action.
        </p>
        <dl class="oa-spec">
            <div><dt>Surface</dt><dd>Inertia Svelte</dd></div>
            <div><dt>Runtime</dt><dd>Svelte 5</dd></div>
            <div><dt>State</dt><dd>localStorage</dd></div>
            <div><dt>Package</dt><dd>@aotr/open-a11y</dd></div>
        </dl>
    </aside>
</header>

<section class="oa-workbench" aria-labelledby="svelte-demo-title">
    <div class="oa-explainer">
        <p class="oa-kicker">The component</p>
        <h2 id="svelte-demo-title">Reactive stores, one runtime.</h2>
        <p class="oa-lede">
            The Inertia page receives its config from Laravel, then uses the same
            <code>accessibilityWidget</code> action as any other Svelte application.
        </p>

        <ol class="oa-notes">
            <li>
                <strong>Server-owned defaults.</strong>
                Laravel resolves the config and passes it as an Inertia prop.
            </li>
            <li>
                <strong>Store + action.</strong>
                A readable store exposes engine state; the action owns the widget mount.
            </li>
            <li>
                <strong>One saved state.</strong>
                Profiles, tools, and language persist across remounts.
            </li>
        </ol>

        <div class="oa-snippet">
            <div class="oa-snippet__head">
                <span>Svelte</span>
                <span>Inertia page</span>
            </div>
            <pre><code>&lt;div use:accessibilityWidget={widgetOptions}&gt;&lt;/div&gt;</code></pre>
        </div>

        <div class="oa-snippet oa-snippet--state">
            <div class="oa-snippet__head">
                <span>Engine state</span>
                <span>{state.position}</span>
            </div>
            <pre class="oa-code">{$a11y.states ?? {}}</pre>
        </div>
    </div>

    <aside class="oa-panel" aria-labelledby="svelte-customizer-title">
        <header class="oa-panel__head">
            <p class="oa-kicker">Svelte controls</p>
            <h2 id="svelte-customizer-title">Shape the widget.</h2>
            <p class="oa-panel__hint">Every change remounts the widget and keeps its state.</p>
        </header>

        <div class="oa-form">
            <div class="oa-field">
                <label for="svelte-position">Position</label>
                <select id="svelte-position" bind:value={state.position}>
                    <option value="bottom-right">Bottom right</option>
                    <option value="bottom-left">Bottom left</option>
                    <option value="top-right">Top right</option>
                    <option value="top-left">Top left</option>
                </select>
            </div>

            <div class="oa-field">
                <label for="svelte-side">Panel side</label>
                <select id="svelte-side" bind:value={state.side}>
                    <option value="right">Right</option>
                    <option value="left">Left</option>
                </select>
            </div>

            <div class="oa-field">
                <span class="oa-label">Offset <span class="oa-label__hint">pixels from the edge</span></span>
                <div class="oa-split">
                    <label class="oa-mini" for="svelte-offset-x">
                        <span>X</span>
                        <input id="svelte-offset-x" type="number" min="0" max="120" bind:value={state.offsetX} />
                    </label>
                    <label class="oa-mini" for="svelte-offset-y">
                        <span>Y</span>
                        <input id="svelte-offset-y" type="number" min="0" max="120" bind:value={state.offsetY} />
                    </label>
                </div>
            </div>

            <div class="oa-field">
                <label for="svelte-size">Button size <output>{state.buttonSize} px</output></label>
                <input id="svelte-size" type="range" min="40" max="80" step="2" bind:value={state.buttonSize} />
            </div>

            <div class="oa-field oa-field--colors">
                <label for="svelte-primary">Primary</label>
                <div class="oa-color">
                    <input id="svelte-primary" type="color" bind:value={state.primary} />
                    <span class="oa-color__value">{state.primary}</span>
                </div>
                <label for="svelte-accent">Accent</label>
                <div class="oa-color">
                    <input id="svelte-accent" type="color" bind:value={state.accent} />
                    <span class="oa-color__value">{state.accent}</span>
                </div>
            </div>

            <div class="oa-field">
                <label for="svelte-menu-title">Menu title</label>
                <input id="svelte-menu-title" type="text" bind:value={state.menuTitle} />
            </div>

            <div class="oa-field">
                <label for="svelte-footer-name">Footer name</label>
                <input id="svelte-footer-name" type="text" bind:value={state.footerName} />
            </div>

            <div class="oa-field">
                <label for="svelte-footer-url">Footer URL</label>
                <input id="svelte-footer-url" type="url" bind:value={state.footerUrl} />
            </div>

            <div class="oa-field">
                <label for="svelte-footer-text">Footer text</label>
                <input id="svelte-footer-text" type="text" bind:value={state.footerText} />
            </div>

            <div class="oa-field">
                <label for="svelte-language">Language</label>
                <select id="svelte-language" bind:value={state.language}>
                    <option value="en">English</option>
                    <option value="hi">हिन्दी (Hindi)</option>
                </select>
            </div>

            <div class="oa-toggles">
                <label class="oa-toggle" for="svelte-blur">
                    <input id="svelte-blur" type="checkbox" bind:checked={state.blur} />
                    <span class="oa-toggle__track" aria-hidden="true"></span>
                    <span>Soften the page behind the panel</span>
                </label>
                <label class="oa-toggle" for="svelte-show-button">
                    <input id="svelte-show-button" type="checkbox" bind:checked={state.showButton} />
                    <span class="oa-toggle__track" aria-hidden="true"></span>
                    <span>Keep the floating button visible</span>
                </label>
            </div>

            <div class="oa-form__foot">
                <button type="button" class="oa-button oa-button--quiet" onclick={reset}>Restore defaults</button>
            </div>
        </div>
    </aside>
</section>

<div use:accessibilityWidget={widgetOptions}></div>
