# Cleanup Notes

File/folder yang dihapus karena tidak dipakai oleh versi Filament-first:

```txt
resources/js/
resources/css/app.css
resources/views/app.blade.php
app/Actions/Fortify/
app/Concerns/
app/Http/Controllers/Settings/
app/Http/Requests/Settings/
app/Http/Middleware/HandleInertiaRequests.php
app/Providers/FortifyServiceProvider.php
config/fortify.php
config/inertia.php
routes/settings.php
components.json
tsconfig.json
eslint.config.js
pnpm-workspace.yaml
.github/
database/database.sqlite
database/migrations/*two_factor*
```

Dependency React/Inertia/Fortify/Wayfinder juga dihapus dari `composer.json`, `package.json`, dan `vite.config.ts`.

Yang dipertahankan:

```txt
Filament Resources
Filament Pages
Filament Widgets
Blade views untuk widget/page
Filament theme CSS
Models + migrations + seeders
Stock/Demand/Restock services
Report export controller
```
