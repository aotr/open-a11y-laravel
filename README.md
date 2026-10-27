# open-a11y Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aotr/open-a11y-laravel.svg?style=flat-square)](https://packagist.org/packages/aotr/open-a11y-laravel)
[![Tests](https://github.com/aotr/open-a11y-laravel/actions/workflows/tests.yml/badge.svg)](https://github.com/aotr/open-a11y-laravel/actions/workflows/tests.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-171411.svg)](LICENSE)
[![PHP 8.2+](https://img.shields.io/badge/php-8.2%2B-777bb4.svg)](https://www.php.net/)

**An accessibility widget with a real engine behind it — made native to Laravel.**

open-a11y ships profiles, individual tools, keyboard shortcuts, persisted preferences, and a shadow-DOM interface. This package gives that runtime a Blade component, a Livewire component, publishable config, and a standalone browser bundle. It also includes complete Inertia React, Vue, and Svelte example pages. No Node, Vite, or front-end build is required for the Blade/Livewire package itself.

![open-a11y Laravel surfaces](art/overview.png?v=3)

```blade
<x-open-a11y::widget :config="['position' => 'bottom-right', 'brand' => ['primary' => '#0f6b4f']]" />
```

---

## Requirements

- PHP **8.2+**
- Laravel **12 or 13**
- Livewire **3 or 4** (for the Livewire component)
- Optional: Inertia **3** with React 19 or Vue 3 (for the Inertia examples)
- Node.js + pnpm only for rebuilding the Inertia demo assets
- A browser with Web Components and Shadow DOM: Chrome 90+, Firefox 90+, Safari 15+, Edge 90+

The Blade component is independent of Livewire. The package requires Livewire because it ships both integrations.

## Installation

```bash
composer require aotr/open-a11y-laravel
```

Laravel package discovery registers `Aotr\OpenA11y\OpenA11yServiceProvider` automatically.

Publish the browser bundle:

```bash
php artisan vendor:publish --tag=open-a11y-assets
```

This copies the runtime to `public/vendor/open-a11y/`. The Blade and Livewire
components inject the `<script>` tags once per page, so you do not need to add
them to your layout.

Optionally publish the config file:

```bash
php artisan vendor:publish --tag=open-a11y-config
```

Set `OPEN_A11Y_ASSET_URL` (or `open-a11y.assets.url`) when serving the bundle
from a CDN. The published `public/vendor/open-a11y` directory must be web
accessible when using the default configuration.

### About the JavaScript core

The framework-agnostic runtime is available on npm as
[`@aotr/open-a11y`](https://www.npmjs.com/package/@aotr/open-a11y):

```bash
npm install @aotr/open-a11y
```

**This package ships the standalone IIFE browser bundle** in
`resources/dist/open-a11y.js`, so Laravel applications can use the widget
without a JavaScript toolchain. If your app already bundles the npm core, point
`open-a11y.assets.url` at your built asset (or publish and edit the package
views).

## Blade

```blade
<x-open-a11y::widget
    :config="[
        'position' => 'bottom-right',
        'side' => 'right',
        'offset' => [24, 24],
        'blur' => true,
        'buttonSize' => 56,
        'showButton' => true,
        'lang' => 'en',
        'brand' => [
            'name' => 'Acme',
            'url' => 'https://acme.example',
            'footerText' => 'Accessibility by Acme',
            'primary' => '#0f6b4f',
            'primaryDark' => '#0a4a37',
            'accent' => '#d4a13a',
        ],
        'labels' => [
            'widget.menuTitle' => 'Accessibility options',
        ],
    ]"
/>
```

The component merges your array over the package defaults in
`config/open-a11y.php`, renders a hidden mount element with the JSON config,
and includes the two browser scripts once.

Pass a stable `widget-key` when you want to target the instance from your own
JavaScript:

```blade
<x-open-a11y::widget :config="$config" widget-key="site-widget" />
```

## Livewire

```blade
<livewire:open-a11y::widget
    position="bottom-right"
    side="right"
    :offset-x="24"
    :offset-y="24"
    :blur="true"
    :button-size="56"
    :show-button="true"
    primary="#0f6b4f"
    primary-dark="#0a4a37"
    accent="#d4a13a"
    footer-name="Acme"
    footer-url="https://acme.example"
    footer-text="Accessibility by Acme"
    menu-title="Accessibility options"
    language="en"
/>
```

Every property is reactive. When a property changes, the component dispatches a
browser event with the new config:

```js
window.addEventListener("open-a11y:update", (event) => {
  // event.detail = { key: 'open-a11y-…', config: { … } }
});
```

The package's auto-init script listens for that event and remounts the widget.
The underlying engine is shared across mounts, so the visitor's selected tools,
contrast modes, and language stay in `localStorage` — a color change does not
reset their preferences.

Bind properties from a parent Livewire component or update them on the component
itself; both paths flow through the same event.

## Inertia + React

The repository includes a full Inertia React page at `/inertia-react`.

![Inertia React demo](art/inertia-react.png?v=3)

The package itself is framework-neutral; use the official React adapter in your
Inertia entry:

```bash
npm install @aotr/open-a11y @inertiajs/react react react-dom
```

```tsx
// resources/js/app.tsx
import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import { AccessibilityEngine, localStorageAdapter } from "@aotr/open-a11y";
import { AccessibilityProvider } from "@aotr/open-a11y/react";

const engine = new AccessibilityEngine({ storage: localStorageAdapter });

createInertiaApp({
  resolve: (name) => import(`./pages/${name}.tsx`),
  setup({ el, App, props }) {
    createRoot(el).render(
      <AccessibilityProvider engine={engine} autoInit>
        <App {...props} />
      </AccessibilityProvider>,
    );
  },
});
```

```tsx
// resources/js/pages/Welcome.tsx
import { AccessibilityWidget } from "@aotr/open-a11y/react";

export default function Welcome({ config }) {
  return (
    <>
      <h1>Your Inertia page</h1>
      <AccessibilityWidget config={config} />
    </>
  );
}
```

## Inertia + Vue

![Inertia Vue demo](art/inertia-vue.png?v=3)

```bash
npm install @aotr/open-a11y @inertiajs/vue3 vue
```

```ts
// resources/js/app.ts
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { AccessibilityEngine, localStorageAdapter } from "@aotr/open-a11y";
import { createAccessibilityPlugin } from "@aotr/open-a11y/vue";

const engine = new AccessibilityEngine({ storage: localStorageAdapter });

createInertiaApp({
  resolve: (name) => import(`./pages/${name}.vue`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(createAccessibilityPlugin(engine))
      .mount(el);
  },
});
```

```vue
<script setup lang="ts">
import { A11yWidget } from "@aotr/open-a11y/vue";

defineProps<{ config: Record<string, unknown> }>();
</script>

<template>
  <h1>Your Inertia page</h1>
  <A11yWidget :options="{ config }" />
</template>
```

## Inertia + Svelte

![Inertia Svelte demo](art/inertia-svelte.png?v=3)

```bash
npm install @aotr/open-a11y @inertiajs/svelte svelte
```

```ts
// resources/js/app.ts
import { createInertiaApp } from "@inertiajs/svelte";
import { mount } from "svelte";
import { AccessibilityEngine, localStorageAdapter } from "@aotr/open-a11y";

const engine = new AccessibilityEngine({ storage: localStorageAdapter });

void engine.init().then(() =>
  createInertiaApp({
    resolve: (name) => import(`./pages/${name}.svelte`),
    setup({ el, App, props }) {
      mount(App, { target: el, props });
    },
  }),
);
```

```svelte
<script lang="ts">
    import { accessibilityWidget } from "@aotr/open-a11y/svelte";
    import { engine } from "./accessibility-engine";

    let { config } = $props();
    const widgetOptions = { engine, config };
</script>

<h1>Your Inertia page</h1>
<div use:accessibilityWidget={widgetOptions}></div>
```

All three Inertia examples use the same server-resolved config as Blade and
Livewire. The demo pages are in
[`workbench/resources/js/pages`](workbench/resources/js/pages).

## Customization

Blade passes the runtime config keys directly. Livewire exposes the most useful
knobs as typed public properties.

| Livewire property    | Blade config key          | Type                                                   | Default                 |
| -------------------- | ------------------------- | ------------------------------------------------------ | ----------------------- |
| `position`           | `position`                | `bottom-right`, `bottom-left`, `top-right`, `top-left` | `bottom-right`          |
| `side`               | `side`                    | `right`, `left`                                        | `right`                 |
| `offsetX`, `offsetY` | `offset`                  | `[int, int]`                                           | `[20, 20]`              |
| `blur`               | `blur`                    | `bool`                                                 | `false`                 |
| `buttonSize`         | `buttonSize`              | `int` (px)                                             | `56`                    |
| `showButton`         | `showButton`              | `bool`                                                 | `true`                  |
| `primary`            | `brand.primary`           | CSS color                                              | `#0f6b4f`               |
| `primaryDark`        | `brand.primaryDark`       | CSS color                                              | `#0a4a37`               |
| `accent`             | `brand.accent`            | CSS color                                              | `#d4a13a`               |
| `footerName`         | `brand.name`              | `string`                                               | `''`                    |
| `footerUrl`          | `brand.url`               | `string`                                               | `''`                    |
| `footerText`         | `brand.footerText`        | `string`                                               | `''`                    |
| `menuTitle`          | `labels.widget.menuTitle` | `string`                                               | `Accessibility options` |
| `language`           | `lang`                    | `en`, `hi`                                             | `en`                    |
| `widgetKey`          | `widget-key` attribute    | `string`                                               | generated               |

An empty `footerText` hides the footer. When it is omitted and `brand.name` is
set, the runtime falls back to `Accessibility by {name}`.

Package-level defaults live in `config/open-a11y.php`:

```php
return [
    'position' => 'bottom-right',
    'side' => 'right',
    'offset' => [20, 20],
    'blur' => false,
    'button_size' => 56,
    'show_button' => true,
    'language' => 'en',
    'menu_title' => 'Accessibility options',
    'brand' => [
        'name' => null,
        'url' => null,
        'footer_text' => null,
        'primary' => '#0f6b4f',
        'primary_dark' => '#0a4a37',
        'accent' => '#d4a13a',
    ],
    'assets' => [
        'path' => 'vendor/open-a11y',
        'url' => null, // e.g. https://cdn.example.com/a11y
    ],
];
```

Need a custom UI string that is not exposed as a Livewire property? Use the
Blade component and pass it through `labels`:

```blade
<x-open-a11y::widget :config="[
    'labels' => [
        'widget.menuTitle' => 'Reading options',
        'widget.reset' => 'Clear all settings',
    ],
]" />
```

## Demo

The repository includes a Testbench workbench with four demos:

- `/blade` — Blade component with a plain-JavaScript customizer
- `/livewire` — Livewire component with server-reactive controls
- `/inertia-react` — Inertia page powered by React 19
- `/inertia-vue` — Inertia page powered by Vue 3
- `/inertia-svelte` — Inertia page powered by Svelte 5

```bash
composer install
pnpm install
composer demo
```

`composer demo` builds the Inertia entries and starts the workbench on
<http://127.0.0.1:4179>. The Blade and Livewire assets are served from
`resources/dist`; the Inertia entries are built with Vite+ and served from the
Testbench public directory.

Open any of the four routes from the workbench navigation. The Inertia
components live in
[`workbench/resources/js/pages`](workbench/resources/js/pages).

## Testing

```bash
composer test
```

The suite uses Orchestra Testbench and PHPUnit. It covers:

- Blade component rendering, JSON config serialization, and attribute merging
- Livewire initial props, browser event dispatch, and language updates
- Service provider view registration and publish tags
- All five demo routes and the asset routes
- Inertia React, Vue, and Svelte page components and server props
- Config defaults and override precedence

## Publishing

| Tag                | Copies                                                 |
| ------------------ | ------------------------------------------------------ |
| `open-a11y-config` | `config/open-a11y.php` → `config/open-a11y.php`        |
| `open-a11y-views`  | `resources/views` → `resources/views/vendor/open-a11y` |
| `open-a11y-assets` | `resources/dist` → `public/vendor/open-a11y`           |
| `open-a11y`        | all of the above                                       |

```bash
php artisan vendor:publish --tag=open-a11y
```

Use `--force` to overwrite previously published files.

## How it fits together

```text
<x-open-a11y::widget>            <livewire:open-a11y::widget>
        │                                  │
        └──────────────┬───────────────────┘
                       ▼
          hidden [data-open-a11y] element
          with JSON config attribute
                       │
                       ▼
          resources/dist/open-a11y-laravel.js
          reads config · owns shared engine
          persists to localStorage · remounts
                       │
                       ▼
          resources/dist/open-a11y.js (IIFE)
          web components · shadow DOM · tools
```

The widget's shadow DOM is intentionally left alone by the package and the demo.
Brand colors and copy are passed through the runtime config; the host page keeps
control of its own typography, spacing, and layout.

The upstream runtime maintains one active floating widget per page. Render one
open-a11y component per page and use `widget-key` to target it from custom
JavaScript.

## Contributing

Bug reports and pull requests are welcome. See [CONTRIBUTING.md](CONTRIBUTING.md)
for the local setup, the test command, and the review checklist.

## License

open-a11y Laravel is open-source software licensed under the
[MIT license](LICENSE).
