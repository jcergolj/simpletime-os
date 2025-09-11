<?php

namespace App\Http\Controllers\Turbo;

use App\Actions\SyncHourlyRateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Turbo\StoreTimeEntryRequest;
use App\Http\Requests\Turbo\UpdateTimeEntryRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimeEntryController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function create()
    {
        return view('turbo::time-entries.create');
    }

    public function store(StoreTimeEntryRequest $request)
    {
        $validated = $request->validated();

        $duration = null;
        if ($validated['end_time']) {
            $startTime = Carbon::parse($validated['start_time']);
            $endTime = Carbon::parse($validated['end_time']);
            $duration = max(0, $startTime->diffInSeconds($endTime));
        }

        $timeEntry = TimeEntry::create([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $duration,
            'notes' => $validated['notes'],
            'client_id' => $validated['client_id'],
            'project_id' => $validated['project_id'],
        ]);

        $this->syncHourlyRate->execute($timeEntry, $validated);

        Log::channel('time-entries')->info('time-entry-created', $timeEntry->toArray());

        $timeEntries = TimeEntry::query()
            ->forClient($request->client_id)
            ->forProject($request->project_id)
            ->betweenDates(
                $request->filled('date_from') ? Carbon::parse($request->date_from) : null,
                $request->filled('date_to') ? Carbon::parse($request->date_to) : null
            )
            ->latestFirst()
            ->paginate(20)
            ->withQueryString();

        $clients = Client::all();
        $projects = Project::with('client')->get();

        return turbo_stream_view('turbo::time-entries.store', [
            'timeEntries' => $timeEntries,
            'clients' => $clients,
            'projects' => $projects,
        ]);
    }

    public function edit(TimeEntry $timeEntry, Request $request)
    {
        if (! $timeEntry->end_time && $request->wasFromTurboFrame(dom_id($timeEntry, 'recent-entry'))) {
            return to_route('dashboard')
                ->with('error', 'Cannot edit a running time entry from recent list. Please edit it from the timer widget.');
        }

        if ($request->has('recent') || $request->wasFromTurboFrame(dom_id($timeEntry, 'recent-entry'))) {
            return view('turbo::time-entries.edit-recent', ['timeEntry' => $timeEntry]);
        }

        return view('turbo::time-entries.edit', ['timeEntry' => $timeEntry]);
    }

    public function update(UpdateTimeEntryRequest $request, TimeEntry $timeEntry)
    {
        if (! $timeEntry->end_time && $request->wasFromTurboFrame(dom_id($timeEntry, 'recent-entry'))) {
            return to_route('dashboard')
                ->with('error', 'Cannot edit a running time entry from recent list. Please edit it from the timer widget.');
        }

        $validated = $request->validated();

        $duration = null;
        if ($validated['end_time']) {
            $startTime = Carbon::parse($validated['start_time']);
            $endTime = Carbon::parse($validated['end_time']);
            $duration = max(0, $startTime->diffInSeconds($endTime));
        }

        $timeEntry->update([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $duration,
            'notes' => $validated['notes'],
            'client_id' => $validated['client_id'],
            'project_id' => $validated['project_id'],
        ]);

        $this->syncHourlyRate->execute($timeEntry, $validated);

        Log::channel('time-entries')->info('time-entry-updated', $timeEntry->fresh()->toArray());

        if ($request->wasFromTurboFrame(dom_id($timeEntry, 'recent-entry'))) {
            $recentEntries = TimeEntry::query()
                ->latest('start_time')
                ->limit(10)
                ->get();

            $runningTimer = $this->dashboardMetrics->getRunningTimer();

            return turbo_stream_view('timer-sessions.recent-entry-update', [
                'timeEntry' => $timeEntry->fresh(),
                'recentEntries' => $recentEntries,
                'runningTimer' => $runningTimer,
            ]);
        }

        $timeEntries = TimeEntry::query()
            ->forClient($request->client_id)
            ->forProject($request->project_id)
            ->betweenDates(
                $request->filled('date_from') ? Carbon::parse($request->date_from) : null,
                $request->filled('date_to') ? Carbon::parse($request->date_to) : null
            )
            ->latestFirst()
            ->paginate(20)
            ->withQueryString();

        $clients = Client::all();
        $projects = Project::with('client')->get();

        return turbo_stream_view('turbo::time-entries.update', [
            'timeEntry' => $timeEntry->fresh(),
            'timeEntries' => $timeEntries,
            'clients' => $clients,
            'projects' => $projects,
        ]);
    }
}
