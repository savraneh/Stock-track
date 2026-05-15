import { SlidersHorizontal } from 'lucide-react';

import { Button } from '@/components/ui/button';

import { SearchInput } from '@/components/inventory/search-input';
import { FilterSelect } from '@/components/inventory/filter-select';

interface FilterBarProps {
    searchValue?: string;
    onSearchChange?: (value: string) => void;

    categoryValue?: string;
    onCategoryChange?: (value: string) => void;

    statusValue?: string;
    onStatusChange?: (value: string) => void;
}

const categoryOptions = [
    {
        label: 'All Categories',
        value: 'all',
    },
    {
        label: 'Electronics',
        value: 'electronics',
    },
    {
        label: 'Office Supplies',
        value: 'office',
    },
];

const statusOptions = [
    {
        label: 'Any Status',
        value: 'all',
    },
    {
        label: 'In Stock',
        value: 'in-stock',
    },
    {
        label: 'Low Stock',
        value: 'low-stock',
    },
    {
        label: 'Out of Stock',
        value: 'out-of-stock',
    },
];

export function FilterBar({
    searchValue,
    onSearchChange,

    categoryValue,
    onCategoryChange,

    statusValue,
    onStatusChange,
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

            <div className="flex flex-col gap-3 sm:flex-row">
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

                <Button variant="outline" size="icon">
                    <SlidersHorizontal className="h-4 w-4" />
                </Button>
            </div>
        </div>
    );
}
