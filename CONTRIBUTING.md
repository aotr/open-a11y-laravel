# Contributing

Thanks for taking the time to improve open-a11y Laravel. This package is small
on purpose: keep changes focused, keep the diff readable, and leave the
JavaScript runtime's shadow DOM alone.

## Local setup

Requirements: PHP 8.2+, Composer 2, and a modern browser for the demo.

```bash
git clone https://github.com/aotr/open-a11y-laravel.git
cd open-a11y-laravel
composer install
```

## Run the tests

```bash
composer test
```

The suite uses Orchestra Testbench and PHPUnit. New behavior needs a test. If
you change config serialization, publish tags, or either component, update or
add the matching feature test under `tests/`.

## Run the demos

```bash
composer demo
```

- <http://127.0.0.1:4179/blade>
- <http://127.0.0.1:4179/livewire>

The demo CSS lives at `workbench/resources/css/demo.css` and is shared by both
pages. Keep the design editorial: off-white paper, ink, one strong accent,
serif display type, generous spacing, and responsive behavior. Do not add
selectors that reach into the widget's shadow DOM.

## Project layout

```text
src/
  Livewire/Widget.php             Livewire component
  Support/WidgetConfig.php        config merge + JSON serialization
  View/Components/Widget.php      Blade component
  OpenA11yServiceProvider.php     views, components, publishing
resources/
  views/                          Blade, Livewire, and asset partials
  dist/open-a11y.js               upstream IIFE runtime (committed)
  dist/open-a11y-laravel.js       package auto-init script
config/open-a11y.php              package defaults
workbench/                        Testbench demo application
tests/                            PHPUnit suite
```

## Pull request checklist

- [ ] `composer test` passes.
- [ ] `node --check resources/dist/open-a11y-laravel.js` passes if the auto-init
      script changed.
- [ ] Both demo pages still render and the widget mounts.
- [ ] New public config keys are documented in the README table.
- [ ] No private keys, credentials, or unrelated branding are committed.
- [ ] The bundle in `resources/dist/open-a11y.js` is only replaced with a built
      release of the upstream runtime.

## JavaScript bundle

`resources/dist/open-a11y.js` is copied from the upstream open-a11y build. Do
not hand-edit minified output. The Laravel-specific auto-init lives in
`resources/dist/open-a11y-laravel.js` and is intentionally dependency-free.

## Security

Please report security issues privately to **animesh.aotr@gmail.com** rather
than opening a public issue. Include a reproduction and the affected versions.

## License

By contributing, you agree that your contribution is licensed under the MIT
license.
