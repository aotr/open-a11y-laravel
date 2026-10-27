import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { AccessibilityEngine, localStorageAdapter } from "@aotr/open-a11y";
import { createAccessibilityPlugin } from "@aotr/open-a11y/vue";

const engine = new AccessibilityEngine({ storage: localStorageAdapter });

void engine.init().then(() =>
  createInertiaApp({
    resolve: (name) => import(`./pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
      createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(createAccessibilityPlugin(engine))
        .mount(el);
    },
    progress: { color: "#b43c14" },
  }),
);
