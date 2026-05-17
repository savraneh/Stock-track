<?php

namespace App\Filament\Concerns;

trait HasNavigationBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        $resource = static::getResource();

        if (method_exists($resource, 'getNavigationGroup')) {
            $navigationGroup = $resource::getNavigationGroup();

            if ($navigationGroup) {
                array_unshift($breadcrumbs, $navigationGroup);
            }
        }

        return $breadcrumbs;
    }
}
