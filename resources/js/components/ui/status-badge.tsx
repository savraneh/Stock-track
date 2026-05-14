import { cn } from '@/lib/utils';

interface StatusBadgeProps {
    status:
        | 'completed'
        | 'pending'
        | 'failed'
        | 'warning'
        | 'critical'
        | 'active'
        | 'inactive';

    children?: React.ReactNode;
}

const statusStyles = {
    completed:
        'bg-green-100 text-green-700',

    pending:
        'bg-yellow-100 text-yellow-700',

    failed:
        'bg-red-100 text-red-700',

    warning:
        'bg-orange-100 text-orange-700',

    critical:
        'bg-red-100 text-red-700',

    active:
        'bg-blue-100 text-blue-700',

    inactive:
        'bg-muted text-muted-foreground',
};

export function StatusBadge({
    status,
    children,
}: StatusBadgeProps) {
    return (
        <span
            className={cn(
                'inline-flex items-center rounded-full px-3.5 py-1.5 text-xs font-medium',
                statusStyles[status],
            )}
        >
            {children ?? status}
        </span>
    );
}