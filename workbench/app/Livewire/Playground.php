<?php

namespace Workbench\App\Livewire;

use Aotr\OpenA11y\Support\WidgetConfig;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Playground extends Component
{
    public string $position = 'bottom-right';

    public string $side = 'right';

    public int $offsetX = 20;

    public int $offsetY = 20;

    public bool $blur = true;

    public int $buttonSize = 56;

    public int $buttonSizeMobile = 44;

    public bool $showButton = true;

    public string $primary = '#0f6b4f';

    public string $accent = '#d4a13a';

    public string $footerName = 'open-a11y demo';

    public string $footerUrl = 'https://github.com/aotr/open-a11y';

    public string $footerText = 'Accessibility tools by open-a11y';

    public string $menuTitle = 'Accessibility options';

    public string $language = 'en';

    public string $widgetKey = 'livewire-demo';

    public function updated(string $property): void
    {
        if ($property === 'widgetKey') {
            return;
        }

        $this->dispatch('open-a11y:update', key: $this->widgetKey, config: $this->config());
    }

    public function resetControls(): void
    {
        $this->position = 'bottom-right';
        $this->side = 'right';
        $this->offsetX = 20;
        $this->offsetY = 20;
        $this->blur = true;
        $this->buttonSize = 56;
        $this->buttonSizeMobile = 44;
        $this->showButton = true;
        $this->primary = '#0f6b4f';
        $this->accent = '#d4a13a';
        $this->footerName = 'open-a11y demo';
        $this->footerUrl = 'https://github.com/aotr/open-a11y';
        $this->footerText = 'Accessibility tools by open-a11y';
        $this->menuTitle = 'Accessibility options';
        $this->language = 'en';

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
            'buttonSizeMobile' => $this->buttonSizeMobile,
            'showButton' => $this->showButton,
            'lang' => $this->language,
            'brand' => [
                'name' => $this->footerName,
                'url' => $this->footerUrl,
                'footerText' => $this->footerText,
                'primary' => $this->primary,
                'primaryDark' => $this->primary,
                'accent' => $this->accent,
            ],
            'labels' => [
                'widget.menuTitle' => $this->menuTitle,
            ],
        ]);
    }

    public function render(): View
    {
        return view('workbench::livewire.playground', [
            'config' => $this->config(),
        ]);
    }
}
