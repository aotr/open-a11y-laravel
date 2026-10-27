@extends('workbench::layout')

@section('title', 'Livewire component')
@section('page', 'livewire')

@section('content')
    @include('workbench::partials.hero', [
        'number' => '02',
        'kicker' => 'Livewire component',
        'headline' => 'Accessibility that<br><em>answers back.</em>',
        'lede' => 'Every control is a Livewire property. Every change is a new config, handed to the same runtime without losing what the visitor already chose.',
        'surface' => 'Livewire',
    ])

    <section class="oa-workbench" aria-labelledby="livewire-demo-title">
        <div class="oa-explainer">
            <p class="oa-kicker">The component</p>
            <h2 id="livewire-demo-title">Reactive properties, one runtime.</h2>
            <p class="oa-lede">
                The Livewire component exposes the widget's important knobs as public
                properties. Change one and the component dispatches a browser event;
                the package remounts the widget with the new config.
            </p>

            <ol class="oa-notes">
                <li>
                    <strong>Props are public.</strong>
                    Position, side, offsets, blur, button size, colors, footer copy,
                    menu title, language, and button visibility are all bindable.
                </li>
                <li>
                    <strong>Updates remount, not reset.</strong>
                    The component emits <code>open-a11y:update</code> after every change.
                    The shared engine keeps the selected tools and language.
                </li>
                <li>
                    <strong>One bundle, every surface.</strong>
                    This page loads the same standalone browser bundle as the Blade demo.
                </li>
            </ol>

            <div class="oa-snippet">
                <div class="oa-snippet__head">
                    <span>Livewire</span>
                    <span>resources/views</span>
                </div>
                <pre><code>&lt;livewire:open-a11y::widget
    position="top-left"
    :blur="true"
    primary="#0f6b4f"
/&gt;</code></pre>
            </div>

            <p class="oa-footnote">
                The controls on the right belong to the demo's Livewire component;
                the widget itself is the nested <code>open-a11y::widget</code>.
            </p>
        </div>

        <livewire:open-a11y-playground />
    </section>
@endsection
