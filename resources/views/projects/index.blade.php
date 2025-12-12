<x-layouts.app :title="__('Projects')">
    <div class="space-y-8" data-controller="inline-edit">
        <!-- Page Header -->
        <div class="px-4 sm:px-0">
            <h1 class="font-display" style="font-size: 48px; margin-bottom: 8px; color: var(--color-text);">{{ __('Projects') }}</h1>
            <p style="font-size: 18px; color: var(--color-text-secondary); font-weight: 400;">{{ __('Manage your projects and track time') }}</p>
        </div>

        <!-- Search Filter -->
        <div class="card mx-4 sm:mx-0" style="padding: 32px 28px;">
            <h3 class="font-display" style="font-size: 22px; margin-bottom: 24px; color: var(--color-text);">{{ __('Search Projects') }}</h3>
            <form method="GET" action="{{ route('projects.index') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="label">{{ __('Search by project name or client name') }}</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Enter project name or client name...') }}"
                               class="input-field">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <x-icon-button>
                            <x-slot:icon>
                                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </x-slot:icon>
                            {{ __('Search') }}
                        </x-icon-button>
                        @if(request('search'))
                            <a href="{{ route('projects.index') }}" style="color: var(--text-secondary); padding: 14px 24px; font-weight: 600; transition: color 0.2s; text-align: center; text-decoration: none; display: inline-block;">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Project Section -->
        <div class="card mx-4 sm:mx-0" style="padding: 32px 28px;">
            <turbo-frame id="project-create-form">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <h2 class="font-display" style="font-size: 22px; margin-bottom: 8px; color: var(--color-text);">{{ __('Add New Project') }}</h2>
                        <p style="font-size: 16px; color: var(--color-text-secondary);">{{ __('Create a new project and organize your work') }}</p>
                    </div>
                    <x-icon-link :href="route('projects.create')">
                        {{ __('Add Project') }}
                    </x-icon-link>
                </div>
            </turbo-frame>
        </div>

        <!-- Projects List -->
        <turbo-frame id="projects-lists">
            @include('turbo::projects.list', ['projects' => $projects])
        </turbo-frame>
    </div>
</x-layouts.app>
