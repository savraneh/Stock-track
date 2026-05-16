import { Head } from '@inertiajs/react';
import {
    AlertTriangle,
    Boxes,
    DollarSign,
    Plus,
    RefreshCcw,
} from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

import { StatsCard } from '@/components/cards/stats-card';
import { FilterBar } from '@/components/inventory/filter-bar';
import { InventoryTable } from '@/components/inventory/inventory-table';
import { Button } from '@/components/ui/button';
import { dashboard } from '@/routes';
import type {
    InventoryFilterOption,
    InventoryItem,
    InventoryStockStatus,
} from '@/types/inventory';

const inventoryItems: InventoryItem[] = [
    {
        id: 1,
        name: 'Samsung EVO 970 SSD',
        sku: 'SKU-SS-970-1TB',
        category: 'Electronics',
        stock: 420,
        minimumStock: 50,
        price: 129.99,
        status: 'in-stock',
    },
    {
        id: 2,
        name: 'Logitech MX Master 3S',
        sku: 'SKU-MS-MX3-GR',
        category: 'Electronics',
        stock: 12,
        minimumStock: 25,
        price: 99,
        status: 'low-stock',
    },
    {
        id: 3,
        name: 'Premium A5 Notebooks',
        sku: 'SKU-OFF-NB-A5',
        category: 'Office Supplies',
        stock: 1250,
        minimumStock: 200,
        price: 14.5,
        status: 'in-stock',
    },
    {
        id: 4,
        name: 'Thermal Label Rolls',
        sku: 'SKU-WHS-LBL-100',
        category: 'Warehouse Supplies',
        stock: 0,
        minimumStock: 100,
        price: 8.75,
        status: 'out-of-stock',
    },
    {
        id: 5,
        name: 'USB-C Docking Station',
        sku: 'SKU-EL-DCK-USBC',
        category: 'Electronics',
        stock: 36,
        minimumStock: 20,
        price: 179,
        status: 'in-stock',
    },
    {
        id: 6,
        name: 'Packaging Tape Carton',
        sku: 'SKU-WHS-TAPE-CTN',
        category: 'Warehouse Supplies',
        stock: 42,
        minimumStock: 60,
        price: 32,
        status: 'low-stock',
    },
    {
        id: 7,
        name: 'Ergonomic Office Chair',
        sku: 'SKU-OFF-CHR-ERG',
        category: 'Office Supplies',
        stock: 18,
        minimumStock: 10,
        price: 219,
        status: 'in-stock',
    },
    {
        id: 8,
        name: 'Barcode Scanner Pro',
        sku: 'SKU-WHS-SCN-PRO',
        category: 'Warehouse Supplies',
        stock: 7,
        minimumStock: 12,
        price: 149.5,
        status: 'low-stock',
    },
];

const statusOptions: InventoryFilterOption[] = [
    { label: 'Any Status', value: 'all' },
    { label: 'In Stock', value: 'in-stock' },
    { label: 'Low Stock', value: 'low-stock' },
    { label: 'Out of Stock', value: 'out-of-stock' },
];

function getItemStatus(item: InventoryItem): InventoryStockStatus {
    if (item.stock === 0) {
        return 'out-of-stock';
    }

    if (item.stock <= item.minimumStock) {
        return 'low-stock';
    }

    return 'in-stock';
}

