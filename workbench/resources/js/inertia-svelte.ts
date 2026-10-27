import { createInertiaApp } from "@inertiajs/svelte";
import { mount } from "svelte";
import { engine } from "./accessibility-engine";

void engine.init().then(() =>
  createInertiaApp({
    resolve: (name) => import(`./pages/${name}.svelte`),
    setup({ el, App, props }) {
      mount(App, { target: el, props });
    },
    progress: { color: "#b43c14" },
  }),
);
