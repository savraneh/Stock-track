<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">High Demand Items</h2>
                <p class="text-sm text-slate-500">Items most frequently leaving from transaction history.</p>
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
                            <p class="text-xs text-slate-500">items out</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">No outgoing item transactions yet.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Low Demand Items</h2>
                <p class="text-sm text-slate-500">Items with low usage or never left.</p>
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
                            <p class="text-xs text-slate-500">items out</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">No item data yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
