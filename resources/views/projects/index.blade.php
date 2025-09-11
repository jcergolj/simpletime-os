<x-layouts.app :title="__('Projects')">
    <div class="space-y-8" data-controller="inline-edit">
        <!-- Page Header -->
        <div class="px-4 sm:px-0">
            <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.5px; color: var(--text);">{{ __('Projects') }}</h1>
            <p style="font-size: 17px; color: var(--text-secondary); font-weight: 400;">{{ __('Manage your projects and track time') }}</p>
        </div>

        <!-- Search Filter -->
        <div class="card mx-4 sm:px-0" style="padding: 32px 28px;">
            <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 24px; color: var(--text);">{{ __('Search Projects') }}</h3>
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
                        <button type="submit" class="btn-primary flex items-center justify-center gap-2 w-full sm:w-auto">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>{{ __('Search') }}</span>
                        </button>
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
                        <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 8px; color: var(--text);">{{ __('Add New Project') }}</h2>
                        <p style="font-size: 15px; color: var(--text-secondary);">{{ __('Create a new project and organize your work') }}</p>
                    </div>
                    <a href="{{ route('turbo.projects.create') }}" class="btn-primary inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>{{ __('Add Project') }}</span>
                    </a>
                </div>
            </turbo-frame>
        </div>

        <!-- Projects List -->
        <turbo-frame id="projects-lists">
            @include('turbo::projects.list', ['projects' => $projects])
        </turbo-frame>
    </div>
</x-layouts.app>