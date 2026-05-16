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
    currentPage: number;
    totalPages: number;
    itemsPerPage: number;
    totalItems: number;
    onPageChange: (page: number) => void;
    onItemsPerPageChange: (value: number) => void;
}

const columns = [
    { label: 'Item', className: 'w-[28%] text-left' },
    { label: 'Category', className: 'w-[18%] text-left' },
    { label: 'Stock', className: 'w-[20%] text-center' },
    { label: 'Min Stock', className: 'w-[14%] text-right' },
    { label: 'Price', className: 'w-[12%] text-right' },
    { label: 'Actions', className: 'w-[8%] text-center' },
];

export function InventoryTable({
    items,
    currentPage,
    totalPages,
    itemsPerPage,
    totalItems,
    onPageChange,
    onItemsPerPageChange,
}: InventoryTableProps) {
    return (
        <div className="mt-6 overflow-hidden rounded-xl border bg-card">
            {items.length === 0 ? (
                <EmptyState
                    title="No items found"
                    description="Try adjusting your filters or search query."
                    icon={<PackageSearch className="h-10 w-10" />}
                    className="m-4 min-h-[320px] border-dashed"
                />
            ) : (
                <div className="overflow-x-auto">
                    <Table className="min-w-[840px] table-fixed">
                        <TableHeader>
                            <TableRow>
                                {columns.map((column) => (
                                    <TableHead key={column.label} className={column.className}>
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
                                            <p className="truncate font-medium">{item.name}</p>
                                            <p className="truncate text-sm text-muted-foreground">{item.sku}</p>
                                        </div>
                                    </TableCell>

                                    <TableCell>
                                        <Badge variant="secondary" className="max-w-full truncate">
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

                                    <TableCell className="text-right font-medium">
                                        {item.minimumStock.toLocaleString()}
                                    </TableCell>

                                    <TableCell className="text-right font-medium">
                                        {new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD',
                                        }).format(item.price)}
                                    </TableCell>

                                    <TableCell>
                                        <TableActions
                                            onEdit={() => console.log('edit', item.id)}
                                            onDelete={() => console.log('delete', item.id)}
                                        />
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            )}

            <InventoryPagination
                currentPage={currentPage}
                totalPages={totalPages}
                itemsPerPage={itemsPerPage}
                totalItems={totalItems}
                onPageChange={onPageChange}
                onItemsPerPageChange={onItemsPerPageChange}
            />
        </div>
    );
}
