import { defineConfig } from "vite-plus";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [
    laravel({
      input: ["workbench/resources/js/inertia-react.tsx", "workbench/resources/js/inertia-vue.ts"],
      publicDirectory: "vendor/orchestra/testbench-core/laravel/public",
      refresh: true,
    }),
    react(),
    vue(),
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
