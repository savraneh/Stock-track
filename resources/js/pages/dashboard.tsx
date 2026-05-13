import { Head } from '@inertiajs/react';
import { Boxes, AlertTriangle, ReceiptText, LayoutGrid } from 'lucide-react';
import { StatsCard } from '@/components/cards/stats-card';
import { TransactionChart } from '@/components/dashboard/transaction-chart';
import { CriticalAlerts } from '@/components/dashboard/critical-alerts';
import { RecentTransactions } from '@/components/dashboard/recent-transactions';
import { dashboard } from '@/routes';

export default function Dashboard() {
    return (
        <>
            <Head title="Dashboard" />
            <div className="flex flex-1 flex-col gap-6 p-6">
                {/* STATS CARDS */}
                <div className="grid gap-6 md:grid-cols-2 2xl:grid-cols-4">
                    <StatsCard
                        title="Total Items"
                        value="12,840" //blm connect database
                        description="All inventory items"
                        icon={Boxes}
                        trend="up"
                    />

                    <StatsCard
                        title="Low Stock"
                        value="42" //blm connect database
                        description="Items below minimum stock"
                        icon={AlertTriangle}
                        trend="down"
                    />

                    <StatsCard
                        title="Transactions"
                        value="156" //blm connect database
                        description="Today's transactions"
                        icon={ReceiptText}
                        trend="neutral"
                    />

                    <StatsCard
                        title="Categories"
                        value="24" //blm connect database
                        description="Registered categories"
                        icon={LayoutGrid}
                        trend="up"
                    />
                </div>
                {/* ANALYTICS */}
                <div className="grid gap-6 xl:grid-cols-12">
                    <div className="xl:col-span-8">
                        <TransactionChart />
                    </div>
                    <div className="xl:col-span-4">
                        <CriticalAlerts />
                    </div>
                </div>
                {/* TRANSACTIONS */}
                <div className="min-h-[420px] rounded-2xl border bg-card">
                    <RecentTransactions />
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
