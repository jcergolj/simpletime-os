<turbo-frame id="project-create-form">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-1">{{ __('Add New Project') }}</h2>
            <p class="text-gray-600 text-sm sm:text-base">{{ __('Create a new project and organize your work.') }}</p>
        </div>
        <a href="{{ route('projects.create') }}" style="background: var(--accent); color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 15px; line-height: 1; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%; text-decoration: none;" class="sm:w-auto">
            <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span style="line-height: 1;">{{ __('Add Project') }}</span>
        </a>
    </div>
</turbo-frame>
