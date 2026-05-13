import { AlertTriangle, TrendingDown } from 'lucide-react';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

const alerts = [
    {
        name: 'Thermal Printers',
        stock: 2,
        minimum: 10,
        variant: 'critical',
    },
    {
        name: 'Logistics Pallets',
        stock: 15,
        minimum: 20,
        variant: 'warning',
    },
];

export function CriticalAlerts() {
    return (
        <Card className="h-full rounded-2xl border-border/60 shadow-sm">
            <CardHeader>
                <CardTitle className="text-lg font-semibold">
                    Critical Alerts
                </CardTitle>
            </CardHeader>

            <CardContent className="space-y-4">
                {alerts.map((alert) => (
                    <div
                        key={alert.name}
                        className="flex items-start gap-4 rounded-xl border p-4"
                    >
                        <div
                            className={
                                alert.variant === 'critical'
                                    ? 'flex h-10 w-10 items-center justify-center rounded-full bg-destructive/10 text-destructive'
                                    : 'flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary'
                            }
                        >
                            {alert.variant === 'critical' ? (
                                <AlertTriangle className="h-5 w-5" />
                            ) : (
                                <TrendingDown className="h-5 w-5" />
                            )}
                        </div>

                        <div className="space-y-1">
                            <p className="font-medium">{alert.name}</p>

                            <p className="text-sm text-muted-foreground">
                                {alert.stock} units left • Min: {alert.minimum}
                            </p>
                        </div>
                    </div>
                ))}
            </CardContent>
        </Card>
    );
}
