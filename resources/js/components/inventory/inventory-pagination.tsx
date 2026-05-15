import { ChevronLeft, ChevronRight } from 'lucide-react';

import { Button } from '@/components/ui/button';

interface InventoryPaginationProps {
    itemsPerPage: number;
    onItemsPerPageChange: (value: number) => void;
    currentPage: number;
    totalPages: number;
}

export function InventoryPagination({
    currentPage,
    totalPages,
    itemsPerPage,
    onItemsPerPageChange,
}: InventoryPaginationProps) {
    return (
        <div className="flex flex-col gap-4 border-t p-4 sm:flex-row sm:items-center sm:justify-between">
            <p className="text-sm text-muted-foreground">
                Page {currentPage} of {totalPages}
            </p>

            <div className="flex items-center gap-2">
                <select
                    value={itemsPerPage}
                    onChange={(event) =>
                        onItemsPerPageChange(Number(event.target.value))
                    }
                    className="h-9 rounded-md border border-input bg-background px-3 text-sm"
                >
                    <option value={5}>5 rows</option>
                    <option value={10}>10 rows</option>
                    <option value={25}>25 rows</option>
                    <option value={50}>50 rows</option>
                </select>
                <Button
                    variant="outline"
                    size="icon"
                    disabled={currentPage === 1}
                >
                    <ChevronLeft className="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="icon"
                    disabled={currentPage === totalPages}
                >
                    <ChevronRight className="h-4 w-4" />
                </Button>
            </div>
        </div>
    );
}
