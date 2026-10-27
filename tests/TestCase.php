<?php

namespace Aotr\OpenA11y\Tests;

use Aotr\OpenA11y\OpenA11yServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Providers\WorkbenchServiceProvider;

abstract class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            OpenA11yServiceProvider::class,
            LivewireServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:2fl+Ktvkfl+Fuz4Qp/A75G2RTiWVA/ZoKZvp6fiiM10=');
        $app['config']->set('open-a11y.assets.url', '/demo-assets');
    }

    /**
     * @return array<string, mixed>
     */
    protected function configFromHtml(string $html): array
    {
        preg_match('/data-open-a11y-config="([^"]*)"/', $html, $matches);

        $this->assertNotEmpty($matches[1] ?? null, 'The widget config attribute was not rendered.');

        return json_decode(
            html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }
}
