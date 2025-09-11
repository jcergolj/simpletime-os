<x-layouts.app :title="__('Profile & Settings')">
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <x-settings.page-header
            :title="__('Profile & Settings')"
            :description="__('Manage your account settings and preferences')"
        />

        <!-- Settings Menu -->
        <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-200">
            <x-settings.menu-item
                route="settings.profile.edit"
                icon="user"
                :title="__('Edit Profile')"
                :description="__('Update your name and email address')"
            />

            <x-settings.menu-item
                route="settings.preferences.edit"
                icon="cog-6-tooth"
                :title="__('Preferences')"
                :description="__('Customize defaults and display settings')"
            />

            <x-settings.menu-item
                route="settings.password.edit"
                icon="key"
                :title="__('Change Password')"
                :description="__('Update your account password')"
            />

            <a href="{{ route('settings.profile.delete') }}" class="flex items-center px-6 py-4">
                <div class="flex-shrink-0">
                    <x-heroicon-o-trash class="h-6 w-6 text-red-400" />
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-red-900">{{ __('Delete Account') }}</h3>
                    <p class="text-sm text-red-500">{{ __('Permanently delete your account and data') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <x-heroicon-o-chevron-right class="h-5 w-5 text-gray-400" />
                </div>
            </a>
        </div>

        <!-- Logout Button -->
        <div class="mt-8">
            <form action="{{ route('logout') }}" method="post" id="settings-logout" data-turbo-action="replace">
                @csrf
                <button type="submit" style="width: 100%; background: var(--accent); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 500; font-size: 15px; line-height: 1; border: none; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <x-heroicon-o-arrow-left-on-rectangle style="width: 20px; height: 20px; flex-shrink: 0;" />
                    <span style="line-height: 1;">{{ __('Logout') }}</span>
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
