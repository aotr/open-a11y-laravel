# Changelog

All notable changes to `aotr/open-a11y-laravel` are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-10-26

### Added

- Blade component `<x-open-a11y::widget>` with JSON config merging and a hidden
  mount element.
- Livewire component `<livewire:open-a11y::widget>` with reactive properties for
  position, side, offsets, blur, button size, brand colors, footer copy, menu
  title, language, and button visibility.
- Automatic `open-a11y:update` browser event on Livewire property changes, with
  state preserved by the shared runtime and `localStorage`.
- Standalone open-a11y IIFE browser bundle plus a Laravel auto-init script that
  mounts from `data-open-a11y` elements and reads JSON config.
- Config file with package defaults and a configurable asset path or CDN URL.
- Publish tags for config, views, and assets.
- Service provider with Blade component namespace and Livewire registration.
- Testbench workbench with `/blade` and `/livewire` demos.
- PHPUnit coverage for Blade, Livewire, config serialization, the service
  provider, publishing, demo routes, and asset routes.
- GitHub Actions test workflow on PHP 8.4.
- MIT license, README, and contributing guide.

[1.0.0]: https://github.com/aotr/open-a11y-laravel/releases/tag/v1.0.0
