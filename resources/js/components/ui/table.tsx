import * as React from 'react';

import { cn } from '@/lib/utils';

function Table({
    className,
    ...props
}: React.ComponentProps<'table'>) {
    return (
        <div className="w-full overflow-x-auto rounded-xl">
            <table
                className={cn(
                    'w-full border-collapse text-sm',
                    className,
                )}
                {...props}
            />
        </div>
    );
}

function TableHeader({
    className,
    ...props
}: React.ComponentProps<'thead'>) {
    return (
        <thead
            className={cn(
                'border-border border-b',
                className,
            )}
            {...props}
        />
    );
}

function TableBody({
    className,
    ...props
}: React.ComponentProps<'tbody'>) {
    return (
        <tbody
            className={cn(className)}
            {...props}
        />
    );
}

function TableRow({
    className,
    ...props
}: React.ComponentProps<'tr'>) {
    return (
        <tr
            className={cn(
                'border-border/50 hover:bg-muted/30 border-b transition-colors',
                className,
            )}
            {...props}
        />
    );
}

function TableHead({
    className,
    ...props
}: React.ComponentProps<'th'>) {
    return (
        <th
            className={cn(
                'text-muted-foreground h-12 md:h-14 px-2 text-center text-xs font-medium tracking-wide uppercase',
                className,
            )}
            {...props}
        />
    );
}

function TableCell({
    className,
    ...props
}: React.ComponentProps<'td'>) {
    return (
        <td
            className={cn(
                'px-2 py-5 md:py-5 md:text-center align-middle',
                className,
            )}
            {...props}
        />
    );
}

export {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableHead,
    TableCell,
};
