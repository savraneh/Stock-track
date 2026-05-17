<x-filament-panels::page>
    @php
        $user = auth()->user();
        $roleLabel = $user?->role?->label() ?? '-';
    @endphp

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Profile Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Profile Information</h2>
                <p class="text-sm text-slate-500">Your account details.</p>
            </div>
            <div class="divide-y divide-slate-100 p-5">
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm font-medium text-slate-500">Name</span>
                    <span class="text-sm font-semibold text-slate-900">{{ $user?->name }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm font-medium text-slate-500">Email</span>
                    <span class="text-sm text-slate-900">{{ $user?->email }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm font-medium text-slate-500">Role</span>
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                        {{ $roleLabel }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Account Security --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Account Security</h2>
                <p class="text-sm text-slate-500">Manage your password.</p>
            </div>
            <div class="p-5">
                <p class="mb-4 text-sm text-slate-600">
                    It is recommended to use a strong and unique password for your account.
                </p>
                {{ $this->changePasswordAction }}
            </div>
        </div>

        {{-- Appearance --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Appearance</h2>
                <p class="text-sm text-slate-500">Display preferences.</p>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Theme</p>
                        <p class="text-sm text-slate-500">Light mode is currently active.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                        Light
                    </span>
                </div>
            </div>
        </div>

        {{-- Preferences --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Preferences</h2>
                <p class="text-sm text-slate-500">Table and listing settings.</p>
            </div>
            <div class="divide-y divide-slate-100 p-5">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Default Rows Per Page</p>
                        <p class="text-xs text-slate-500">Number of rows displayed per table page.</p>
                    </div>
                    <span class="text-sm font-semibold text-slate-900">25</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Compact Table Mode</p>
                        <p class="text-xs text-slate-500">Reduce table cell padding for denser view.</p>
                    </div>
                    <span class="text-sm text-slate-500">Standard</span>
                </div>
            </div>
        </div>

        {{-- Application Info --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-semibold text-slate-900">Application Info</h2>
                <p class="text-sm text-slate-500">About this application.</p>
            </div>
            <div class="grid gap-4 p-5 sm:grid-cols-3">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">App Name</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">STOCK-TRACK</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Version</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">1.0.0</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Logged In As</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user?->name }} ({{ $user?->email }})</p>
                </div>
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
