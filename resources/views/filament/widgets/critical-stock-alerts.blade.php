<x-filament-widgets::widget>
    <section class="stock-dashboard-panel stock-equal-dashboard-panel h-full">
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h2 class="stock-panel-title">Critical Alerts</h2>
                <p class="stock-panel-subtitle">Items below safety stock.</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($this->getItems() as $item)
                @php
                    $status = $item->stock_status;
                    $tone = $status->value === 'restock' ? 'danger' : 'tertiary';
                @endphp

                <article class="stock-alert-card stock-tone-{{ $tone }}">
                    <div class="stock-alert-icon">
                        <x-filament::icon :icon="$status->value === 'restock' ? 'heroicon-m-exclamation-circle' : 'heroicon-m-arrow-trending-down'" class="h-5 w-5" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="stock-alert-title">{{ $item->name }}</p>
                        <p class="stock-alert-meta">
                            {{ number_format($item->stock) }} {{ $item->unit }} left • Min: {{ number_format($item->min_stock) }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="stock-empty-state">
                    <x-filament::icon icon="heroicon-o-check-circle" class="h-8 w-8" />
                    <p>No critical stock alerts.</p>
                </div>
            @endforelse
        </div>

        <a href="{{ $this->getAllAlertsUrl() }}" class="stock-panel-action">
            All Stock Alerts
        </a>
    </section>
</x-filament-widgets::widget>
