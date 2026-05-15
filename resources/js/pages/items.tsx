import { Head } from '@inertiajs/react';
import { AlertTriangle, Boxes, DollarSign, RefreshCcw } from 'lucide-react';

import { useMemo, useState } from 'react';
import { StatsCard } from '@/components/cards/stats-card';
import { FilterBar } from '@/components/inventory/filter-bar';
import { InventoryTable } from '@/components/inventory/inventory-table';
import { dashboard } from '@/routes';
import type { InventoryItem } from '@/types/inventory';

const items: InventoryItem[] = [
    {
        id: 1,
        name: 'Samsung EVO 970 SSD',
        sku: 'SKU-SS-970-1TB',
        category: 'Electronics',
        stock: 420,
        minimumStock: 50,
        price: 129.99,
    },
    {
        id: 2,
        name: 'Logitech MX Master 3S',
        sku: 'SKU-MS-MX3-GR',
        category: 'Electronics',
        stock: 12,
        minimumStock: 25,
        price: 99,
    },
    {
        id: 3,
        name: 'Premium A5 Notebooks',
        sku: 'SKU-OFF-NB-A5',
        category: 'Office Supplies',
        stock: 1250,
        minimumStock: 200,
        price: 14.5,
    },
];
export default function ItemsPage() {
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage, setItemsPerPage] = useState(5);
    const totalPages = Math.ceil(items.length / itemsPerPage);
    const paginatedItems = useMemo(() => {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        return items.slice(start, end);
    }, [currentPage, itemsPerPage]);

    return (
        <>
            <Head title="Items" />
            <div className="space-y-6 p-6">
                {/* Metrics Section */}
                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <StatsCard
                        title="Total Items"
                        value="1,482"
                        description="Total inventory items"
                        icon={Boxes}
                        trend="up"
                        footer={<span>+12% this month</span>}
                    />

                    <StatsCard
                        title="Low Stock Alert"
                        value="18"
                        description="Requires immediate attention"
                        icon={AlertTriangle}
                        trend="down"
                    />

                    <StatsCard
                        title="Inventory Value"
                        value="$245.8k"
                        description="Estimated asset total"
                        icon={DollarSign}
                        trend="neutral"
                    />

                    <StatsCard
                        title="Stock Turnover"
                        value="4.2x"
                        description="Last 30 days"
                        icon={RefreshCcw}
                        trend="up"
                    />
                </div>

                {/* Filter Bar */}
                <FilterBar />

                {/* Inventory Table */}
                <div className="rounded-xl border bg-card p-6">
                    <div className="flex items-center justify-between">
                        <div>
                            <h2 className="text-lg font-semibold">
                                Inventory Items
                            </h2>

                            <p className="text-sm text-muted-foreground">
                                Track product details, stock levels, and item
                                actions.
                            </p>
                        </div>
                    </div>

                    <InventoryTable
                        items={paginatedItems}
                        currentPage={currentPage}
                        totalPages={totalPages}
                        itemsPerPage={itemsPerPage}
                        onPageChange={setCurrentPage}
                        onItemsPerPageChange={(value) => {
                            setItemsPerPage(value);
                            setCurrentPage(1);
                        }}
                    />
                </div>
            </div>
        </>
    );
}

ItemsPage.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
        {
            title: 'Items',
            href: '/items',
        },
    ],
};
