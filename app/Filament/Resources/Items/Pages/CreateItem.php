<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Concerns\HasNavigationBreadcrumbs;
use App\Filament\Resources\Items\ItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    use HasNavigationBreadcrumbs;

    protected static string $resource = ItemResource::class;
}
