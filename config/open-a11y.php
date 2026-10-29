<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Floating button
    |--------------------------------------------------------------------------
    |
    | Defaults used when a Blade or Livewire widget does not override them.
    | Every value maps directly to the open-a11y browser runtime config.
    |
    */

    'position' => 'bottom-right',

    'side' => 'right',

    'offset' => [20, 20],

    'blur' => false,

    'button_size' => 56,

    'button_size_mobile' => 44,

    'show_button' => true,

    /*
    |--------------------------------------------------------------------------
    | Language and copy
    |--------------------------------------------------------------------------
    */

    'language' => 'en',

    'menu_title' => 'Accessibility options',

    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    |
    | The footer is hidden when both name and footer_text are empty. Set
    | footer_text to an empty string to hide a footer that would otherwise
    | be generated from the brand name.
    |
    */

    'brand' => [
        'name' => null,
        'url' => null,
        'footer_text' => null,
        'primary' => '#0f6b4f',
        'primary_dark' => '#0a4a37',
        'accent' => '#d4a13a',
    ],

    /*
    |--------------------------------------------------------------------------
    | Published assets
    |--------------------------------------------------------------------------
    |
    | Assets are published to public/vendor/open-a11y. Set a full URL here to
    | serve the browser bundle from a CDN instead.
    |
    */

    'assets' => [
        'path' => 'vendor/open-a11y',
        'url' => null,
    ],

];
