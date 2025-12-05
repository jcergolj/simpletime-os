<?php

namespace App\Http\Controllers;

use App\Actions\SyncHourlyRateAction;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use App\Models\Client;
use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class TimeEntryController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function index(Request $request): View
    {
        $timeEntries = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->forClient($request->client_id)
            ->forProject($request->project_id)
            ->betweenDates(
                $request->filled('date_from') ? Carbon::parse($request->date_from) : null,
                $request->filled('date_to') ? Carbon::parse($request->date_to) : null
            )
            ->latestFirst()
            ->paginate(20);

        redirect()->redirectIfLastPageEmpty($request, $timeEntries);

        $clients = Client::all();

        return view('time-entries.index', ['timeEntries' => $timeEntries, 'clients' => $clients]);
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

        return to_intended_route('time-entries.index');
    }

    public function update(TimeEntry $timeEntry, UpdateTimeEntryRequest $request)
    {
        if (! $timeEntry->end_time && $request->boolean('is_recent', false)) {
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

        if ($request->boolean('is_recent', false)) {
            return to_route('dashboard');
        }

        return to_route('time-entries.index');
    }

    public function destroy(Request $request, TimeEntry $timeEntry): RedirectResponse
    {
        $timeEntry->delete();

        InAppNotification::success(__('Time entry successfully deleted.'));

        if ($request->is_recent) {
            return to_route('dashboard');
        }

        return to_intended_route('time-entries.index');
    }
}
