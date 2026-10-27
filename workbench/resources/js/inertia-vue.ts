import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createAccessibilityPlugin } from "@aotr/open-a11y/vue";
import { engine } from "./accessibility-engine";

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
