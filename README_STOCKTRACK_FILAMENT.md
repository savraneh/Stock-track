# STOCK-TRACK Laravel Filament

STOCK-TRACK adalah aplikasi warehouse management berbasis Laravel Filament.

## Scope

- CRUD master data: barang, kategori, supplier, user.
- Transaksi stok masuk, keluar, dan penyesuaian stok.
- Update stok otomatis dengan validasi stok tidak boleh minus.
- Monitoring status stok: Aman, Menipis, Perlu Restock.
- Dashboard statistik, grafik transaksi, critical alerts, dan recent transactions.
- Analisis high demand / low demand dari histori barang keluar.
- Rekomendasi restock berdasarkan rata-rata pemakaian.
- Export histori transaksi ke Excel-compatible CSV dan PDF.

## Architecture

Project ini sudah dibersihkan menjadi Filament-first.

```txt
Laravel + Filament = UI admin, CRUD, table, filter, export
MySQL              = database utama
Service Class      = logic stok, restock, analytics
Blade              = custom widget/page view Filament
```

React/Inertia starter kit sudah dihapus dari package ini supaya struktur project lebih ringan dan tidak bercampur dengan Filament.

## Cara menjalankan

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Buka panel admin:

```txt
http://127.0.0.1:8000/admin
```

Akun dummy:

```txt
Admin Gudang
email: admin@stocktrack.test
password: password

Supervisor
email: supervisor@stocktrack.test
password: password

Bagian Pembelian
email: purchasing@stocktrack.test
password: password
```

## File penting

```txt
app/Filament/Resources      = CRUD table/form
app/Filament/Pages          = halaman custom
app/Filament/Widgets        = dashboard widgets
app/Services                = business logic
resources/views/filament    = custom Blade UI untuk page/widget
resources/css/filament      = theme Filament
```

## Catatan MySQL

Default `.env.example` sudah diarahkan ke MySQL:

```txt
DB_CONNECTION=mysql
DB_DATABASE=stock_track
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan credential dengan MySQL lokalmu sebelum migrate.
