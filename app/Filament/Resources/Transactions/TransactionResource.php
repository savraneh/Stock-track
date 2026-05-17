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

    protected static ?string $modelLabel = 'Stock Transaction';

    protected static ?string $pluralModelLabel = 'Stock Transactions';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Transaction Input')
                ->schema([
                    Select::make('item_id')
                        ->label('Item')
                        ->relationship('item', 'name')
                        ->getOptionLabelFromRecordUsing(fn($record): string => "{$record->code} - {$record->name} (Stock: {$record->stock})")
                        ->searchable(['code', 'name'])
                        ->preload()
                        ->required(),
                    Select::make('type')
                        ->label('Transaction Type')
                        ->options(TransactionType::options())
                        ->required()
                        ->native(false),
                    TextInput::make('quantity')
                        ->label('Quantity')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->helperText('For stock adjustment, this quantity will be the final stock.'),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Transactions List')
            ->description('Manage all transaction data here')
            ->toolbarActions([
                Action::make('create')
                    ->label('Add Transaction')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->alignStart()
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('item.code')
                    ->label('Code')
                    ->alignStart()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('item.name')
                    ->label('Item')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item.category.name')
                    ->label('Category')
                    ->alignCenter()
                    ->badge()
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn(TransactionType $state): string => $state->label())
                    ->color(fn(TransactionType $state): string => $state->color()),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_before')
                    ->label('Before')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_after')
                    ->label('After')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Officer')
                    ->alignCenter()
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Transaction Type')
                    ->options(TransactionType::options()),
                SelectFilter::make('item_id')
                    ->label('Item')
                    ->relationship('item', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('today')
                    ->label('Today')
                    ->query(fn(Builder $query): Builder => $query->whereDate('created_at', today())),
                Filter::make('this_month')
                    ->label('This Month')
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
