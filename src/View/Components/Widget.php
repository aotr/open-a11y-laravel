<?php

namespace Aotr\OpenA11y\View\Components;

use Aotr\OpenA11y\Support\WidgetConfig;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Widget extends Component
{
    /** @var array<string, mixed> */
    public array $config;

    public string $widgetKey;

    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(array $config = [], ?string $widgetKey = null)
    {
        $this->config = WidgetConfig::resolve($config);
        $this->widgetKey = $widgetKey
            ?: 'open-a11y-'.substr(hash('xxh3', WidgetConfig::toJson($this->config)), 0, 10);
    }

    public function render(): View
    {
        return view('open-a11y::components.widget', [
            'json' => WidgetConfig::toJson($this->config),
        ]);
    }
}
