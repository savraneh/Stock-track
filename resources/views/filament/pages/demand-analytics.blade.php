<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">High Demand Items</h2>
                <p class="text-sm text-slate-500">Barang paling sering keluar dari histori transaksi.</p>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($this->getHighDemandItems() as $item)
                    <div class="flex items-center justify-between gap-4 p-5">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                            <p class="text-sm text-slate-500">{{ $item->code }} · {{ $item->category?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600">{{ (int) $item->total_out }}</p>
                            <p class="text-xs text-slate-500">barang keluar</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">Belum ada transaksi barang keluar.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Low Demand Items</h2>
                <p class="text-sm text-slate-500">Barang dengan pemakaian rendah atau belum pernah keluar.</p>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($this->getLowDemandItems() as $item)
                    <div class="flex items-center justify-between gap-4 p-5">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                            <p class="text-sm text-slate-500">{{ $item->code }} · {{ $item->category?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-slate-700">{{ (int) $item->total_out }}</p>
                            <p class="text-xs text-slate-500">barang keluar</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">Belum ada data barang.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
