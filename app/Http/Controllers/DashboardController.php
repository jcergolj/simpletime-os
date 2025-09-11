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

        $preselectedClientId = $request->get('client_id', $lastEntry?->client_id);
        $preselectedClientName = $request->get('client_name', $lastEntry?->client?->name);
        $preselectedProjectId = $request->get('project_id', $lastEntry?->project_id);
        $preselectedProjectName = $request->get('project_name', $lastEntry?->project?->name);

        return view('dashboard', [
            'recentEntries' => $recentEntries,
            'lastEntry' => $lastEntry,
            'runningTimer' => $runningTimer,
            'preselectedClientId' => $preselectedClientId,
            'preselectedClientName' => $preselectedClientName,
            'preselectedProjectId' => $preselectedProjectId,
            'preselectedProjectName' => $preselectedProjectName,
        ]);
    }
}
