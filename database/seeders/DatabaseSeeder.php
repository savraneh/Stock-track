<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use App\Services\RestockRecommendationService;
use App\Services\StockService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@stocktrack.test'],
            [
                'name' => 'Admin Gudang',
                'password' => 'password',
                'role' => UserRole::Admin,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'supervisor@stocktrack.test'],
            [
                'name' => 'Supervisor',
                'password' => 'password',
                'role' => UserRole::Supervisor,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'purchasing@stocktrack.test'],
            [
                'name' => 'Bagian Pembelian',
                'password' => 'password',
                'role' => UserRole::Purchasing,
            ],
        );

        $categories = collect([
            ['name' => 'Bahan Baku', 'storage_zone' => 'Gudang A', 'description' => 'Material utama proses produksi.'],
            ['name' => 'Sparepart Mesin', 'storage_zone' => 'Rak B', 'description' => 'Komponen perawatan mesin produksi.'],
            ['name' => 'Packaging', 'storage_zone' => 'Gudang C', 'description' => 'Kemasan dan kebutuhan pengiriman.'],
            ['name' => 'Peralatan Operasional', 'storage_zone' => 'Rak D', 'description' => 'Alat bantu kegiatan gudang.'],
        ])->mapWithKeys(fn (array $data): array => [
            $data['name'] => Category::query()->updateOrCreate(['name' => $data['name']], $data),
        ]);

        $suppliers = collect([
            ['name' => 'PT Sumber Material', 'contact_person' => 'Raka', 'phone' => '0812-1000-2000', 'email' => 'raka@sumbermaterial.test', 'address' => 'Surabaya'],
            ['name' => 'CV Mesin Prima', 'contact_person' => 'Dewi', 'phone' => '0813-3000-4000', 'email' => 'dewi@mesinprima.test', 'address' => 'Malang'],
            ['name' => 'Packaging Nusantara', 'contact_person' => 'Nina', 'phone' => '0815-5000-6000', 'email' => 'nina@packnusantara.test', 'address' => 'Sidoarjo'],
        ])->mapWithKeys(fn (array $data): array => [
            $data['name'] => Supplier::query()->updateOrCreate(['name' => $data['name']], $data),
        ]);

        $items = [
            ['code' => 'BB-001', 'name' => 'Plat Baja 2mm', 'category' => 'Bahan Baku', 'supplier' => 'PT Sumber Material', 'unit' => 'lembar', 'stock' => 120, 'min_stock' => 40, 'safe_stock' => 80, 'unit_price' => 125000],
            ['code' => 'BB-002', 'name' => 'Aluminium Coil', 'category' => 'Bahan Baku', 'supplier' => 'PT Sumber Material', 'unit' => 'roll', 'stock' => 18, 'min_stock' => 20, 'safe_stock' => 35, 'unit_price' => 850000],
            ['code' => 'SP-001', 'name' => 'Bearing 6204', 'category' => 'Sparepart Mesin', 'supplier' => 'CV Mesin Prima', 'unit' => 'pcs', 'stock' => 32, 'min_stock' => 15, 'safe_stock' => 30, 'unit_price' => 45000],
            ['code' => 'SP-002', 'name' => 'V-Belt A42', 'category' => 'Sparepart Mesin', 'supplier' => 'CV Mesin Prima', 'unit' => 'pcs', 'stock' => 8, 'min_stock' => 10, 'safe_stock' => 20, 'unit_price' => 65000],
            ['code' => 'PK-001', 'name' => 'Karton Box Medium', 'category' => 'Packaging', 'supplier' => 'Packaging Nusantara', 'unit' => 'pcs', 'stock' => 260, 'min_stock' => 100, 'safe_stock' => 180, 'unit_price' => 4500],
            ['code' => 'PK-002', 'name' => 'Bubble Wrap 50m', 'category' => 'Packaging', 'supplier' => 'Packaging Nusantara', 'unit' => 'roll', 'stock' => 14, 'min_stock' => 12, 'safe_stock' => 25, 'unit_price' => 78000],
            ['code' => 'OP-001', 'name' => 'Sarung Tangan Safety', 'category' => 'Peralatan Operasional', 'supplier' => 'PT Sumber Material', 'unit' => 'pair', 'stock' => 55, 'min_stock' => 30, 'safe_stock' => 60, 'unit_price' => 12000],
            ['code' => 'OP-002', 'name' => 'Label Barcode', 'category' => 'Peralatan Operasional', 'supplier' => 'Packaging Nusantara', 'unit' => 'roll', 'stock' => 7, 'min_stock' => 15, 'safe_stock' => 25, 'unit_price' => 35000],
        ];

        foreach ($items as $data) {
            Item::query()->updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'category_id' => $categories[$data['category']]->id,
                    'supplier_id' => $suppliers[$data['supplier']]->id,
                    'unit' => $data['unit'],
                    'stock' => $data['stock'],
                    'min_stock' => $data['min_stock'],
                    'safe_stock' => $data['safe_stock'],
                    'unit_price' => $data['unit_price'],
                ],
            );
        }

        $stockService = app(StockService::class);
        $transactionSamples = [
            ['code' => 'BB-001', 'type' => TransactionType::StockOut, 'quantity' => 12, 'description' => 'Pemakaian produksi shift pagi'],
            ['code' => 'BB-001', 'type' => TransactionType::StockOut, 'quantity' => 8, 'description' => 'Pemakaian produksi shift sore'],
            ['code' => 'PK-001', 'type' => TransactionType::StockOut, 'quantity' => 45, 'description' => 'Packaging pesanan harian'],
            ['code' => 'PK-001', 'type' => TransactionType::StockIn, 'quantity' => 80, 'description' => 'Restock dari supplier'],
            ['code' => 'SP-002', 'type' => TransactionType::StockOut, 'quantity' => 2, 'description' => 'Maintenance mesin line 2'],
            ['code' => 'OP-002', 'type' => TransactionType::StockOut, 'quantity' => 3, 'description' => 'Labeling batch produksi'],
            ['code' => 'SP-001', 'type' => TransactionType::StockOut, 'quantity' => 4, 'description' => 'Penggantian bearing'],
        ];

        foreach ($transactionSamples as $sample) {
            $stockService->recordTransaction(
                item: Item::query()->where('code', $sample['code'])->firstOrFail(),
                type: $sample['type'],
                quantity: $sample['quantity'],
                user: $admin,
                description: $sample['description'],
            );
        }

        app(RestockRecommendationService::class)->generateAllCritical();
    }
}
