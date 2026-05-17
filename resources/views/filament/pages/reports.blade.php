<x-filament-panels::page>
    <div class="mb-4 flex justify-end gap-2">
        <a
            href="{{ route('reports.transactions.excel') }}"
            target="_blank"
            class="fi-btn fi-btn-color-primary">
            Download Excel/CSV
        </a>

        <a
            href="{{ route('reports.transactions.pdf') }}"
            target="_blank"
            class="fi-btn">
            Download PDF
        </a>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-5">
            <h2 class="text-lg font-semibold text-slate-900">Recent Transaction History</h2>
            <p class="text-sm text-slate-500">Use the button on the top right to export reports.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="stock-page-table stock-page-table--reports">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="stock-table-left stock-nowrap-col">Date</th>
                        <th class="stock-table-left">Item</th>
                        <th class="stock-table-left">Category</th>
                        <th class="stock-table-center stock-nowrap-col">Type</th>
                        <th class="stock-table-center whitespace-nowrap">Quantity</th>
                        <th class="stock-table-center whitespace-nowrap">Before</th>
                        <th class="stock-table-center whitespace-nowrap">After</th>
                        <th class="stock-table-center stock-nowrap-col">Officer</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($this->getRecentTransactions() as $transaction)
                    <tr class="hover:bg-slate-50">
                        <td class="stock-table-left stock-nowrap-col text-slate-600">{{ $transaction->created_at?->format('d M Y H:i') }}</td>
                        <td class="stock-table-left">
                            <p class="font-medium text-slate-900">{{ $transaction->item?->name }}</p>
                            <p class="text-xs text-slate-500">{{ $transaction->item?->code }}</p>
                        </td>
                        <td class="stock-table-left text-slate-600">{{ $transaction->item?->category?->name ?? '-' }}</td>
                        <td class="stock-table-center stock-nowrap-col">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $transaction->type->label() }}
                            </span>
                        </td>
                        <td class="stock-table-center whitespace-nowrap font-semibold text-slate-900">{{ $transaction->quantity }}</td>
                        <td class="stock-table-center whitespace-nowrap text-slate-600">{{ $transaction->stock_before }}</td>
                        <td class="stock-table-center whitespace-nowrap text-slate-600">{{ $transaction->stock_after }}</td>
                        <td class="stock-table-center stock-nowrap-col text-slate-600">{{ $transaction->user?->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500">No transaction history yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
