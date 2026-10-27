<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import type { IAccessibilityConfig } from "@aotr/open-a11y";
import { A11yWidget, useAccessibility } from "@aotr/open-a11y/vue";
import { defaultState, stateFromConfig, toConfig, type DemoState } from "../demo-config";

const page = usePage<{ config: Partial<IAccessibilityConfig> }>();
const state = ref<DemoState>(stateFromConfig(page.props.config));
const config = computed(() => toConfig(state.value));
const { settings, engine } = useAccessibility();

watch(
  () => state.value.language,
  (language) => {
    void engine?.setLanguage(language);
  },
);

function reset() {
  state.value = { ...defaultState };
}
</script>

<template>
  <header class="oa-hero">
    <div class="oa-hero__main">
      <p class="oa-kicker"><span>04</span> Inertia + Vue</p>
      <h1>Server props.<br /><em>Reactive control.</em></h1>
      <p class="oa-hero__lede">
        Laravel sends the initial widget config through Inertia. Vue takes over with a ref, a
        computed widget config, and the shared open-a11y engine.
      </p>
    </div>

    <aside class="oa-hero__aside" aria-label="About this demo">
      <p class="oa-aside-label">The demo</p>
      <p class="oa-aside-copy">
        This is a real Inertia Vue page. Its controls mutate a Vue ref; the widget is a declarative
        component wired to the plugin context.
      </p>
      <dl class="oa-spec">
        <div>
          <dt>Surface</dt>
          <dd>Inertia Vue</dd>
        </div>
        <div>
          <dt>Runtime</dt>
          <dd>Vue 3</dd>
        </div>
        <div>
          <dt>State</dt>
          <dd>localStorage</dd>
        </div>
        <div>
          <dt>Package</dt>
          <dd>@aotr/open-a11y</dd>
        </div>
      </dl>
    </aside>
  </header>

  <section class="oa-workbench" aria-labelledby="vue-demo-title">
    <div class="oa-explainer">
      <p class="oa-kicker">The component</p>
      <h2 id="vue-demo-title">Reactive props, one runtime.</h2>
      <p class="oa-lede">
        The Inertia page receives its config from Laravel, then uses the same
        <code>A11yWidget</code> component as any other Vue application.
      </p>

      <ol class="oa-notes">
        <li>
          <strong>Server-owned defaults.</strong>
          Laravel resolves the config and passes it as an Inertia prop.
        </li>
        <li>
          <strong>Reactive customization.</strong>
          Vue refs update the widget config on every control change.
        </li>
        <li>
          <strong>One saved state.</strong>
          Profiles, tools, and language persist across remounts.
        </li>
      </ol>

      <div class="oa-snippet">
        <div class="oa-snippet__head">
          <span>Vue</span>
          <span>Inertia page</span>
        </div>
        <pre><code>&lt;A11yWidget :options="{ config }" /&gt;</code></pre>
      </div>

      <div class="oa-snippet oa-snippet--state">
        <div class="oa-snippet__head">
          <span>Engine state</span>
          <span>{{ state.position }}</span>
        </div>
        <pre class="oa-code">{{ settings.states ?? {} }}</pre>
      </div>
    </div>

    <aside class="oa-panel" aria-labelledby="vue-customizer-title">
      <header class="oa-panel__head">
        <p class="oa-kicker">Vue controls</p>
        <h2 id="vue-customizer-title">Shape the widget.</h2>
        <p class="oa-panel__hint">Every change remounts the widget and keeps its state.</p>
      </header>

      <div class="oa-form">
        <div class="oa-field">
          <label for="vue-position">Position</label>
          <select id="vue-position" v-model="state.position">
            <option value="bottom-right">Bottom right</option>
            <option value="bottom-left">Bottom left</option>
            <option value="top-right">Top right</option>
            <option value="top-left">Top left</option>
          </select>
        </div>

        <div class="oa-field">
          <label for="vue-side">Panel side</label>
          <select id="vue-side" v-model="state.side">
            <option value="right">Right</option>
            <option value="left">Left</option>
          </select>
        </div>

        <div class="oa-field">
          <span class="oa-label">
            Offset <span class="oa-label__hint">pixels from the edge</span>
          </span>
          <div class="oa-split">
            <label class="oa-mini" for="vue-offset-x">
              <span>X</span>
              <input
                id="vue-offset-x"
                v-model.number="state.offsetX"
                type="number"
                min="0"
                max="120"
              />
            </label>
            <label class="oa-mini" for="vue-offset-y">
              <span>Y</span>
              <input
                id="vue-offset-y"
                v-model.number="state.offsetY"
                type="number"
                min="0"
                max="120"
              />
            </label>
          </div>
        </div>

        <div class="oa-field">
          <label for="vue-size">
            Button size <output>{{ state.buttonSize }} px</output>
          </label>
          <input
            id="vue-size"
            v-model.number="state.buttonSize"
            type="range"
            min="40"
            max="80"
            step="2"
          />
        </div>

        <div class="oa-field oa-field--colors">
          <label for="vue-primary">Primary</label>
          <div class="oa-color">
            <input id="vue-primary" v-model="state.primary" type="color" />
            <span class="oa-color__value">{{ state.primary }}</span>
          </div>
          <label for="vue-accent">Accent</label>
          <div class="oa-color">
            <input id="vue-accent" v-model="state.accent" type="color" />
            <span class="oa-color__value">{{ state.accent }}</span>
          </div>
        </div>

        <div class="oa-field">
          <label for="vue-menu-title">Menu title</label>
          <input id="vue-menu-title" v-model="state.menuTitle" type="text" />
        </div>

        <div class="oa-field">
          <label for="vue-footer-name">Footer name</label>
          <input id="vue-footer-name" v-model="state.footerName" type="text" />
        </div>

        <div class="oa-field">
          <label for="vue-footer-url">Footer URL</label>
          <input id="vue-footer-url" v-model="state.footerUrl" type="url" />
        </div>

        <div class="oa-field">
          <label for="vue-footer-text">Footer text</label>
          <input id="vue-footer-text" v-model="state.footerText" type="text" />
        </div>

        <div class="oa-field">
          <label for="vue-language">Language</label>
          <select id="vue-language" v-model="state.language">
            <option value="en">English</option>
            <option value="hi">हिन्दी (Hindi)</option>
          </select>
        </div>

        <div class="oa-toggles">
          <label class="oa-toggle" for="vue-blur">
            <input id="vue-blur" v-model="state.blur" type="checkbox" />
            <span class="oa-toggle__track" aria-hidden="true"></span>
            <span>Soften the page behind the panel</span>
          </label>
          <label class="oa-toggle" for="vue-show-button">
            <input id="vue-show-button" v-model="state.showButton" type="checkbox" />
            <span class="oa-toggle__track" aria-hidden="true"></span>
            <span>Keep the floating button visible</span>
          </label>
        </div>

        <div class="oa-form__foot">
          <button type="button" class="oa-button oa-button--quiet" @click="reset">
            Restore defaults
          </button>
        </div>
      </div>
    </aside>
  </section>

  <A11yWidget :options="{ config }" />
</template>
