/**
 * open-a11y Laravel auto-init.
 *
 * Mounts one open-a11y widget from elements carrying data-open-a11y
 * attributes, reads their JSON config, and remounts on the
 * window "open-a11y:update" event emitted by the Livewire component.
 *
 * Accessibility state lives in the shared engine and localStorage, so a
 * remount keeps the visitor's selected tools and language.
 */
(function () {
    'use strict';

    if (window.__openA11yLaravelBooted) {
        return;
    }

    window.__openA11yLaravelBooted = true;

    var OpenA11y = window.OpenA11y;

    if (!OpenA11y) {
        console.error('[open-a11y] Browser bundle not found. Load open-a11y.js before open-a11y-laravel.js.');
        return;
    }

    var SELECTOR = '[data-open-a11y]';
    var UPDATE_EVENT = 'open-a11y:update';
    var engine = null;
    var bootPromise = null;
    var controller = null;
    var active = null;

    function query() {
        return Array.prototype.slice.call(document.querySelectorAll(SELECTOR));
    }

    function keyOf(element) {
        return element.getAttribute('data-open-a11y') || 'default';
    }

    function readConfig(element) {
        var raw = element.getAttribute('data-open-a11y-config') || '{}';

        try {
            var parsed = JSON.parse(raw);

            return parsed && typeof parsed === 'object' && !Array.isArray(parsed) ? parsed : {};
        } catch (error) {
            console.warn('[open-a11y] Could not parse data-open-a11y-config.', error);

            return {};
        }
    }

    function ensureEngine() {
        if (!bootPromise) {
            engine = new OpenA11y.AccessibilityEngine({ storage: OpenA11y.localStorageAdapter });
            bootPromise = engine.init();
        }

        return bootPromise;
    }

    function findElement(key, fallback) {
        var elements = query();
        var matches = key
            ? elements.filter(function (element) {
                return keyOf(element) === key;
            })
            : [];

        if (matches.length) {
            return matches[matches.length - 1];
        }

        return fallback === false ? null : elements[elements.length - 1] || null;
    }

    function remount(target) {
        return ensureEngine().then(function () {
            var config = target.config || {};
            var signature = JSON.stringify(config);
            var configLanguage = config.lang || config.defaultLanguage || null;

            if (active && active.key === target.key && active.signature === signature) {
                return;
            }

            var languageChange = active && configLanguage && configLanguage !== active.configLanguage
                ? engine.setLanguage(configLanguage)
                : Promise.resolve();

            return Promise.resolve(languageChange).then(function () {
                if (controller) {
                    controller.destroy();
                    controller = null;
                }

                controller = OpenA11y.createAccessibilityUI(engine, { config: config });
                active = {
                    key: target.key,
                    config: config,
                    signature: signature,
                    configLanguage: configLanguage
                };

                var element = findElement(target.key, false);

                if (element) {
                    element.setAttribute('data-open-a11y-config', signature);
                }
            });
        });
    }

    function mount(element) {
        if (!element) {
            return;
        }

        remount({ key: keyOf(element), config: readConfig(element) }).catch(function (error) {
            console.error('[open-a11y] Could not mount the accessibility widget.', error);
        });
    }

    function boot() {
        var elements = query();

        if (!elements.length) {
            if (controller) {
                controller.destroy();
                controller = null;
                active = null;
            }

            return;
        }

        var preferred = active
            ? elements.filter(function (element) {
                return keyOf(element) === active.key;
            }).pop()
            : null;

        mount(preferred || elements[elements.length - 1]);
    }

    window.addEventListener(UPDATE_EVENT, function (event) {
        var detail = event && event.detail ? event.detail : {};
        var key = detail.key || detail.widgetKey || null;

        if (detail.config && typeof detail.config === 'object') {
            remount({
                key: key || 'default',
                config: detail.config
            }).catch(function (error) {
                console.error('[open-a11y] Could not apply the updated widget config.', error);
            });

            return;
        }

        mount(findElement(key));
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

    document.addEventListener('livewire:navigated', function () {
        active = null;
        boot();
    });
})();
