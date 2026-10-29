<?php

namespace Aotr\OpenA11y\Tests\Unit;

use Aotr\OpenA11y\Support\WidgetConfig;
use Aotr\OpenA11y\Tests\TestCase;

class WidgetConfigTest extends TestCase
{
    public function test_it_resolves_package_defaults(): void
    {
        $config = WidgetConfig::resolve();

        $this->assertSame('bottom-right', $config['position']);
        $this->assertSame('right', $config['side']);
        $this->assertSame([20, 20], $config['offset']);
        $this->assertFalse($config['blur']);
        $this->assertSame(56, $config['buttonSize']);
        $this->assertSame(44, $config['buttonSizeMobile']);
        $this->assertTrue($config['showButton']);
        $this->assertSame('en', $config['lang']);
        $this->assertSame('#0f6b4f', $config['brand']['primary']);
        $this->assertSame('#d4a13a', $config['brand']['accent']);
        $this->assertSame('Accessibility options', $config['labels']['widget.menuTitle']);
    }

    public function test_it_merges_package_config_and_component_overrides(): void
    {
        config([
            'open-a11y.position' => 'top-left',
            'open-a11y.button_size' => 64,
            'open-a11y.button_size_mobile' => 32,
            'open-a11y.brand.primary' => '#101010',
        ]);

        $config = WidgetConfig::resolve([
            'side' => 'left',
            'offset' => [48],
            'blur' => true,
            'buttonSizeMobile' => 36,
            'brand' => [
                'name' => 'Acme',
                'footerText' => '',
                'accent' => '#f4c430',
            ],
            'labels' => [
                'widget.menuTitle' => 'Access options',
            ],
        ]);

        $this->assertSame('top-left', $config['position']);
        $this->assertSame('left', $config['side']);
        $this->assertSame([48, 20], $config['offset']);
        $this->assertTrue($config['blur']);
        $this->assertSame(64, $config['buttonSize']);
        $this->assertSame(36, $config['buttonSizeMobile']);
        $this->assertSame('#101010', $config['brand']['primary']);
        $this->assertSame('#f4c430', $config['brand']['accent']);
        $this->assertSame('Acme', $config['brand']['name']);
        $this->assertSame('', $config['brand']['footerText']);
        $this->assertSame('Access options', $config['labels']['widget.menuTitle']);
    }

    public function test_it_drops_null_brand_values_but_keeps_empty_strings(): void
    {
        $config = WidgetConfig::resolve([
            'brand' => [
                'name' => null,
                'url' => null,
                'footerText' => '',
            ],
        ]);

        $this->assertArrayNotHasKey('name', $config['brand']);
        $this->assertArrayNotHasKey('url', $config['brand']);
        $this->assertArrayHasKey('footerText', $config['brand']);
        $this->assertSame('', $config['brand']['footerText']);
    }

    public function test_it_serializes_config_as_json(): void
    {
        $config = WidgetConfig::resolve([
            'position' => 'top-right',
            'brand' => ['name' => 'A/B "Studio"'],
        ]);

        $json = WidgetConfig::toJson($config);
        $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('top-right', $decoded['position']);
        $this->assertSame('A/B "Studio"', $decoded['brand']['name']);
        $this->assertStringNotContainsString('\\/', $json);
    }
}
