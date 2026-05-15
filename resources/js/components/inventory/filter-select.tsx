import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

import { cn } from '@/lib/utils';

interface FilterOption {
    label: string;
    value: string;
}

interface FilterSelectProps {
    placeholder?: string;
    options: FilterOption[];
    value?: string;
    onValueChange?: (value: string) => void;
    className?: string;
}

export function FilterSelect({
    placeholder = 'Select option',
    options,
    value,
    onValueChange,
    className,
}: FilterSelectProps) {
    return (
        <Select value={value} onValueChange={onValueChange}>
            <SelectTrigger className={cn('w-[180px]', className)}>
                <SelectValue placeholder={placeholder} />
            </SelectTrigger>

            <SelectContent>
                {options.map((option) => (
                    <SelectItem key={option.value} value={option.value}>
                        {option.label}
                    </SelectItem>
                ))}
            </SelectContent>
        </Select>
    );
}
