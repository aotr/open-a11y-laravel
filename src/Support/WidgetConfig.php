<?php

namespace Aotr\OpenA11y\Support;

use JsonException;

final class WidgetConfig
{
    /**
     * Resolve the package defaults and any component overrides into a single
     * configuration array understood by the open-a11y browser runtime.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function resolve(array $overrides = []): array
    {
        $brand = array_filter([
            'name' => config('open-a11y.brand.name'),
            'url' => config('open-a11y.brand.url'),
            'footerText' => config('open-a11y.brand.footer_text'),
            'primary' => config('open-a11y.brand.primary'),
            'primaryDark' => config('open-a11y.brand.primary_dark'),
            'accent' => config('open-a11y.brand.accent'),
        ], static fn (mixed $value): bool => $value !== null);

        $config = [
            'position' => config('open-a11y.position', 'bottom-right'),
            'side' => config('open-a11y.side', 'right'),
            'offset' => config('open-a11y.offset', [20, 20]),
            'blur' => (bool) config('open-a11y.blur', false),
            'buttonSize' => (int) config('open-a11y.button_size', 56),
            'showButton' => (bool) config('open-a11y.show_button', true),
            'lang' => config('open-a11y.language', 'en'),
            'brand' => $brand,
            'labels' => array_filter([
                'widget.menuTitle' => config('open-a11y.menu_title', 'Accessibility options'),
            ], static fn (mixed $value): bool => $value !== null),
        ];

        foreach ($overrides as $key => $value) {
            if ($value === null) {
                continue;
            }

            if ($key === 'brand' && is_array($value)) {
                $config['brand'] = array_merge(
                    $config['brand'],
                    array_filter($value, static fn (mixed $item): bool => $item !== null),
                );

                continue;
            }

            if ($key === 'labels' && is_array($value)) {
                $config['labels'] = array_merge(
                    $config['labels'],
                    array_filter($value, static fn (mixed $item): bool => $item !== null),
                );

                continue;
            }

            if ($key === 'offset' && is_array($value)) {
                $config['offset'] = array_values(array_replace($config['offset'], $value));

                continue;
            }

            $config[$key] = $value;
        }

        return $config;
    }

    /**
     * @param  array<string, mixed>  $config
     *
     * @throws JsonException
     */
    public static function toJson(array $config): string
    {
        return json_encode(
            $config,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
    }
}
