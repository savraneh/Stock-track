export interface InventoryItem {
    id: number;
    name: string;
    sku: string;
    category: string;
    stock: number;
    minimumStock: number;
    price: number;
}
