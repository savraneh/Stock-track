<?php

namespace App\Filament\Resources\Users;

use App\Enums\UserRole;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Actions\Action;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 90;

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            Select::make('role')
                ->label('Role')
                ->options(UserRole::options())
                ->required()
                ->native(false),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->required(fn($operation): bool => $operation === 'create' || $operation === Operation::Create)
                ->dehydrated(fn(?string $state): bool => filled($state))
                ->maxLength(255)
                ->helperText('Kosongkan saat edit jika password tidak ingin diganti.'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Users')
            ->description('Kelola semua data users di sini')
            ->headerActions([
                Action::make('create')
                    ->label('Tambah User')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn(): string => static::getUrl('create')),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->alignStart()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn(UserRole $state): string => $state->label())
                    ->color(fn(UserRole $state): string => match ($state) {
                        UserRole::Admin => 'primary',
                        UserRole::Supervisor => 'info',
                        UserRole::Purchasing => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->alignStart()
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options(UserRole::options()),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
