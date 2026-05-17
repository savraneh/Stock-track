<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use UnitEnum;

class Settings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'settings';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.settings';

    public function getBreadcrumbs(): array
    {
        return [
            'Settings',
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Settings';
    }

    public function getTitle(): string
    {
        return 'Settings';
    }

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function changePasswordAction(): Action
    {
        return Action::make('changePassword')
            ->label('Change Password')
            ->icon('heroicon-o-lock-closed')
            ->color('primary')
            ->form([
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->revealable()
                    ->required(),
                TextInput::make('new_password')
                    ->label('New Password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(8)
                    ->same('new_password_confirmation'),
                TextInput::make('new_password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->revealable()
                    ->required(),
            ])
            ->action(function (array $data) {
                $user = auth()->user();

                if (!Hash::check($data['current_password'], $user->password)) {
                    Notification::make()
                        ->title('Current password is incorrect.')
                        ->danger()
                        ->send();
                    return;
                }

                $user->update([
                    'password' => $data['new_password'],
                ]);

                Notification::make()
                    ->title('Password changed successfully.')
                    ->success()
                    ->send();
            });
    }
}
