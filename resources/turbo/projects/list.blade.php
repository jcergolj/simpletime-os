<div class="card mx-4 sm:mx-0" style="padding: 0;">
    <x-list.header
        :title="__('Your Projects')"
        :items="$projects"
        :singularLabel="__('project')"
        :pluralLabel="__('projects')"
    />

    @forelse($projects as $project)
        <turbo-frame id="project-{{ $project->id }}">
        <div style="padding: 28px 32px; border-bottom: 1px solid var(--border);" class="last:border-b-0">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Project Info -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <div class="entry-label">{{ __('Project Name') }}</div>
                        <div class="entry-value">{{ $project->name }}</div>
                    </div>
                    <div>
                        <div class="entry-label">{{ __('Client') }}</div>
                        <div class="entry-value">{{ $project->client->name }}</div>
                    </div>
                    <div>
                        <div class="entry-label">{{ __('Hourly Rate') }}</div>
                        <div class="entry-value">
                            @if($project->hourlyRate)
                                {{ $project->hourlyRate->formatted() }}/hr
                            @elseif($project->client->hourlyRate?->amount)
                                {{ $project->client->hourlyRate->formatted() }}/hr
                            @else
                                <span style="color: var(--text-muted);">{{ __('No rate set') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <x-list.action-buttons
                    :edit-route="route('projects.edit', $project)"
                    :delete-route="route('projects.destroy', $project)"
                    :confirm-message="__('Are you sure you want to delete this project? This will also delete all associated time entries.')"
                />
            </div>
        </div>
        </turbo-frame>
    @empty
        <x-list.empty-state
            :title="__('No projects yet')"
            :description="__('Get started by adding your first project above.')"
            :action-route="route('projects.create')"
            :action-text="__('Add Your First Project')"
            turbo-frame="project-create-form">
            <x-slot:icon>
                <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </x-slot:icon>
        </x-list.empty-state>
    @endforelse

    @if($projects->hasPages())
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            {{ $projects->links() }}
        </div>
    @endif
</div>
