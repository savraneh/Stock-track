import { AlertTriangle } from 'lucide-react';

import { cn } from '@/lib/utils';

interface StockIndicatorProps {
    current: number;
    minimum: number;

    className?: string;
}

export function StockIndicator({
    current,
    minimum,
    className,
}: StockIndicatorProps) {
    const percentage = Math.min((current / minimum) * 100, 100);

    const isLowStock = current <= minimum;

    return (
        <div className={cn('flex items-center gap-3', className)}>
            <span
                className={cn(
                    'w-10 text-right text-sm font-medium',

                    isLowStock ? 'text-destructive' : 'text-foreground',
                )}
            >
                {current}
            </span>

            <div className="h-2 w-16 overflow-hidden rounded-full bg-muted">
                <div
                    className={cn(
                        'h-full rounded-full transition-all duration-300',

                        isLowStock ? 'bg-destructive' : 'bg-primary',
                    )}
                    style={{
                        width: `${percentage}%`,
                    }}
                />
            </div>

            {isLowStock && (
                <AlertTriangle className="h-4 w-4 text-destructive" />
            )}
        </div>
    );
}
