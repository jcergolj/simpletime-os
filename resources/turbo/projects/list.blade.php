<div class="card mx-4 sm:mx-0" style="padding: 0;">
    <div style="padding: 28px 32px; border-bottom: 1px solid var(--border);">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 style="font-size: 28px; font-weight: 600; color: var(--text); margin-bottom: 4px;">{{ __('Your Projects') }}</h3>
                <p style="font-size: 14px; color: var(--text-secondary);">{{ $projects->total() }} {{ Str::plural(__('project'), $projects->total()) }} {{ __('total') }}</p>
            </div>
            @if($projects->hasPages())
                <div style="font-size: 14px; color: var(--text-secondary);">
                    {{ __('Showing') }} {{ $projects->firstItem() }}-{{ $projects->lastItem() }} {{ __('of') }} {{ $projects->total() }}
                </div>
            @endif
        </div>
    </div>

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
                <div class="flex items-center gap-2">
                    <a href="{{ route('projects.edit', $project) }}" style="padding: 8px 16px; background: var(--accent); color: white; border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;">
                        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span style="line-height: 1;">{{ __('Edit') }}</span>
                    </a>

                    <a href="{{ route('projects.destroy', $project) }}"
                       style="padding: 8px 16px; background: white; color: var(--text); border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;"
                       data-turbo-method="delete"
                       data-turbo-confirm="Are you sure you want to delete this project? This will also delete all associated time entries."
                       data-turbo-frame="_top">
                        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span style="line-height: 1;">{{ __('Delete') }}</span>
                    </a>
                </div>
            </div>
            @if($project->description)
                <div style="margin-top: 12px;">
                    <div class="entry-label">{{ __('Description') }}</div>
                    <p style="font-size: 15px; color: var(--text-secondary);">{{ $project->description }}</p>
                </div>
            @endif
        </div>
        </turbo-frame>
    @empty
        <div style="padding: 64px 32px; text-align: center;">
            <div style="width: 64px; height: 64px; margin: 0 auto 16px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-center;">
                <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text);">{{ __('No projects yet') }}</h3>
            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">{{ __('Get started by adding your first project above.') }}</p>
            <a href="{{ route('projects.create') }}" style="padding: 12px 24px; background: var(--accent); color: white; border-radius: 8px; font-size: 15px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;" data-turbo-frame="project-create-form">
                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span style="line-height: 1;">{{ __('Add Your First Project') }}</span>
            </a>
        </div>
    @endforelse

    @if($projects->hasPages())
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            {{ $projects->links() }}
        </div>
    @endif
</div>
