<?php

namespace Aotr\OpenA11y\Tests\Feature;

use Aotr\OpenA11y\Livewire\Widget;
use Aotr\OpenA11y\Tests\TestCase;
use Livewire\Livewire;

class LivewireWidgetTest extends TestCase
{
    public function test_it_renders_the_widget_mount_with_defaults(): void
    {
        Livewire::test(Widget::class)
            ->assertStatus(200)
            ->assertSet('position', 'bottom-right')
            ->assertSet('buttonSize', 56)
            ->assertSet('buttonSizeMobile', 44)
            ->assertSet('showButton', true)
            ->assertSee('data-open-a11y-config', false)
            ->assertSee('open-a11y-laravel.js', false);
    }

    public function test_it_accepts_initial_properties(): void
    {
        Livewire::test(Widget::class, [
            'position' => 'top-left',
            'side' => 'left',
            'offsetX' => 32,
            'offsetY' => 44,
            'blur' => true,
            'buttonSize' => 72,
            'buttonSizeMobile' => 32,
            'showButton' => false,
            'primary' => '#123456',
            'accent' => '#abcdef',
            'footerName' => 'Acme',
            'footerText' => 'Made accessible',
            'menuTitle' => 'Options',
            'language' => 'hi',
        ])
            ->assertSet('position', 'top-left')
            ->assertSet('side', 'left')
            ->assertSet('offsetX', 32)
            ->assertSet('offsetY', 44)
            ->assertSet('blur', true)
            ->assertSet('buttonSize', 72)
            ->assertSet('buttonSizeMobile', 32)
            ->assertSet('showButton', false)
            ->assertSet('language', 'hi')
            ->assertSee('data-open-a11y-config', false);
    }

    public function test_an_update_dispatches_the_browser_event_with_the_new_config(): void
    {
        Livewire::test(Widget::class)
            ->set('position', 'top-right')
            ->set('buttonSizeMobile', 30)
            ->set('primary', '#c2410c')
            ->assertDispatched('open-a11y:update', function (string $name, array $params): bool {
                return $name === 'open-a11y:update'
                    && $params['config']['position'] === 'top-right'
                    && $params['config']['buttonSizeMobile'] === 30
                    && $params['config']['brand']['primary'] === '#c2410c'
                    && is_string($params['key'])
                    && $params['key'] !== '';
            })
            ->assertSee('top-right', false)
            ->assertSee('#c2410c', false);
    }

    public function test_changing_language_dispatches_an_update(): void
    {
        Livewire::test(Widget::class)
            ->set('language', 'hi')
            ->assertSet('language', 'hi')
            ->assertDispatched('open-a11y:update', function (string $name, array $params): bool {
                return $name === 'open-a11y:update'
                    && $params['config']['lang'] === 'hi';
            });
    }

    public function test_a_custom_widget_key_is_preserved_in_the_event(): void
    {
        Livewire::test(Widget::class, ['widgetKey' => 'livewire-demo'])
            ->set('position', 'bottom-left')
            ->assertDispatched('open-a11y:update', function (string $name, array $params): bool {
                return $name === 'open-a11y:update'
                    && $params['key'] === 'livewire-demo';
            });
    }
}
