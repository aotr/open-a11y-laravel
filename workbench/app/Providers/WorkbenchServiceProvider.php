<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Workbench\App\Livewire\Playground;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        config([
            'open-a11y.assets.url' => '/demo-assets',
        ]);

        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'workbench');

        Livewire::component('open-a11y-playground', Playground::class);
    }
}
