<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Turbo\StoreRunningTimerSessionRequest;
use App\Http\Requests\Turbo\UpdateRunningTimerSessionRequest;
use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use App\Services\TimerStateService;
use Illuminate\Support\Facades\Log;

class RunningTimerSessionController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected TimerStateService $timerState
    ) {}

    public function show()
    {
        return to_route('dashboard');
    }

    public function store(StoreRunningTimerSessionRequest $request)
    {
        $this->timerState->stopRunningTimer();

        $timeEntry = TimeEntry::create([
            'start_time' => now(),
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
        ]);

        Log::channel('time-entries')->info('time-entry-auto-created', $timeEntry->toArray());

        // Load the timeEntry with relationships for display
        $timeEntry->load(['client.hourlyRate', 'project.hourlyRate', 'hourlyRate']);

        $recentEntries = $this->dashboardMetrics->getRecentEntries();

        return turbo_stream_view('turbo::timer-sessions.started', [
            'timeEntry' => $timeEntry,
            'recentEntries' => $recentEntries,
        ]);
    }

    public function edit()
    {
        $runningTimer = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if (! $runningTimer) {
            return $this->show();
        }

        return view('turbo::timer-sessions.edit', ['runningTimer' => $runningTimer]);
    }

    public function update(UpdateRunningTimerSessionRequest $request)
    {
        $runningEntry = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if (! $runningEntry) {
            return to_route('dashboard');
        }

        $validated = $request->validated();

        $runningEntry->update([
            'client_id' => $validated['client_id'],
            'project_id' => $validated['project_id'],
            'start_time' => $validated['start_time'],
        ]);

        Log::channel('time-entries')->info('timer-session-updated', $runningEntry->toArray());

        return to_route('dashboard');
    }

    public function destroy()
    {
        $runningEntry = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if ($runningEntry) {
            $runningEntry->delete();
        }

        return to_route('dashboard');
    }
}
