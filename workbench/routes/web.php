<?php

use Aotr\OpenA11y\Support\WidgetConfig;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$demoConfig = static fn (): array => WidgetConfig::resolve([
    'position' => 'bottom-right',
    'side' => 'right',
    'offset' => [20, 20],
    'blur' => true,
    'buttonSize' => 56,
    'buttonSizeMobile' => 44,
    'showButton' => true,
    'lang' => 'en',
    'brand' => [
        'name' => 'open-a11y demo',
        'url' => 'https://github.com/aotr/open-a11y',
        'footerText' => 'Accessibility tools by open-a11y',
        'primary' => '#0f6b4f',
        'primaryDark' => '#0a4a37',
        'accent' => '#d4a13a',
    ],
    'labels' => [
        'widget.menuTitle' => 'Accessibility options',
    ],
]);

Route::middleware('web')->group(function () use ($demoConfig) {
    Route::get('/', fn () => redirect('/blade'))->name('home');

    Route::get('/blade', fn () => view('workbench::blade', [
        'config' => $demoConfig(),
    ]))->name('blade');

    Route::get('/livewire', fn () => view('workbench::livewire'))->name('livewire');

    Route::get('/inertia-react', fn () => Inertia::render('InertiaReact', [
        'config' => $demoConfig(),
    ])->rootView('workbench::inertia'))->name('inertia-react');

    Route::get('/inertia-vue', fn () => Inertia::render('InertiaVue', [
        'config' => $demoConfig(),
    ])->rootView('workbench::inertia'))->name('inertia-vue');

    Route::get('/inertia-svelte', fn () => Inertia::render('InertiaSvelte', [
        'config' => $demoConfig(),
    ])->rootView('workbench::inertia'))->name('inertia-svelte');

    Route::get('/demo.css', function () {
        return response()->file(
            dirname(__DIR__).'/resources/css/demo.css',
            ['Content-Type' => 'text/css; charset=UTF-8'],
        );
    })->name('demo.css');

    Route::get('/demo-assets/{asset}', function (string $asset) {
        abort_unless(in_array($asset, ['open-a11y.js', 'open-a11y-laravel.js'], true), 404);

        return response()->file(
            dirname(__DIR__, 2).'/resources/dist/'.$asset,
            ['Content-Type' => 'application/javascript; charset=UTF-8'],
        );
    })->where('asset', '[A-Za-z0-9._-]+')->name('demo.asset');
});
