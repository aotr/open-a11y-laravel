<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Ssr\Gateway;
use Inertia\Ssr\HttpGateway;
use Livewire\Livewire;
use Workbench\App\Livewire\Playground;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(\Inertia\ServiceProvider::class);
        $this->app->bind(Gateway::class, HttpGateway::class);

        config([
            'inertia.pages.paths' => [dirname(__DIR__, 2).'/resources/js/pages'],
            'inertia.pages.extensions' => ['tsx', 'vue', 'svelte'],
        ]);
    }

    public function boot(): void
    {
        config([
            'inertia.ssr.enabled' => false,
            'open-a11y.assets.url' => '/demo-assets',
        ]);

        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'workbench');

        Livewire::component('open-a11y-playground', Playground::class);
    }
}
