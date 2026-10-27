<?php

namespace Aotr\OpenA11y\Tests\Feature;

use Aotr\OpenA11y\OpenA11yServiceProvider;
use Aotr\OpenA11y\Tests\TestCase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function test_it_registers_the_package_views(): void
    {
        $this->assertTrue(View::exists('open-a11y::components.widget'));
        $this->assertTrue(View::exists('open-a11y::livewire.widget'));
        $this->assertTrue(View::exists('open-a11y::partials.scripts'));
    }

    public function test_it_registers_the_blade_component_namespace(): void
    {
        $html = Blade::render('<x-open-a11y::widget />');

        $this->assertStringContainsString('data-open-a11y=', $html);
    }

    public function test_it_publishes_config_views_and_assets(): void
    {
        $config = ServiceProvider::pathsToPublish(OpenA11yServiceProvider::class, 'open-a11y-config');
        $views = ServiceProvider::pathsToPublish(OpenA11yServiceProvider::class, 'open-a11y-views');
        $assets = ServiceProvider::pathsToPublish(OpenA11yServiceProvider::class, 'open-a11y-assets');

        $this->assertNotEmpty($config);
        $this->assertNotEmpty($views);
        $this->assertNotEmpty($assets);

        $this->assertArrayHasKey(
            realpath(__DIR__.'/../../config/open-a11y.php'),
            array_combine(
                array_map('realpath', array_keys($config)),
                array_values($config),
            ),
        );

        $this->assertFileExists(__DIR__.'/../../resources/dist/open-a11y.js');
        $this->assertFileExists(__DIR__.'/../../resources/dist/open-a11y-laravel.js');
    }

    public function test_it_merges_the_package_config(): void
    {
        $this->assertSame('bottom-right', config('open-a11y.position'));
        $this->assertSame(56, config('open-a11y.button_size'));
        $this->assertSame('vendor/open-a11y', config('open-a11y.assets.path'));
    }

    public function test_it_ships_the_auto_init_script(): void
    {
        $script = file_get_contents(__DIR__.'/../../resources/dist/open-a11y-laravel.js');

        $this->assertIsString($script);
        $this->assertStringContainsString('data-open-a11y', $script);
        $this->assertStringContainsString('open-a11y:update', $script);
        $this->assertStringContainsString('localStorageAdapter', $script);
        $this->assertStringContainsString('createAccessibilityUI', $script);
    }
}
