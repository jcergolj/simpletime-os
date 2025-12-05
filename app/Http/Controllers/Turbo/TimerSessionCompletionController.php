<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
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

    public function __invoke(Request $request)
    {
        $runningEntry = $this->timerState->getRunningTimer();

        if (! $runningEntry) {
            return to_route('dashboard');
        }

        $runningEntry->update([
            'end_time' => now(),
            'duration' => max(0, $runningEntry->start_time->diffInSeconds(now())),
        ]);

        Log::channel('time-entries')->info('time-entry-auto-stopped', $runningEntry->toArray());

        return to_route('dashboard');
    }
}
