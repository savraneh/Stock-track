<x-filament-widgets::widget>
    <section class="stock-dashboard-panel overflow-hidden p-0">
        <div class="flex items-center justify-between gap-4 border-b border-[var(--stock-outline-variant)] px-6 py-5">
            <div>
                <h2 class="stock-panel-title">Recent Transactions</h2>
                <p class="stock-panel-subtitle">Latest stock movement history.</p>
            </div>
            <a href="{{ $this->getFullHistoryUrl() }}" class="stock-link-button">Full History</a>
        </div>

        <div class="overflow-x-auto">
            <table class="stock-recent-table">
                <thead>
                    <tr>
                        <th class="stock-table-left">Date/Time</th>
                        <th class="stock-table-left">SKU</th>
                        <th class="stock-table-left">Item Name</th>
                        <th class="stock-table-center">Type</th>
                        <th class="stock-table-center">Qty</th>
                        <th class="stock-table-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->getTransactions() as $transaction)
                        @php
                            $tone = $this->getTypeTone($transaction);
                        @endphp
                        <tr>
                            <td class="stock-table-left whitespace-nowrap">{{ $transaction->created_at?->format('M d, h:i A') }}</td>
                            <td class="stock-table-left font-mono text-[var(--stock-primary)]">{{ $transaction->item?->code ?? '-' }}</td>
                            <td class="stock-table-left font-medium text-[var(--stock-on-surface)]">{{ $transaction->item?->name ?? 'Deleted item' }}</td>
                            <td class="stock-table-center">
                                <span class="stock-transaction-type stock-tone-{{ $tone }}">
                                    <x-filament::icon :icon="$this->getTypeIcon($transaction)" class="h-4 w-4" />
                                    {{ $transaction->type->label() }}
                                </span>
                            </td>
                            <td class="stock-table-center font-bold">{{ $this->getQuantityLabel($transaction) }}</td>
                            <td class="stock-table-center">
                                <span class="stock-status-pill">Completed</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="stock-empty-state py-8">
                                    <x-filament::icon icon="heroicon-o-inbox" class="h-8 w-8" />
                                    <p>No transactions yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-filament-widgets::widget>
