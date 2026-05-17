<?php

namespace App\Filament\Resources\Items;

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Models\Item;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use \Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Items';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Barang';

    protected static ?string $pluralModelLabel = 'Barang';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Barang')
                ->schema([
                    TextInput::make('code')
                        ->label('Kode / SKU')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('name')
                        ->label('Nama Barang')
                        ->required()
                        ->maxLength(255),
                    Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('supplier_id')
                        ->label('Supplier')
                        ->relationship('supplier', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->default('pcs')
                        ->maxLength(50),
                    TextInput::make('unit_price')
                        ->label('Harga Satuan')
                        ->prefix('Rp')
                        ->numeric()
                        ->minValue(0),
                    FileUpload::make('image')
                        ->label('Foto Barang')
                        ->image()
                        ->directory('items')
                        ->imageEditor()
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Kontrol Stok')
                ->description('Status stok dihitung otomatis dari stok saat ini, minimal stok, dan safety stock.')
                ->schema([
                    TextInput::make('stock')
                        ->label('Stok Saat Ini')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0),
                    TextInput::make('min_stock')
                        ->label('Minimal Stok')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0),
                    TextInput::make('safe_stock')
                        ->label('Safety Stock')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->helperText('Jika stok <= safety stock maka status Menipis.'),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Barang')
            ->description('Kelola semua data barang di sini')
            ->headerActions([
                Action::make('create')
                    ->label('Tambah Barang')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->alignStart()
                    ->circular(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->alignStart()
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->alignCenter()
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->alignStart()
                    ->numeric()
                    ->sortable()
                    ->suffix(fn(Item $record): string => ' ' . $record->unit),
                TextColumn::make('min_stock')
                    ->label('Min')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('safe_stock')
                    ->label('Safety')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_status_label')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(Item $record): string => $record->stock_status->color()),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->alignStart()
                    ->toggleable()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('need_restock')
                    ->label('Perlu Restock')
                    ->query(fn(Builder $query): Builder => $query->needRestock()),
                Filter::make('low_stock')
                    ->label('Menipis')
                    ->query(fn(Builder $query): Builder => $query->lowStock()),
            ])
            ->recordActions([
                EditAction::make()->visible(fn(): bool => auth()->user()?->canManageMasterData() ?? false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn(): bool => auth()->user()?->canManageMasterData() ?? false),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'edit' => EditItem::route('/{record}/edit'),
        ];
    }
}
