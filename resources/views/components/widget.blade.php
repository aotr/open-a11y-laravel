<div
    {{ $attributes }}
    data-open-a11y="{{ $widgetKey }}"
    data-open-a11y-config="{{ $json }}"
    hidden
></div>

@once
    @include('open-a11y::partials.scripts')
@endonce
