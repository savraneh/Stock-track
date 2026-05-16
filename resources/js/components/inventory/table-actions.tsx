import { Pencil, Trash2 } from 'lucide-react';

import { Button } from '@/components/ui/button';

interface TableActionsProps {
    onEdit?: () => void;
    onDelete?: () => void;
}

export function TableActions({ onEdit, onDelete }: TableActionsProps) {
    return (
        <div className="flex items-center justify-center gap-2">
            <Button variant="ghost" size="icon" onClick={onEdit}>
                <Pencil className="h-4 w-4" />
            </Button>

            <Button
                variant="ghost"
                size="icon"
                onClick={onDelete}
                className="text-destructive hover:text-destructive"
            >
                <Trash2 className="h-4 w-4" />
            </Button>
        </div>
    );
}
