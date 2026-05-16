import { ChevronLeft, ChevronRight } from 'lucide-react';

import { Button } from '@/components/ui/button';
import { FilterSelect } from '@/components/inventory/filter-select';

interface InventoryPaginationProps {
    currentPage: number;
    totalPages: number;
    itemsPerPage: number;
    totalItems: number;
    onPageChange: (page: number) => void;
    onItemsPerPageChange: (value: number) => void;
}

const rowsPerPageOptions = [
    { label: '5 rows', value: '5' },
    { label: '10 rows', value: '10' },
    { label: '25 rows', value: '25' },
    { label: '50 rows', value: '50' },
];

export function InventoryPagination({
    currentPage,
    totalPages,
    itemsPerPage,
    totalItems,
    onPageChange,
    onItemsPerPageChange,
}: InventoryPaginationProps) {
    const canGoPrevious = currentPage > 1;
    const canGoNext = currentPage < totalPages;

    return (
        <div className="flex flex-col gap-4 border-t px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p className="text-sm text-muted-foreground">
                Showing page{' '}
                <span className="font-medium text-foreground">
                    {currentPage}
                </span>{' '}
                of{' '}
                <span className="font-medium text-foreground">
                    {totalPages}
                </span>
                <span className="hidden sm:inline">
                    {' '}
                    · {totalItems.toLocaleString()} items
                </span>
            </p>

            <div className="flex flex-col gap-3 sm:flex-row sm:items-center">
                <FilterSelect
                    aria-label="Rows per page"
                    options={rowsPerPageOptions}
                    value={String(itemsPerPage)}
                    onValueChange={(value) =>
                        onItemsPerPageChange(Number(value))
                    }
                    className="w-full sm:w-[130px]"
                    side="top"
                />

                <div className="flex items-center gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        size="icon"
                        disabled={!canGoPrevious}
                        onClick={() => onPageChange(currentPage - 1)}
                        aria-label="Go to previous page"
                    >
                        <ChevronLeft className="h-4 w-4" />
                    </Button>

                    <Button
                        type="button"
                        variant="outline"
                        size="icon"
                        disabled={!canGoNext}
                        onClick={() => onPageChange(currentPage + 1)}
                        aria-label="Go to next page"
                    >
                        <ChevronRight className="h-4 w-4" />
                    </Button>
                </div>
            </div>
        </div>
    );
}
