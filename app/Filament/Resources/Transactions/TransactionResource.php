<?php

namespace App\Filament\Resources\Transactions;

use App\Enums\TransactionType;
use App\Filament\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Resources\Transactions\Pages\ListTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static string|UnitEnum|null $navigationGroup = 'Analytics & Reports';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Transactions';

    protected static ?string $modelLabel = 'Transaksi Stok';

    protected static ?string $pluralModelLabel = 'Transaksi Stok';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Input Transaksi')
                ->schema([
                    Select::make('item_id')
                        ->label('Barang')
                        ->relationship('item', 'name')
                        ->getOptionLabelFromRecordUsing(fn($record): string => "{$record->code} - {$record->name} (Stok: {$record->stock})")
                        ->searchable(['code', 'name'])
                        ->preload()
                        ->required(),
                    Select::make('type')
                        ->label('Jenis Transaksi')
                        ->options(TransactionType::options())
                        ->required()
                        ->native(false),
                    TextInput::make('quantity')
                        ->label('Jumlah')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->helperText('Untuk penyesuaian stok, jumlah ini akan menjadi stok final.'),
                    Textarea::make('description')
                        ->label('Keterangan')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Transaksi')
            ->description('Kelola semua data transaksi di sini')
            ->toolbarActions([
                Action::make('create')
                    ->label('Tambah Transaksi')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->alignStart()
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('item.code')
                    ->label('Kode')
                    ->alignStart()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('item.name')
                    ->label('Barang')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item.category.name')
                    ->label('Kategori')
                    ->alignCenter()
                    ->badge()
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn(TransactionType $state): string => $state->label())
                    ->color(fn(TransactionType $state): string => $state->color()),
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_before')
                    ->label('Sebelum')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_after')
                    ->label('Sesudah')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->alignCenter()
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe Transaksi')
                    ->options(TransactionType::options()),
                SelectFilter::make('item_id')
                    ->label('Barang')
                    ->relationship('item', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn(Builder $query): Builder => $query->whereDate('created_at', today())),
                Filter::make('this_month')
                    ->label('Bulan Ini')
                    ->query(fn(Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])),
            ])
            ->headerActions([
                Action::make('exportExcel')
                    ->label('Export Excel/CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(): string => route('reports.transactions.excel'))
                    ->openUrlInNewTab(),
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(): string => route('reports.transactions.pdf'))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->canCreateTransactions() ?? false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
        ];
    }
}
