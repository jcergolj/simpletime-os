<x-layouts.app :title="__('Reports')">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="px-4 sm:px-0 animate-fade-in-up">
            <h1 class="font-display" style="font-size: 48px; margin-bottom: 8px; color: var(--color-text); text-align: center;">{{ __('Reports') }}</h1>
            <p style="font-size: 18px; color: var(--color-text-secondary); font-weight: 400; text-align: center;">{{ __('View detailed time tracking reports and export data.') }}</p>
        </div>

        <!-- Filters -->
        <div class="card mx-4 sm:mx-0 animate-fade-in-up stagger-1" style="padding: 32px;">
            <h2 class="font-display" style="font-size: 22px; color: var(--color-text); margin-bottom: 24px;">{{ __('Report Filters') }}</h2>
            <form method="GET" action="{{ route('reports.index') }}">
                <!-- Mobile: Stacked layout -->
                <div class="block xl:hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="label">{{ __('Client') }}</label>
                            <select name="client_id" class="input-field">
                                <option value="">{{ __('All Clients') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" @selected(request()->client_id == $client->id)>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">{{ __('Project') }}</label>
                            <turbo-frame id="project-filter-mobile" src="{{ route('project-filter', ['client_id' => request('client_id'), 'selected_project_id' => request('project_id')]) }}" loading="lazy">
                                <select name="project_id" class="input-field" style="background: var(--bg); font-size: 15px;" disabled>
                                    <option value="">{{ request('client_id') ? __('Loading projects...') : __('Select a client first') }}</option>
                                </select>
                            </turbo-frame>
                        </div>
                        <div>
                            <label class="label">{{ __('From Date') }}</label>
                            <input type="date" name="date_from" value="{{ $reportData->dateFilter->startDate?->format('Y-m-d') ?? request('date_from') }}"
                                   class="input-field">
                        </div>
                        <div>
                            <label class="label">{{ __('To Date') }}</label>
                            <input type="date" name="date_to" value="{{ $reportData->dateFilter->endDate?->format('Y-m-d') ?? request('date_to') }}"
                                   class="input-field">
                        </div>
                        <div>
                            <label class="label">{{ __('Quick Select') }}</label>
                            <select name="date_range" id="date-range-select" class="input-field">
                                <option value="" {{ request('date_range') == '' ? 'selected' : '' }}>{{ __('Custom Range') }}</option>
                                <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>{{ __('This Week') }}</option>
                                <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>{{ __('Last Week') }}</option>
                                <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>{{ __('This Month') }}</option>
                                <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>{{ __('Last Month') }}</option>
                                <option value="this_year" {{ request('date_range') == 'this_year' ? 'selected' : '' }}>{{ __('This Year') }}</option>
                                <option value="last_year" {{ request('date_range') == 'last_year' ? 'selected' : '' }}>{{ __('Last Year') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="sm:w-auto" style="padding: 8px 16px; background: var(--accent); color: white; border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; border: none;">
                            <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span style="line-height: 1;">{{ __('Generate') }}</span>
                        </button>
                        <a href="{{ route('reports.index') }}" style="padding: 8px 16px; background: white; color: var(--text); border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <span style="line-height: 1;">{{ __('Clear Filters') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Desktop XL: Single line layout -->
                <div class="hidden xl:block">
                    <div class="flex items-end gap-4 mb-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Client') }}</label>
                            <select name="client_id" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="">{{ __('All Clients') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Project') }}</label>
                            <turbo-frame id="project-filter-desktop" src="{{ route('project-filter', ['client_id' => request('client_id'), 'selected_project_id' => request('project_id')]) }}" loading="lazy">
                                <select name="project_id" class="input-field" style="background: var(--bg); font-size: 15px;" disabled>
                                    <option value="">{{ request('client_id') ? __('Loading projects...') : __('Select a client first') }}</option>
                                </select>
                            </turbo-frame>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('From Date') }}</label>
                            <input type="date" name="date_from" value="{{ $reportData->dateFilter->startDate?->format('Y-m-d') ?? request('date_from') }}"
                                   class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('To Date') }}</label>
                            <input type="date" name="date_to" value="{{ $reportData->dateFilter->endDate?->format('Y-m-d') ?? request('date_to') }}"
                                   class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Quick Select') }}</label>
                            <select name="date_range" id="date-range-select" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="" {{ request('date_range') == '' ? 'selected' : '' }}>{{ __('Custom Range') }}</option>
                                <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>{{ __('This Week') }}</option>
                                <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>{{ __('Last Week') }}</option>
                                <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>{{ __('This Month') }}</option>
                                <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>{{ __('Last Month') }}</option>
                                <option value="this_year" {{ request('date_range') == 'this_year' ? 'selected' : '' }}>{{ __('This Year') }}</option>
                                <option value="last_year" {{ request('date_range') == 'last_year' ? 'selected' : '' }}>{{ __('Last Year') }}</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" style="height: 40px; background: var(--accent); color: white; padding: 0 16px; border-radius: 8px; font-weight: 500; font-size: 14px; line-height: 1; border: none; display: flex; align-items: center; gap: 6px; white-space: nowrap;">
                                <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span style="line-height: 1;">{{ __('Generate') }}</span>
                            </button>
                            <a href="{{ route('reports.index') }}" style="height: 40px; color: var(--text); padding: 0 16px; font-weight: 500; font-size: 14px; line-height: 1; display: flex; align-items: center; white-space: nowrap; text-decoration: none;">
                                <span style="line-height: 1;">{{ __('Clear Filters') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 justify-between items-center">
                    <a href="{{ route('report-exports.show', request()->all()) }}" style="background: #059669; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 500; font-size: 14px; line-height: 1; display: flex; align-items: center; gap: 6px; text-decoration: none; border: none;">
                        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span style="line-height: 1;">{{ __('Export CSV') }}</span>
                    </a>

                    <!-- Summary Stats Inline -->
                    <div class="flex gap-6 text-sm">
                        <div class="text-center">
                            <div class="text-gray-500">{{ __('Total Hours') }}</div>
                            <div class="text-lg font-bold text-gray-900">{{ number_format($reportData->totalHours, 1) }}h</div>
                        </div>
                        <div class="text-center">
                            <div class="text-gray-500">{{ __('Total Earnings') }}</div>
                            @if($reportData->earningsByCurrency->isNotEmpty())
                                <div class="text-lg font-bold text-gray-900">
                                    @foreach($reportData->earningsByCurrency as $currencyCode => $totalMoney)
                                        <div>{{ $totalMoney->formatted() }}</div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-lg font-bold text-gray-900">{{ __('No earnings') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Project Summary -->
        @if($reportData->projectTotals->isNotEmpty())
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-medium text-gray-900">{{ __('Summary by Project') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Project') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Client') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Entries') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Hours') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Earnings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData->projectTotals as $total)
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        {{ $total['project']?->name ?? __('No Project') }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-700">
                                        {{ $total['project']?->client?->name ?? __('No Client') }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-900">
                                        {{ $total['entry_count'] }}
                                    </td>
                                    <td class="py-4 px-6 font-mono text-gray-900">
                                        {{ number_format($total['hours'], 1) }}h
                                    </td>
                                    <td class="py-4 px-6 font-medium text-green-600">
                                        @if($total['earningsByCurrency']->isNotEmpty())
                                            @foreach($total['earningsByCurrency'] as $currencyCode => $totalMoney)
                                                <div>{{ $totalMoney->formatted() }}</div>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Detailed Time Entries -->
        @if($reportData->timeEntries->isNotEmpty())
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-medium text-gray-900">{{ __('Detailed Time Entries') }} ({{ $reportData->timeEntries->count() }} {{ Str::plural('entry', $reportData->timeEntries->count()) }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Date & Time') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Client / Project') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Duration') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Hourly Rate') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Earnings') }}</th>
                                <th class="text-left py-3 px-6 text-sm font-medium text-gray-900">{{ __('Notes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData->timeEntries as $timeEntry)
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900"><x-user-date :date="$timeEntry->start_time" /></div>
                                        <div class="text-sm text-gray-500">
                                            <x-user-time :time="$timeEntry->start_time" /> - <x-user-time :time="$timeEntry->end_time" />
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">{{ $timeEntry->client?->name ?? 'No Client' }}</div>
                                        <div class="text-sm text-gray-500">{{ $timeEntry->project?->name ?? 'No Project' }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-mono text-gray-900">{{ gmdate('H:i:s', $timeEntry->duration) }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-900">
                                        {{ $timeEntry->getEffectiveHourlyRate()?->formatted() ?? __('Not set') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium text-green-600">{{ $timeEntry->calculateEarnings()?->formatted() ?? '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="max-w-xs truncate text-sm text-gray-500">
                                            {{ $timeEntry->notes ?: __('No notes') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No completed time entries found') }}</h3>
                <p class="text-gray-600">{{ __('Try adjusting your filters or add some completed time entries to see reports.') }}</p>
            </div>
        @endif
    </div>

    <script>
        // Handle client selection change - reload project filter turbo frames
        document.querySelectorAll('select[name="client_id"]').forEach(function(clientSelect) {
            clientSelect.addEventListener('change', function() {
                const selectedClientId = this.value;
                const currentProjectId = document.querySelector('select[name="project_id"]')?.value || '';
                const filterUrl = '{{ route('project-filter') }}?client_id=' + selectedClientId + '&selected_project_id=' + currentProjectId;

                // Update both mobile and desktop turbo frames
                document.getElementById('project-filter-mobile')?.setAttribute('src', filterUrl);
                document.getElementById('project-filter-desktop')?.setAttribute('src', filterUrl);
                document.getElementById('project-filter-mobile')?.reload();
                document.getElementById('project-filter-desktop')?.reload();
            });
        });
    </script>
</x-layouts.app>
