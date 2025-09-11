<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Services\DashboardMetricsService;
use App\Services\TimerStateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class TimerSessionCompletionController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics,
        protected TimerStateService $timerState
    ) {}

    public function __invoke(Request $request)
    {
        $runningEntry = $this->timerState->getRunningTimer();

        if (! $runningEntry instanceof TimeEntry) {
            return to_route('dashboard');
        }

        $runningEntry->update([
            'end_time' => now(),
            'duration' => max(0, $runningEntry->start_time->diffInSeconds(now())),
        ]);

        Log::channel('time-entries')->info('time-entry-auto-stopped', $runningEntry->toArray());

        InAppNotification::success(__('Session stopped.'));

        return to_route('dashboard');
    }
}
