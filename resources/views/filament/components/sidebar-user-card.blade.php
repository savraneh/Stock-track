@php
$user = auth()->user();

$initials = collect(explode(' ', $user?->name ?? 'User'))
->map(fn ($word) => mb_substr($word, 0, 1))
->take(2)
->join('');
@endphp

<div class="stock-sidebar-user" x-data="{ open: false }">
    <button
        type="button"
        class="stock-sidebar-user__trigger"
        x-on:click="open = ! open"
        x-on:click.outside="open = false">
        <div class="stock-sidebar-user__avatar">
            {{ strtoupper($initials) }}
        </div>

        <div class="stock-sidebar-user__meta">
            <div class="stock-sidebar-user__name">
                {{ $user?->name ?? 'User' }}
            </div>
            <div class="stock-sidebar-user__email">
                {{ $user?->email }}
            </div>
        </div>

        <x-heroicon-o-chevron-up-down class="stock-sidebar-user__chevron" />
    </button>

    <div
        class="stock-sidebar-user__dropdown"
        x-show="open"
        x-transition.origin.bottom
        style="display: none;">
        @if ($user?->role === 'admin')
        <a href="{{ \App\Filament\Resources\UserResource::getUrl() }}">
            Users
        </a>
        @endif

        <a href="#">
            Settings
        </a>

        <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
            @csrf
            <button type="submit">
                Log out
            </button>
        </form>
    </div>
</div>