@php
    $assetPath = trim((string) config('open-a11y.assets.path', 'vendor/open-a11y'), '/');
    $assetBase = rtrim((string) (config('open-a11y.assets.url') ?: asset($assetPath)), '/');
@endphp
<script src="{{ $assetBase }}/open-a11y.js" defer></script>
<script src="{{ $assetBase }}/open-a11y-laravel.js" defer></script>
