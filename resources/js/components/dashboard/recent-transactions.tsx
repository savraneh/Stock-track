import { ArrowDownLeft, ArrowRightLeft, ArrowUpRight } from 'lucide-react';
import { useState } from 'react';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { StatusBadge } from '@/components/ui/status-badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { cn } from '@/lib/utils';

type Transaction = {
    id: number;
    date: string;
    sku: string;
    item: string;
    type: 'in' | 'out' | 'internal';
    quantity: string;
    status: 'completed' | 'pending' | 'failed';
};

const transactions: Transaction[] = [
    {
        id: 1,
        date: 'Oct 24, 09:42 AM',
        sku: 'ELC-9042',
        item: 'Main CPU Unit Gen 4',
        type: 'in',
        quantity: '+250',
        status: 'completed',
    },
    {
        id: 2,
        date: 'Oct 24, 08:15 AM',
        sku: 'WHS-3321',
        item: 'Packing Tape Reinforced',
        type: 'out',
        quantity: '-48',
        status: 'completed',
    },
    {
        id: 3,
        date: 'Oct 23, 04:50 PM',
        sku: 'STG-1109',
        item: 'Storage Rack Heavy Duty',
        type: 'internal',
        quantity: '5',
        status: 'pending',
    },
    {
        id: 4,
        date: 'Oct 23, 02:10 PM',
        sku: 'PRT-2201',
        item: 'Thermal Printer Unit',
        type: 'out',
        quantity: '-12',
        status: 'failed',
    },
    {
        id: 5,
        date: 'Oct 23, 11:35 AM',
        sku: 'ELC-7812',
        item: 'Power Supply Module 750W',
        type: 'in',
        quantity: '+80',
        status: 'completed',
    },
    {
        id: 6,
        date: 'Oct 22, 05:18 PM',
        sku: 'CAB-4508',
        item: 'USB-C Industrial Cable',
        type: 'out',
        quantity: '-120',
        status: 'completed',
    },
    {
        id: 7,
        date: 'Oct 22, 01:25 PM',
        sku: 'STG-5540',
        item: 'Warehouse Bin Large',
        type: 'internal',
        quantity: '18',
        status: 'pending',
    },
    {
        id: 8,
        date: 'Oct 21, 10:05 AM',
        sku: 'LBL-1204',
        item: 'Barcode Label Roll',
        type: 'out',
        quantity: '-300',
        status: 'failed',
    },
];

const previewTransactionCount = 3;
const dashboardTransactionLimit = 10;

const columns = [
    { label: 'Date', className: 'w-1/6' },
    { label: 'SKU', className: 'w-1/6' },
    { label: 'Item', className: 'w-1/6' },
    { label: 'Type', className: 'w-1/6' },
    { label: 'Qty', className: 'w-1/6' },
    { label: 'Status', className: 'w-1/6' },
];

const typeConfig = {
    in: {
        label: 'Stock In',
        icon: ArrowDownLeft,
        className: 'text-primary',
    },
    out: {
        label: 'Stock Out',
        icon: ArrowUpRight,
        className: 'text-destructive',
    },
    internal: {
        label: 'Internal',
        icon: ArrowRightLeft,
        className: 'text-muted-foreground',
    },
};

const statusLabel: Record<Transaction['status'], string> = {
    completed: 'Completed',
    pending: 'Pending',
    failed: 'Failed',
};

export function RecentTransactions() {
    const [showAll, setShowAll] = useState(false);
    const dashboardTransactions = transactions.slice(
        0,
        dashboardTransactionLimit,
    );
    const hasMoreTransactions =
        dashboardTransactions.length > previewTransactionCount;
    const visibleTransactions = showAll
        ? dashboardTransactions
        : dashboardTransactions.slice(0, previewTransactionCount);

    return (
        <Card className="rounded-2xl border-border/60 shadow-sm">
            <CardHeader className="flex flex-row items-center justify-between">
                <CardTitle className="text-lg font-semibold">
                    Recent Transactions
                </CardTitle>

                <button
                    type="button"
                    aria-expanded={showAll}
                    onClick={() => setShowAll((current) => !current)}
                    className="text-sm font-medium text-primary hover:underline"
                >
                    {showAll ? 'View Less' : 'View All'}
                </button>
            </CardHeader>

            <CardContent>
                <Table className="min-w-[900px] table-fixed">
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
                        {visibleTransactions.map((transaction) => {
                            const type = typeConfig[transaction.type];
                            const TypeIcon = type.icon;

                            return (
                                <TableRow key={transaction.id}>
                                    <TableCell className="whitespace-nowrap">
                                        {transaction.date}
                                    </TableCell>

                                    <TableCell className="font-mono font-medium text-primary">
                                        {transaction.sku}
                                    </TableCell>

                                    <TableCell className="truncate font-medium">
                                        {transaction.item}
                                    </TableCell>

                                    <TableCell>
                                        <div className="flex items-center justify-center gap-2">
                                            <TypeIcon
                                                className={cn(
                                                    'h-4 w-4',
                                                    type.className,
                                                )}
                                            />
                                            <span>{type.label}</span>
                                        </div>
                                    </TableCell>

                                    <TableCell className="font-semibold">
                                        {transaction.quantity}
                                    </TableCell>

                                    <TableCell>
                                        <StatusBadge
                                            status={transaction.status}
                                        >
                                            {statusLabel[transaction.status]}
                                        </StatusBadge>
                                    </TableCell>
                                </TableRow>
                            );
                        })}

                        {!showAll && hasMoreTransactions && (
                            <TableRow>
                                <TableCell
                                    colSpan={6}
                                    className="p-0 text-center"
                                >
                                    <button
                                        type="button"
                                        onClick={() => setShowAll(true)}
                                        className="block w-full py-4 text-xl font-semibold tracking-widest text-muted-foreground hover:text-primary"
                                        aria-label="View all transactions"
                                    >
                                        ...
                                    </button>
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    );
}
