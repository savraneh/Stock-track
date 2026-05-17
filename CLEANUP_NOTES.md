# Cleanup Notes

Files/folders removed because they are unused by the Filament-first version:

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

Dependencies for React/Inertia/Fortify/Wayfinder were also removed from `composer.json`, `package.json`, and `vite.config.ts`.

What is preserved:

```txt
Filament Resources
Filament Pages
Filament Widgets
Blade views for widget/page
Filament theme CSS
Models + migrations + seeders
Stock/Demand/Restock services
Report export controller
```
