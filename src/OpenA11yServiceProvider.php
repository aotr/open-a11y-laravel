<?php

namespace Aotr\OpenA11y;

use Aotr\OpenA11y\Livewire\Widget as LivewireWidget;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class OpenA11yServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/open-a11y.php',
            'open-a11y',
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'open-a11y');

        Blade::componentNamespace('Aotr\\OpenA11y\\View\\Components', 'open-a11y');

        if (class_exists(Livewire::class)) {
            $livewire = app('livewire');

            if (method_exists($livewire, 'addNamespace')) {
                // Livewire 4 resolves namespaced components through the finder.
                $livewire->addNamespace(
                    namespace: 'open-a11y',
                    classNamespace: 'Aotr\\OpenA11y\\Livewire',
                );
            } else {
                Livewire::component('open-a11y::widget', LivewireWidget::class);
            }
        }

        $this->publishes([
            __DIR__.'/../config/open-a11y.php' => config_path('open-a11y.php'),
        ], ['open-a11y-config', 'open-a11y']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/open-a11y'),
        ], ['open-a11y-views', 'open-a11y']);

        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/open-a11y'),
        ], ['open-a11y-assets', 'open-a11y']);
    }
}
