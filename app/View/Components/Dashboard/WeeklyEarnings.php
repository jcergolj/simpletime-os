<?php

namespace App\View\Components\Dashboard;

use App\Services\DashboardMetricsService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeeklyEarnings extends Component
{
    public function __construct(
        public DashboardMetricsService $dashboardMetrics
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.dashboard.weekly-earnings', [
            'metrics' => $this->dashboardMetrics->getWeeklyMetrics(),
        ]);
    }
}
