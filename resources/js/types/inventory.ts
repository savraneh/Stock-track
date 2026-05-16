export type InventoryStockStatus = 'in-stock' | 'low-stock' | 'out-of-stock';

export interface InventoryItem {
    id: number;
    name: string;
    sku: string;
    category: string;
    stock: number;
    minimumStock: number;
    price: number;
    status: InventoryStockStatus;
}

export interface InventoryFilterOption {
    label: string;
    value: string;
}
