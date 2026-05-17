<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Models\Category;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use \Filament\Actions\Action;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Category';

    protected static ?string $pluralModelLabel = 'Categories';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Category Name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            TextInput::make('storage_zone')
                ->label('Storage Zone')
                ->placeholder('Example: Shelf A / Warehouse 1')
                ->maxLength(255),
            Textarea::make('description')
                ->label('Description')
                ->rows(4)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Categories List')
            ->description('Manage all category data here')
            ->headerActions([
                Action::make('create')
                    ->label('Add Category')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Category')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('storage_zone')
                    ->label('Zone')
                    ->alignCenter()
                    ->badge()
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('items_count')
                    ->label('Item Count')
                    ->alignCenter()
                    ->counts('items')
                    ->badge()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->alignCenter()
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()->visible(fn(): bool => auth()->user()?->canManageMasterData() ?? false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn(): bool => auth()->user()?->canManageMasterData() ?? false),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->canManageMasterData() ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->canManageMasterData() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->canManageMasterData() ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
