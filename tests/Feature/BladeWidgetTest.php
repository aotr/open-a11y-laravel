<?php

namespace Aotr\OpenA11y\Tests\Feature;

use Aotr\OpenA11y\Tests\TestCase;
use Illuminate\Support\Facades\Blade;

class BladeWidgetTest extends TestCase
{
    public function test_it_renders_a_mount_element_with_serialized_config(): void
    {
        $html = Blade::render('<x-open-a11y::widget :config="$config" />', [
            'config' => [
                'position' => 'top-left',
                'blur' => true,
                'buttonSize' => 64,
                'brand' => [
                    'name' => 'Acme',
                    'primary' => '#123456',
                    'accent' => '#fedcba',
                ],
                'labels' => [
                    'widget.menuTitle' => 'Access options',
                ],
            ],
        ]);

        $config = $this->configFromHtml($html);

        $this->assertSame('top-left', $config['position']);
        $this->assertTrue($config['blur']);
        $this->assertSame(64, $config['buttonSize']);
        $this->assertSame('Acme', $config['brand']['name']);
        $this->assertSame('#123456', $config['brand']['primary']);
        $this->assertSame('#fedcba', $config['brand']['accent']);
        $this->assertSame('Access options', $config['labels']['widget.menuTitle']);
        $this->assertStringContainsString('data-open-a11y="open-a11y-', $html);
    }

    public function test_it_accepts_an_explicit_widget_key(): void
    {
        $html = Blade::render('<x-open-a11y::widget widget-key="footer-widget" />');

        $this->assertStringContainsString('data-open-a11y="footer-widget"', $html);
    }

    public function test_it_includes_the_browser_assets_only_once(): void
    {
        $html = Blade::render('<div><x-open-a11y::widget /><x-open-a11y::widget /></div>');

        $this->assertSame(1, substr_count($html, 'src="/demo-assets/open-a11y.js"'));
        $this->assertSame(1, substr_count($html, 'src="/demo-assets/open-a11y-laravel.js"'));
    }

    public function test_it_merges_html_attributes_onto_the_mount_element(): void
    {
        $html = Blade::render('<x-open-a11y::widget class="custom-mount" data-testid="a11y" />');

        $this->assertStringContainsString('class="custom-mount"', $html);
        $this->assertStringContainsString('data-testid="a11y"', $html);
    }

    public function test_it_uses_the_configured_asset_url(): void
    {
        config(['open-a11y.assets.url' => 'https://cdn.example.com/a11y']);

        $html = Blade::render('<x-open-a11y::widget />');

        $this->assertStringContainsString('src="https://cdn.example.com/a11y/open-a11y.js"', $html);
        $this->assertStringContainsString('src="https://cdn.example.com/a11y/open-a11y-laravel.js"', $html);
    }
}
