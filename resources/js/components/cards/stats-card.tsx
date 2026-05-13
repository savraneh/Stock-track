import { LucideIcon } from 'lucide-react';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

import { cn } from '@/lib/utils';

interface StatsCardProps {
    title: string;
    value: string | number;
    description?: string;
    icon: LucideIcon;

    trend?: 'up' | 'down' | 'neutral';

    className?: string;
}

export function StatsCard({
    title,
    value,
    description,
    icon: Icon,
    trend = 'neutral',
    className,
}: StatsCardProps) {
    return (
        <Card
            className={cn(
                'border-border/60 bg-card shadow-sm transition-all duration-200 hover:shadow-md',
                className,
            )}
        >
            <CardHeader className="flex flex-row items-start justify-between space-y-0 pb-3">
                <div className="space-y-1">
                    <CardDescription className="text-xs font-medium tracking-wide uppercase">
                        {title}
                    </CardDescription>

                    <CardTitle className="text-3xl font-bold tracking-tight">
                        {value}
                    </CardTitle>
                </div>

                <div
                    className={cn(
                        'flex h-11 w-11 items-center justify-center rounded-xl',

                        trend === 'up' && 'bg-primary/10 text-primary',

                        trend === 'down' &&
                            'bg-destructive/10 text-destructive',

                        trend === 'neutral' && 'bg-muted text-muted-foreground',
                    )}
                >
                    <Icon className="h-5 w-5" />
                </div>
            </CardHeader>

            {description && (
                <CardContent>
                    <p className="text-sm text-muted-foreground">
                        {description}
                    </p>
                </CardContent>
            )}
        </Card>
    );
}
