import { Search } from 'lucide-react';

import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';

interface SearchInputProps {
    placeholder?: string;
    value?: string;
    onChange?: (value: string) => void;
    className?: string;
}

export function SearchInput({
    placeholder = 'Search...',
    value,
    onChange,
    className,
}: SearchInputProps) {
    return (
        <div className={cn('relative w-full', className)}>
            <Search className="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground" />

            <Input
                value={value}
                onChange={(e) => onChange?.(e.target.value)}
                placeholder={placeholder}
                className="pl-10"
            />
        </div>
    );
}
