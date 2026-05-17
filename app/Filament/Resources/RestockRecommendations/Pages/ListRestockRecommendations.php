<?php

namespace App\Filament\Resources\RestockRecommendations\Pages;

use App\Filament\Resources\RestockRecommendations\RestockRecommendationResource;
use Filament\Resources\Pages\ListRecords;

class ListRestockRecommendations extends ListRecords
{
    protected static string $resource = RestockRecommendationResource::class;
}
