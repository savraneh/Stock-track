<x-filament-widgets::widget>
    <div class="stock-dashboard-stats grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($this->getStats() as $stat)
            <section class="stock-stat-card stock-tone-{{ $stat['tone'] }}">
                <div class="flex flex-1 flex-col">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="stock-stat-label">{{ $stat['label'] }}</p>
                            <h3 class="stock-stat-value">{{ $stat['value'] }}</h3>
                        </div>

                        <div class="stock-stat-icon">
                            <x-filament::icon :icon="$stat['icon']" class="h-6 w-6" />
                        </div>
                    </div>

                    <div class="mt-auto pt-7">
                        <p class="stock-stat-description">{{ $stat['description'] }}</p>
                    </div>
                </div>
            </section>
        @endforeach
    </div>
</x-filament-widgets::widget>
