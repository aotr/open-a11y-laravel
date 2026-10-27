import { defineConfig } from "vite-plus";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import vue from "@vitejs/plugin-vue";
import { svelte } from "@sveltejs/vite-plugin-svelte";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "workbench/resources/js/inertia-react.tsx",
        "workbench/resources/js/inertia-vue.ts",
        "workbench/resources/js/inertia-svelte.ts",
      ],
      publicDirectory: "vendor/orchestra/testbench-core/laravel/public",
      refresh: true,
    }),
    react(),
    vue(),
    svelte(),
  ],
  fmt: {
    ignorePatterns: ["vendor/**", "resources/dist/**", "workbench/public/**", ".phpunit.cache/**"],
  },
  lint: {
    ignorePatterns: ["vendor/**", "resources/dist/**", "workbench/public/**", ".phpunit.cache/**"],
  },
  server: {
    port: 4181,
    strictPort: true,
  },
});
