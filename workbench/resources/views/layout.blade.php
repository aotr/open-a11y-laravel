<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Accessibility widget for Laravel') · open-a11y</title>
    <meta name="description" content="A Blade and Livewire package for the open-a11y accessibility widget.">
    <link rel="stylesheet" href="{{ route('demo.css') }}">
    @livewireStyles
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
            <a href="{{ route('blade') }}" @class(['is-active' => request()->routeIs('blade')]) @if(request()->routeIs('blade')) aria-current="page" @endif>Blade</a>
            <a href="{{ route('livewire') }}" @class(['is-active' => request()->routeIs('livewire')]) @if(request()->routeIs('livewire')) aria-current="page" @endif>Livewire</a>
            <a href="https://github.com/aotr/open-a11y-laravel" rel="noreferrer">GitHub <span aria-hidden="true">↗</span></a>
        </nav>
    </div>
</header>

<main id="main">
    @yield('content')
</main>

<footer class="oa-footer">
    <div class="oa-footer__inner">
        <p class="oa-footer__mark">open·a11y <span>for Laravel</span></p>
        <p class="oa-footer__note">Built for pages that take access seriously. MIT licensed.</p>
        <p class="oa-footer__meta">PHP 8.2+ · Laravel 12 · Livewire 3</p>
    </div>
</footer>

@livewireScripts
@stack('scripts')
</body>
</html>
