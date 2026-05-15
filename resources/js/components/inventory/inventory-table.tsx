import { PackageSearch } from 'lucide-react';
import { InventoryPagination } from '@/components/inventory/inventory-pagination';
import { StockIndicator } from '@/components/inventory/stock-indicator';
import { TableActions } from '@/components/inventory/table-actions';
import { EmptyState } from '@/components/shared/empty-state';
import { Badge } from '@/components/ui/badge';

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import type { InventoryItem } from '@/types/inventory';

interface InventoryTableProps {
    items: InventoryItem[];
    currentPage?: number;
    totalPages?: number;
    itemsPerPage: number;
    onPageChange: (page: number) => void;
    onItemsPerPageChange: (value: number) => void;
}

const columns = [
    {
        label: 'Item',
        className: 'w-[20%] text-center',
    },
    {
        label: 'Category',
        className: 'w-[20%] text-center',
    },
    {
        label: 'Stock',
        className: 'w-[20%] text-center',
    },
    {
        label: 'Min Stock',
        className: 'w-[15%] text-center',
    },
    {
        label: 'Price',
        className: 'w-[13%] text-center',
    },
    {
        label: 'Actions',
        className: 'w-[13%] text-center',
    },
];

export function InventoryTable({
    items,
    currentPage = 1,
    totalPages = 3,
    itemsPerPage,
    onPageChange,
    onItemsPerPageChange,
}: InventoryTableProps) {
    if (items.length === 0) {
        return (
            <EmptyState
                title="No items found"
                description="Try adjusting your filters or search query."
                icon={<PackageSearch className="h-10 w-10" />}
            />
        );
    }

    return (
        <div className="overflow-hidden rounded-xl">
            <div className="overflow-x-auto">
                <Table className="mt-6 min-w-[760px] table-fixed">
                    <TableHeader>
                        <TableRow>
                            {columns.map((column) => (
                                <TableHead
                                    key={column.label}
                                    className={column.className}
                                >
                                    {column.label}
                                </TableHead>
                            ))}
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        {items.map((item) => (
                            <TableRow key={item.id}>
                                <TableCell>
                                    <div className="min-w-0">
                                        <p className="truncate font-medium">
                                            {item.name}
                                        </p>

                                        <p className="truncate text-sm text-muted-foreground">
                                            {item.sku}
                                        </p>
                                    </div>
                                </TableCell>

                                <TableCell>
                                    <Badge variant="secondary">
                                        {item.category}
                                    </Badge>
                                </TableCell>

                                <TableCell>
                                    <StockIndicator
                                        current={item.stock}
                                        minimum={item.minimumStock}
                                        className="justify-center"
                                    />
                                </TableCell>

                                <TableCell className="font-medium">
                                    {item.minimumStock.toLocaleString()}
                                </TableCell>

                                <TableCell className="font-medium">
                                    ${item.price.toFixed(2)}
                                </TableCell>

                                <TableCell>
                                    <TableActions
                                        onEdit={() =>
                                            console.log('edit', item.id)
                                        }
                                        onDelete={() =>
                                            console.log('delete', item.id)
                                        }
                                    />
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </div>

            <InventoryPagination
                {...({
                    currentPage,
                    totalPages,
                    onPageChange,
                    onItemsPerPageChange,
                } as any)}
            />
        </div>
    );
}
