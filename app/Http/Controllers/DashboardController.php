<?php

namespace App\Http\Controllers;

use App\Services\DashboardMetricsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics
    ) {}

    public function __invoke(): View
    {
        $recentEntries = $this->dashboardMetrics->getRecentEntries();
        $lastEntry = $recentEntries->first();
        $runningTimer = $this->dashboardMetrics->getRunningTimer();

        return view('dashboard', [
            'recentEntries' => $recentEntries,
            'lastEntry' => $lastEntry,
            'runningTimer' => $runningTimer,
        ]);
    }
}
