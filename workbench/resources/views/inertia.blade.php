<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ str_replace('Inertia', 'Inertia ', $page['component'] ?? 'Inertia') }} · open-a11y</title>
    <meta name="description" content="Inertia React and Vue examples for the open-a11y Laravel package.">
    <link rel="stylesheet" href="{{ route('demo.css') }}">
    @if (($page['component'] ?? '') === 'InertiaReact')
        @viteReactRefresh
        @vite('workbench/resources/js/inertia-react.tsx')
    @elseif (($page['component'] ?? '') === 'InertiaVue')
        @vite('workbench/resources/js/inertia-vue.ts')
    @else
        @vite('workbench/resources/js/inertia-svelte.ts')
    @endif
    @inertiaHead
</head>
<body>
<a class="oa-skip" href="#main">Skip to content</a>

<header class="oa-masthead">
    <div class="oa-masthead__inner">
        <a class="oa-brand" href="{{ route('blade') }}">
            open<span class="oa-brand__dot">·</span>a11y
            <span class="oa-brand__tag">Laravel</span>
        </a>

        <nav class="oa-nav" aria-label="Demo pages">
            <a href="{{ route('blade') }}" @class(['is-active' => request()->routeIs('blade')])>Blade</a>
            <a href="{{ route('livewire') }}" @class(['is-active' => request()->routeIs('livewire')])>Livewire</a>
            <a href="{{ route('inertia-react') }}" @class(['is-active' => request()->routeIs('inertia-react')])>React</a>
            <a href="{{ route('inertia-vue') }}" @class(['is-active' => request()->routeIs('inertia-vue')])>Vue</a>
            <a href="{{ route('inertia-svelte') }}" @class(['is-active' => request()->routeIs('inertia-svelte')])>Svelte</a>
            <a href="https://github.com/aotr/open-a11y-laravel" rel="noreferrer">GitHub <span aria-hidden="true">↗</span></a>
        </nav>
    </div>
</header>

<main id="main">
    @inertia
</main>

<footer class="oa-footer">
    <div class="oa-footer__inner">
        <p class="oa-footer__mark">open·a11y <span>for Laravel</span></p>
        <p class="oa-footer__note">Built for pages that take access seriously. MIT licensed.</p>
        <p class="oa-footer__meta">PHP 8.2+ · Laravel 12 · Inertia 3</p>
    </div>
</footer>
</body>
</html>
