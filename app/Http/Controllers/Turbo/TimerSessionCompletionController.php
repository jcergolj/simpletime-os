<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use App\Services\TimerStateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimerSessionCompletionController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected TimerStateService $timerState
    ) {}

    /** Complete (stop) a running timer session. */
    public function __invoke(Request $request)
    {
        $runningEntry = $this->timerState->getRunningTimer();

        if (! $runningEntry) {
            $clients = Client::all();
            $projects = Project::with('client')->get();

            $lastEntry = TimeEntry::query()->whereNotNull('end_time')
                ->latest('end_time')
                ->first();

            return turbo_stream_view('turbo::timer-sessions.start', [
                'clients' => $clients,
                'projects' => $projects,
                'lastEntry' => $lastEntry,
            ]);
        }

        $runningEntry->update([
            'end_time' => now(),
            'duration' => max(0, $runningEntry->start_time->diffInSeconds(now())),
        ]);

        $clients = Client::all();
        $projects = Project::with('client')->get();

        $lastEntry = $runningEntry->fresh();

        Log::channel('time-entries')->info('time-entry-auto-stopped', $lastEntry->toArray());

        $recentEntries = $this->dashboardMetrics->getRecentEntries();

        return turbo_stream_view('turbo::timer-sessions.stopped', [
            'clients' => $clients,
            'projects' => $projects,
            'lastEntry' => $lastEntry,
            'recentEntries' => $recentEntries,
        ]);
    }
}
