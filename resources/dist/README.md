# Browser assets

- `open-a11y.js` — unmodified standalone IIFE build of the upstream
  [`@aotr/open-a11y`](https://github.com/aotr/open-a11y) runtime, currently
  **2.2.0**. Do not hand-edit.
- `open-a11y-laravel.js` — the Laravel auto-init script: reads
  `data-open-a11y-config`, mounts the widget once, keeps the visitor's state in
  `localStorage`, and remounts on the `open-a11y:update` browser event.

Publish both files to `public/vendor/open-a11y`:

```bash
php artisan vendor:publish --tag=open-a11y-assets
```
