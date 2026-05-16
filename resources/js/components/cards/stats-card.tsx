import type { LucideIcon } from 'lucide-react';
import type { ReactNode } from 'react';

import { Link } from '@inertiajs/react';

import { Card, CardContent, CardHeader } from '@/components/ui/card';

import { cn } from '@/lib/utils';

interface StatsCardProps {
    title: string;
    value: string | number;

    description?: string;

    icon: LucideIcon;

    trend?: 'up' | 'down' | 'neutral';

    footer?: ReactNode;

    href?: string;

    className?: string;
}

export function StatsCard({
    title,
    value,
    description,
    icon: Icon,
    trend = 'neutral',
    footer,
    href,
    className,
}: StatsCardProps) {
    const cardContent = (
        <Card
            className={cn(
                'min-h-40 justify-between border-border/60 bg-card shadow-sm transition-all duration-200',

                href && 'cursor-pointer hover:-translate-y-1 hover:shadow-md',

                className,
            )}
        >
            <CardHeader className="flex flex-row items-start justify-between space-y-0 pb-0">
                <div>
                    <p className="text-xs font-medium tracking-wide text-muted-foreground uppercase">
                        {title}
                    </p>

                    <h3 className="mt-3 text-3xl font-bold tracking-tight">
                        {value}
                    </h3>
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

            {(description || footer) && (
                <CardContent className="pt-0">
                    {description && (
                        <p className="text-sm text-muted-foreground">
                            {description}
                        </p>
                    )}

                    {footer && (
                        <div className="mt-2 flex items-center gap-2 text-sm text-muted-foreground">
                            {footer}
                        </div>
                    )}
                </CardContent>
            )}
        </Card>
    );

    if (href) {
        return <Link href={href}>{cardContent}</Link>;
    }

    return cardContent;
}
