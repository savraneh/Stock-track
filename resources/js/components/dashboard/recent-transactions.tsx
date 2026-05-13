import { ArrowDownLeft, ArrowUpRight, ArrowRightLeft } from 'lucide-react';
import { useState } from 'react';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { cn } from '@/lib/utils';

type Transaction = {
    id: number;
    date: string;
    sku: string;
    item: string;
    type: 'in' | 'out' | 'internal';
    quantity: string;
    status: 'Completed' | 'Pending' | 'Failed';
};

const transactions: Transaction[] = [
    {
        id: 1,
        date: 'Oct 24, 09:42 AM',
        sku: 'ELC-9042',
        item: 'Main CPU Unit Gen 4',
        type: 'in',
        quantity: '+250',
        status: 'Completed',
    },
    {
        id: 2,
        date: 'Oct 24, 08:15 AM',
        sku: 'WHS-3321',
        item: 'Packing Tape Reinforced',
        type: 'out',
        quantity: '-48',
        status: 'Completed',
    },
    {
        id: 3,
        date: 'Oct 23, 04:50 PM',
        sku: 'STG-1109',
        item: 'Storage Rack Heavy Duty',
        type: 'internal',
        quantity: '5',
        status: 'Pending',
    },
    {
        id: 4,
        date: 'Oct 23, 02:10 PM',
        sku: 'PRT-2201',
        item: 'Thermal Printer Unit',
        type: 'out',
        quantity: '-12',
        status: 'Failed',
    },
    {
        id: 5,
        date: 'Oct 23, 11:35 AM',
        sku: 'ELC-7812',
        item: 'Power Supply Module 750W',
        type: 'in',
        quantity: '+80',
        status: 'Completed',
    },
    {
        id: 6,
        date: 'Oct 22, 05:18 PM',
        sku: 'CAB-4508',
        item: 'USB-C Industrial Cable',
        type: 'out',
        quantity: '-120',
        status: 'Completed',
    },
    {
        id: 7,
        date: 'Oct 22, 01:25 PM',
        sku: 'STG-5540',
        item: 'Warehouse Bin Large',
        type: 'internal',
        quantity: '18',
        status: 'Pending',
    },
    {
        id: 8,
        date: 'Oct 21, 10:05 AM',
        sku: 'LBL-1204',
        item: 'Barcode Label Roll',
        type: 'out',
        quantity: '-300',
        status: 'Failed',
    },
];

const previewTransactionCount = 3;

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

const statusClassName = {
    Completed: 'bg-green-100 text-green-700',
    Pending: 'bg-yellow-100 text-yellow-700',
    Failed: 'bg-red-100 text-red-700',
};

export function RecentTransactions() {
    const [showAll, setShowAll] = useState(false);
    const hasMoreTransactions = transactions.length > previewTransactionCount;
    const visibleTransactions = showAll
        ? transactions
        : transactions.slice(0, previewTransactionCount);

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

            <CardContent className="overflow-x-auto">
                <table className="w-full table-fixed border-collapse">
                    <thead>
                        <tr className="border-b border-border">
                            <th className="w-1/6 py-3 text-left text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                Date
                            </th>

                            <th className="w-1/6 py-3 text-left text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                SKU
                            </th>

                            <th className="w-1/6 py-3 text-left text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                Item
                            </th>

                            <th className="w-1/6 py-3 text-center text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                Type
                            </th>

                            <th className="w-1/6 py-3 text-center text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                Qty
                            </th>

                            <th className="w-1/6 py-3 text-center text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        {visibleTransactions.map((transaction) => {
                            const type = typeConfig[transaction.type];
                            const TypeIcon = type.icon;

                            return (
                                <tr
                                    key={transaction.id}
                                    className="border-b border-border/50 transition-colors hover:bg-muted/40"
                                >
                                    <td className="py-4 text-sm whitespace-nowrap">
                                        {transaction.date}
                                    </td>

                                    <td className="py-4 font-mono text-sm font-medium text-primary">
                                        {transaction.sku}
                                    </td>

                                    <td className="truncate py-4 text-sm font-medium">
                                        {transaction.item}
                                    </td>

                                    <td className="py-4">
                                        <div className="flex items-center justify-center gap-2 text-sm">
                                            <TypeIcon
                                                className={cn(
                                                    'h-4 w-4',
                                                    type.className,
                                                )}
                                            />
                                            <span>{type.label}</span>
                                        </div>
                                    </td>

                                    <td className="py-4 text-center text-sm font-semibold">
                                        {transaction.quantity}
                                    </td>

                                    <td className="py-4 text-center">
                                        <span
                                            className={cn(
                                                'inline-flex rounded-full px-3.5 py-1.5 text-xs font-medium',
                                                statusClassName[
                                                    transaction.status
                                                ],
                                            )}
                                        >
                                            {transaction.status}
                                        </span>
                                    </td>
                                </tr>
                            );
                        })}

                        {!showAll && hasMoreTransactions && (
                            <tr className="border-b border-border/50 transition-colors hover:bg-muted/40">
                                <td colSpan={6} className="py-4 text-center">
                                    <button
                                        type="button"
                                        onClick={() => setShowAll(true)}
                                        className="text-xl font-semibold tracking-widest text-muted-foreground hover:text-primary"
                                        aria-label="View all transactions"
                                    >
                                        ...
                                    </button>
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </CardContent>
        </Card>
    );
}
