<?php

namespace App\Filament\Resources\Suppliers\Pages;

use App\Filament\Concerns\HasNavigationBreadcrumbs;
use App\Filament\Resources\Suppliers\SupplierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSupplier extends CreateRecord
{
    use HasNavigationBreadcrumbs;

    protected static string $resource = SupplierResource::class;
}
