<?php

namespace Aotr\OpenA11y\Tests\Feature;

use Aotr\OpenA11y\Tests\TestCase;
use Inertia\Testing\AssertableInertia;

class DemoRoutesTest extends TestCase
{
    public function test_the_root_redirects_to_the_blade_demo(): void
    {
        $this->get('/')->assertRedirect('/blade');
    }

    public function test_the_blade_demo_renders(): void
    {
        $this->get('/blade')
            ->assertOk()
            ->assertSee('Blade component')
            ->assertSee('The config is the component.')
            ->assertSee('id="blade-customizer"', false)
            ->assertSee('data-open-a11y="blade-demo"', false)
            ->assertSee('name="csrf-token"', false)
            ->assertSee('/demo-assets/open-a11y.js', false)
            ->assertSee('/demo-assets/open-a11y-laravel.js', false);
    }

    public function test_the_livewire_demo_renders(): void
    {
        $this->get('/livewire')
            ->assertOk()
            ->assertSee('Livewire component')
            ->assertSee('Reactive properties, one runtime.')
            ->assertSee('wire:model.live="position"', false)
            ->assertSee('data-open-a11y="livewire-demo"', false)
            ->assertSee('/demo-assets/open-a11y.js', false);
    }

    public function test_the_inertia_react_demo_returns_the_expected_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/inertia-react')->assertOk();

        AssertableInertia::fromTestResponse($response)
            ->component('InertiaReact')
            ->where('config.position', 'bottom-right')
            ->where('config.brand.primary', '#0f6b4f')
            ->where('config.labels', fn ($labels) => $labels['widget.menuTitle'] === 'Accessibility options');
    }

    public function test_the_inertia_vue_demo_returns_the_expected_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/inertia-vue')->assertOk();

        AssertableInertia::fromTestResponse($response)
            ->component('InertiaVue')
            ->where('config.position', 'bottom-right')
            ->where('config.lang', 'en');
    }

    public function test_the_inertia_svelte_demo_returns_the_expected_page(): void
    {
        $this->withoutVite();

        $response = $this->get('/inertia-svelte')->assertOk();

        AssertableInertia::fromTestResponse($response)
            ->component('InertiaSvelte')
            ->where('config.position', 'bottom-right')
            ->where('config.lang', 'en');
    }

    public function test_the_demo_stylesheet_is_served(): void
    {
        $this->get('/demo.css')
            ->assertOk()
            ->assertHeader('content-type', 'text/css; charset=UTF-8');
    }

    public function test_the_browser_bundles_are_served(): void
    {
        $this->get('/demo-assets/open-a11y.js')
            ->assertOk()
            ->assertHeader('content-type', 'application/javascript; charset=UTF-8');

        $this->get('/demo-assets/open-a11y-laravel.js')
            ->assertOk()
            ->assertHeader('content-type', 'application/javascript; charset=UTF-8');

        $this->get('/demo-assets/not-allowed.js')->assertNotFound();
    }
}
