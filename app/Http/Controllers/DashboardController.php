<?php

namespace App\Http\Controllers;

use App\Services\DashboardMetricsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardMetricsService $dashboardMetrics
    ) {}

    public function __invoke(Request $request): View
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