export default function ItemsPage() {
    const [search, setSearch] = useState('');
    const [category, setCategory] = useState('all');
    const [status, setStatus] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage, setItemsPerPage] = useState(5);

    const categoryOptions = useMemo<InventoryFilterOption[]>(() => {
        const categories = Array.from(
            new Set(inventoryItems.map((item) => item.category)),
        ).sort();

        return [
            { label: 'All Categories', value: 'all' },
            ...categories.map((itemCategory) => ({
                label: itemCategory,
                value: itemCategory,
            })),
        ];
    }, []);

    const normalizedSearch = search.trim().toLowerCase();

    const filteredItems = useMemo(() => {
        return inventoryItems.filter((item) => {
            const computedStatus = getItemStatus(item);
            const matchesSearch =
                normalizedSearch.length === 0 ||
                item.name.toLowerCase().includes(normalizedSearch) ||
                item.sku.toLowerCase().includes(normalizedSearch);
            const matchesCategory =
                category === 'all' || item.category === category;
            const matchesStatus = status === 'all' || computedStatus === status;

            return matchesSearch && matchesCategory && matchesStatus;
        });
    }, [category, normalizedSearch, status]);

    const totalPages = Math.max(
        1,
        Math.ceil(filteredItems.length / itemsPerPage),
    );

    const paginatedItems = useMemo(() => {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        return filteredItems.slice(startIndex, endIndex);
    }, [currentPage, filteredItems, itemsPerPage]);

    const metrics = useMemo(() => {
        const lowStockItems = inventoryItems.filter(
            (item) => getItemStatus(item) === 'low-stock',
        ).length;
        const totalValue = inventoryItems.reduce(
            (sum, item) => sum + item.stock * item.price,
            0,
        );
        const outOfStockItems = inventoryItems.filter(
            (item) => getItemStatus(item) === 'out-of-stock',
        ).length;

        return {
            totalItems: inventoryItems.length,
            lowStockItems,
            totalValue,
            outOfStockItems,
        };
    }, []);

    const hasActiveFilters =
        search.length > 0 || category !== 'all' || status !== 'all';

    useEffect(() => {
        setCurrentPage(1);
    }, [search, category, status, itemsPerPage]);

    useEffect(() => {
        setCurrentPage((page) => Math.min(page, totalPages));
    }, [totalPages]);

    return (
        <>
            <Head title="Items" />

            <div className="flex flex-1 flex-col gap-6 p-6">
                <div className="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-2xl font-semibold tracking-tight">
                            Item Management
                        </h1>
                        <p className="text-sm text-muted-foreground">
                            Manage warehouse inventory, stock health, and
                            operational item data.
                        </p>
                    </div>

                    <Button type="button" className="w-full md:w-auto">
                        <Plus className="h-4 w-4" />
                        Add Item
                    </Button>
                </div>

                <div className="grid gap-6 md:grid-cols-2 2xl:grid-cols-4">
                    <StatsCard
                        title="Total Items"
                        value={metrics.totalItems.toLocaleString()}
                        description="Tracked inventory records"
                        icon={Boxes}
                        trend="up"
                    />

                    <StatsCard
                        title="Low Stock Alert"
                        value={metrics.lowStockItems.toLocaleString()}
                        description="Requires immediate attention"
                        icon={AlertTriangle}
                        trend="down"
                    />

                    <StatsCard
                        title="Inventory Value"
                        value={new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            notation: 'compact',
                            maximumFractionDigits: 1,
                        }).format(metrics.totalValue)}
                        description="Estimated asset total"
                        icon={DollarSign}
                        trend="neutral"
                    />

                    <StatsCard
                        title="Stock Turnover"
                        value={`${metrics.outOfStockItems} blocked`}
                        description="Out-of-stock operational risk"
                        icon={RefreshCcw}
                        trend={metrics.outOfStockItems > 0 ? 'down' : 'up'}
                    />
                </div>

                <FilterBar
                    searchValue={search}
                    onSearchChange={setSearch}
                    categoryValue={category}
                    onCategoryChange={setCategory}
                    statusValue={status}
                    onStatusChange={setStatus}
                    categoryOptions={categoryOptions}
                    statusOptions={statusOptions}
                    hasActiveFilters={hasActiveFilters}
                    onResetFilters={() => {
                        setSearch('');
                        setCategory('all');
                        setStatus('all');
                    }}
                />

                <section className="rounded-2xl border bg-card p-4 sm:p-6">
                    <div className="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 className="text-lg font-semibold">
                                Inventory Items
                            </h2>
                            <p className="text-sm text-muted-foreground">
                                Track product details, stock levels, and item
                                actions.
                            </p>
                        </div>

                        <p className="text-sm text-muted-foreground">
                            {filteredItems.length.toLocaleString()} result
                            {filteredItems.length === 1 ? '' : 's'}
                        </p>
                    </div>

                    <InventoryTable
                        items={paginatedItems}
                        currentPage={currentPage}
                        totalPages={totalPages}
                        itemsPerPage={itemsPerPage}
                        totalItems={filteredItems.length}
                        onPageChange={setCurrentPage}
                        onItemsPerPageChange={setItemsPerPage}
                    />
                </section>
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
