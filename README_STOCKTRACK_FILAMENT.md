# STOCK-TRACK Laravel Filament

STOCK-TRACK is a warehouse management application based on Laravel Filament.

## Scope

- CRUD master data: items, categories, suppliers, users.
- Stock transactions: incoming, outgoing, and adjustments.
- Automatic stock updates with validation that stock cannot be negative.
- Stock status monitoring: Safe, Low, Needs Restock.
- Dashboard with statistics, transaction charts, critical alerts, and recent transactions.
- Analysis of high demand / low demand from outgoing transaction history.
- Restock recommendations based on average usage.
- Export transaction history to Excel-compatible CSV and PDF.

## Architecture

This project has been cleaned to be Filament-first.

```txt
Laravel + Filament = Admin UI, CRUD, table, filter, export
MySQL              = Main database
Service Class      = Stock, restock, analytics logic
Blade              = Custom widget/page view for Filament
```

React/Inertia starter kit has been removed from this package to make the project structure lighter and not mixed with Filament.

## How to Run

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Open the admin panel:

```txt
http://127.0.0.1:8000/admin
```

Dummy accounts:

```txt
Warehouse Admin
email: admin@stocktrack.test
password: password

Supervisor
email: supervisor@stocktrack.test
password: password

Purchasing
email: purchasing@stocktrack.test
password: password
```

## Important Files

```txt
app/Filament/Resources      = CRUD table/form
app/Filament/Pages          = Custom pages
app/Filament/Widgets        = Dashboard widgets
app/Services                = Business logic
resources/views/filament    = Custom Blade UI for page/widget
resources/css/filament      = Filament theme
```

## MySQL Notes

The default `.env.example` is already pointing to MySQL:

```txt
DB_CONNECTION=mysql
DB_DATABASE=stock_track
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the credentials to match your local MySQL before migrating.