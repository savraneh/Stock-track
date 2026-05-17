<?php

namespace App\Filament\Resources\Suppliers;

use App\Filament\Resources\Suppliers\Pages\CreateSupplier;
use App\Filament\Resources\Suppliers\Pages\EditSupplier;
use App\Filament\Resources\Suppliers\Pages\ListSuppliers;
use App\Models\Supplier;
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

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Suppliers';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Supplier';

    protected static ?string $pluralModelLabel = 'Supplier';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Supplier')
                ->required()
                ->maxLength(255),
            TextInput::make('contact_person')
                ->label('Contact Person')
                ->maxLength(255),
            TextInput::make('phone')
                ->label('Telepon')
                ->tel()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(255),
            Textarea::make('address')
                ->label('Alamat')
                ->rows(4)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Supplier')
            ->description('Kelola semua data supplier di sini')
            ->headerActions([
                Action::make('create')
                    ->label('Tambah Supplier')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person')
                    ->label('CP')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('items_count')
                    ->label('Jumlah Barang')
                    ->counts('items')
                    ->badge()
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}
