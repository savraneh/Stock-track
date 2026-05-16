import { SlidersHorizontal, X } from 'lucide-react';

import { Button } from '@/components/ui/button';
import { FilterSelect } from '@/components/inventory/filter-select';
import { SearchInput } from '@/components/inventory/search-input';
import type { InventoryFilterOption } from '@/types/inventory';

interface FilterBarProps {
    searchValue: string;
    onSearchChange: (value: string) => void;
    categoryValue: string;
    onCategoryChange: (value: string) => void;
    statusValue: string;
    onStatusChange: (value: string) => void;
    categoryOptions: InventoryFilterOption[];
    statusOptions: InventoryFilterOption[];
    hasActiveFilters?: boolean;
    onResetFilters?: () => void;
}

export function FilterBar({
    searchValue,
    onSearchChange,
    categoryValue,
    onCategoryChange,
    statusValue,
    onStatusChange,
    categoryOptions,
    statusOptions,
    hasActiveFilters = false,
    onResetFilters,
}: FilterBarProps) {
    return (
        <div className="flex flex-col gap-4 rounded-xl border bg-card p-4 lg:flex-row lg:items-center">
            <div className="flex-1">
                <SearchInput
                    placeholder="Search by name or SKU..."
                    value={searchValue}
                    onChange={onSearchChange}
                />
            </div>

            <div className="flex flex-col gap-3 sm:flex-row sm:items-center">
                <FilterSelect
                    placeholder="Category"
                    options={categoryOptions}
                    value={categoryValue}
                    onValueChange={onCategoryChange}
                />

                <FilterSelect
                    placeholder="Status"
                    options={statusOptions}
                    value={statusValue}
                    onValueChange={onStatusChange}
                />

                {hasActiveFilters && (
                    <Button type="button" variant="outline" onClick={onResetFilters} className="sm:w-auto">
                        <X className="h-4 w-4" />
                        Reset
                    </Button>
                )}

                <Button type="button" variant="outline" size="icon" aria-label="Open advanced filters">
                    <SlidersHorizontal className="h-4 w-4" />
                </Button>
            </div>
        </div>
    );
}
