<?php

namespace App\Filament\Resources\RestockRecommendations;

use App\Filament\Resources\RestockRecommendations\Pages\ListRestockRecommendations;
use App\Models\RestockRecommendation;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use UnitEnum;

class RestockRecommendationResource extends Resource
{
    protected static ?string $model = RestockRecommendation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-light-bulb';

    protected static string|UnitEnum|null $navigationGroup = 'Stock Control';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Restock Recommendations';

    protected static ?string $modelLabel = 'Restock Recommendation';

    protected static ?string $pluralModelLabel = 'Restock Recommendations';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Restock Recommendations List')
            ->description('Manage all restock recommendation data here')
            ->columns([
                TextColumn::make('generated_at')
                    ->label('Generated')
                    ->alignStart()
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('item.code')
                    ->label('Code')
                    ->alignStart()
                    ->searchable(),
                TextColumn::make('item.name')
                    ->label('Item')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item.stock')
                    ->label('Stock')
                    ->alignStart()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('item.min_stock')
                    ->label('Min')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('item.safe_stock')
                    ->label('Safety')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('daily_usage_avg')
                    ->label('Daily Avg.')
                    ->alignCenter()
                    ->numeric(2)
                    ->sortable(),
                TextColumn::make('recommended_amount')
                    ->label('Suggested Purchase')
                    ->alignCenter()
                    ->numeric()
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(string $state): string => $state === 'urgent' ? 'danger' : 'warning')
                    ->formatStateUsing(fn(string $state): string => $state === 'urgent' ? 'Urgent' : 'Planned'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'urgent' => 'Urgent',
                        'planned' => 'Planned',
                    ]),
            ])
            ->headerActions([
                Action::make('generate')
                    ->label('Generate Recommendations')
                    ->icon('heroicon-o-sparkles')
                    ->requiresConfirmation()
                    ->action(fn() => app(\App\Services\RestockRecommendationService::class)->generateAllCritical())
                    ->visible(fn(): bool => auth()->user()?->isWarehouseAdmin() ?? false)
                    ->successNotificationTitle('Restock recommendations generated successfully.'),
            ])
            ->defaultSort('generated_at', 'desc');
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->canViewRestockRecommendations() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isWarehouseAdmin() ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRestockRecommendations::route('/'),
        ];
    }
}
