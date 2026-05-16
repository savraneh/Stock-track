import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

import { cn } from '@/lib/utils';
import type { InventoryFilterOption } from '@/types/inventory';

interface FilterSelectProps {
    placeholder?: string;
    options: InventoryFilterOption[];
    value?: string;
    onValueChange?: (value: string) => void;
    className?: string;
    contentClassName?: string;
    side?: 'top' | 'right' | 'bottom' | 'left';
    align?: 'start' | 'center' | 'end';
    'aria-label'?: string;
}

export function FilterSelect({
    placeholder = 'Select option',
    options,
    value,
    onValueChange,
    className,
    contentClassName,
    side = 'bottom',
    align = 'start',
    'aria-label': ariaLabel,
}: FilterSelectProps) {
    return (
        <Select value={value} onValueChange={onValueChange}>
            <SelectTrigger
                aria-label={ariaLabel ?? placeholder}
                className={cn('w-full sm:w-[180px]', className)}
            >
                <SelectValue placeholder={placeholder} />
            </SelectTrigger>

            <SelectContent
                position="popper"
                side={side}
                align={align}
                sideOffset={8}
                className={cn(
                    'w-[var(--radix-select-trigger-width)] min-w-[var(--radix-select-trigger-width)] p-1',
                    '[&_[data-radix-select-scroll-up-button]]:hidden',
                    '[&_[data-radix-select-scroll-down-button]]:hidden',
                    contentClassName,
                )}
            >
                {options.map((option) => (
                    <SelectItem
                        key={option.value}
                        value={option.value}
                        className="cursor-pointer px-2 py-1.5 text-sm"
                    >
                        {option.label}
                    </SelectItem>
                ))}
            </SelectContent>
        </Select>
    );
}
