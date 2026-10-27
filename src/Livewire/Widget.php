<?php

namespace Aotr\OpenA11y\Livewire;

use Aotr\OpenA11y\Support\WidgetConfig;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Widget extends Component
{
    public string $position = 'bottom-right';

    public string $side = 'right';

    public int $offsetX = 20;

    public int $offsetY = 20;

    public bool $blur = false;

    public int $buttonSize = 56;

    public bool $showButton = true;

    public string $primary = '#0f6b4f';

    public string $primaryDark = '#0a4a37';

    public string $accent = '#d4a13a';

    public string $footerName = '';

    public string $footerUrl = '';

    public string $footerText = '';

    public string $menuTitle = 'Accessibility options';

    public string $language = 'en';

    public string $widgetKey = '';

    public function mount(
        string $position = 'bottom-right',
        string $side = 'right',
        int $offsetX = 20,
        int $offsetY = 20,
        bool $blur = false,
        int $buttonSize = 56,
        bool $showButton = true,
        string $primary = '#0f6b4f',
        string $primaryDark = '#0a4a37',
        string $accent = '#d4a13a',
        string $footerName = '',
        string $footerUrl = '',
        string $footerText = '',
        string $menuTitle = 'Accessibility options',
        string $language = 'en',
        ?string $widgetKey = null,
    ): void {
        $this->position = $position;
        $this->side = $side;
        $this->offsetX = $offsetX;
        $this->offsetY = $offsetY;
        $this->blur = $blur;
        $this->buttonSize = $buttonSize;
        $this->showButton = $showButton;
        $this->primary = $primary;
        $this->primaryDark = $primaryDark;
        $this->accent = $accent;
        $this->footerName = $footerName;
        $this->footerUrl = $footerUrl;
        $this->footerText = $footerText;
        $this->menuTitle = $menuTitle;
        $this->language = $language;
        $this->widgetKey = $widgetKey ?: 'open-a11y-'.Str::lower(Str::random(8));
    }

    public function updated(string $property): void
    {
        if ($property === 'widgetKey') {
            return;
        }

        $this->dispatch('open-a11y:update', key: $this->widgetKey, config: $this->config());
    }

    /**
     * @return array<string, mixed>
     */
    public function config(): array
    {
        return WidgetConfig::resolve([
            'position' => $this->position,
            'side' => $this->side,
            'offset' => [$this->offsetX, $this->offsetY],
            'blur' => $this->blur,
            'buttonSize' => $this->buttonSize,
            'showButton' => $this->showButton,
            'lang' => $this->language,
            'brand' => [
                'name' => $this->footerName,
                'url' => $this->footerUrl,
                'footerText' => $this->footerText,
                'primary' => $this->primary,
                'primaryDark' => $this->primaryDark,
                'accent' => $this->accent,
            ],
            'labels' => [
                'widget.menuTitle' => $this->menuTitle,
            ],
        ]);
    }

    public function render(): View
    {
        return view('open-a11y::livewire.widget', [
            'config' => $this->config(),
        ]);
    }
}
