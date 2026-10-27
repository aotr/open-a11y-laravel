import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import { AccessibilityEngine, localStorageAdapter } from "@aotr/open-a11y";
import { AccessibilityProvider } from "@aotr/open-a11y/react";

const engine = new AccessibilityEngine({ storage: localStorageAdapter });

void createInertiaApp({
  resolve: (name) => import(`./pages/${name}.tsx`),
  setup({ el, App, props }) {
    createRoot(el).render(
      <AccessibilityProvider engine={engine} autoInit>
        <App {...props} />
      </AccessibilityProvider>,
    );
  },
  progress: { color: "#b43c14" },
});
