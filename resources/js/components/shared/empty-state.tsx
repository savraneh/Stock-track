import type { ReactNode } from 'react';

import { cn } from '@/lib/utils';

interface EmptyStateProps {
    title: string;

    description?: string;

    icon?: ReactNode;

    className?: string;
}

export function EmptyState({
    title,
    description,
    icon,
    className,
}: EmptyStateProps) {
    return (
        <div
            className={cn(
                'flex flex-col items-center justify-center rounded-xl border border-dashed p-10 text-center',
                className,
            )}
        >
            {icon && <div className="mb-4 text-muted-foreground">{icon}</div>}

            <h3 className="text-lg font-semibold">{title}</h3>

            {description && (
                <p className="mt-2 max-w-sm text-sm text-muted-foreground">
                    {description}
                </p>
            )}
        </div>
    );
}
