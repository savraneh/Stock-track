<x-filament-panels::page>
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Safe</p>
            <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $this->getSafeCount() }}</p>
            <p class="mt-1 text-sm text-slate-500">Stock above safety stock</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Low</p>
            <p class="mt-2 text-3xl font-bold text-orange-500">{{ $this->getLowCount() }}</p>
            <p class="mt-1 text-sm text-slate-500">Stock below safety stock</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Needs Restock</p>
            <p class="mt-2 text-3xl font-bold text-rose-600">{{ $this->getRestockCount() }}</p>
            <p class="mt-1 text-sm text-slate-500">Stock reached minimum level</p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5">
            <h2 class="text-lg font-semibold text-slate-900">Critical Alerts</h2>
            <p class="text-sm text-slate-500">Items with Low or Needs Restock status.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="stock-page-table">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="stock-table-left">Code</th>
                        <th class="stock-table-left">Item</th>
                        <th class="stock-table-left">Category</th>
                        <th class="stock-table-left">Stock</th>
                        <th class="stock-table-center">Min</th>
                        <th class="stock-table-center">Safety</th>
                        <th class="stock-table-center">Status</th>
                        <th class="stock-table-left">Supplier</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($this->getCriticalItems() as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="stock-table-left font-mono text-slate-700">{{ $item->code }}</td>
                            <td class="stock-table-left font-medium text-slate-900">{{ $item->name }}</td>
                            <td class="stock-table-left text-slate-600">{{ $item->category?->name ?? '-' }}</td>
                            <td class="stock-table-left font-semibold text-slate-900">{{ $item->stock }} {{ $item->unit }}</td>
                            <td class="stock-table-center text-slate-600">{{ $item->min_stock }}</td>
                            <td class="stock-table-center text-slate-600">{{ $item->safe_stock }}</td>
                            <td class="stock-table-center">
                                <span @class([
                                    'rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-rose-50 text-rose-700' => $item->stock_status->value === 'restock',
                                    'bg-orange-50 text-orange-700' => $item->stock_status->value === 'low',
                                ])>
                                    {{ $item->stock_status->label() }}
                                </span>
                            </td>
                            <td class="stock-table-left text-slate-600">{{ $item->supplier?->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500">No critical items yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
