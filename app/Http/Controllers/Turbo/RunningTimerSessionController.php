<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Turbo\StoreRunningTimerSessionRequest;
use App\Http\Requests\Turbo\UpdateRunningTimerSessionRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use App\Services\TimerStateService;
use Illuminate\Support\Facades\Log;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class RunningTimerSessionController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected TimerStateService $timerState
    ) {}

    public function show()
    {
        $runningTimer = $this->timerState->getRunningTimer();

        $clients = Client::all();
        $projects = Project::with('client')->get();

        $lastEntry = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNotNull('end_time')
            ->latest('end_time')
            ->first();

        if ($runningTimer) {
            return view('turbo::timer-sessions.running', [
                'runningTimer' => $runningTimer,
                'entry' => $runningTimer,
                'clients' => $clients,
                'projects' => $projects,
            ]);
        }

        return view('turbo::timer-sessions.start', ['clients' => $clients, 'projects' => $projects, 'lastEntry' => $lastEntry]);
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

        InAppNotification::success('estasnrietnr');

        return back();
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

        $clients = Client::all();
        $projects = Project::with('client')->get();

        return view('turbo::timer-sessions.edit', ['runningTimer' => $runningTimer, 'clients' => $clients, 'projects' => $projects]);
    }

    public function update(UpdateRunningTimerSessionRequest $request)
    {
        $runningEntry = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if (! $runningEntry) {
            return to_route('turbo.running-timer-session.show');
        }

        $validated = $request->validated();

        $runningEntry->update([
            'client_id' => $validated['client_id'],
            'project_id' => $validated['project_id'],
            'start_time' => $validated['start_time'],
        ]);

        Log::channel('time-entries')->info('timer-session-updated', $runningEntry->fresh()->toArray());
        return back();
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

        return back();
    }
}
