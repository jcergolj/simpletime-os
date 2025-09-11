<?php

namespace App\Services;

use App\Models\TimeEntry;
use App\ValueObjects\WeeklyMetrics;
use Carbon\Carbon;

class DashboardMetricsService
{
    public function getWeeklyMetrics(): WeeklyMetrics
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyEntries = TimeEntry::query()
            ->with(['client', 'project'])
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->whereNotNull('end_time')
            ->get();

        return WeeklyEarningsCalculator::calculate($weeklyEntries);
    }

    public function getRecentEntries(int $limit = 5)
    {
        return TimeEntry::query()
            ->with(['client', 'project'])
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getRunningTimer(): ?TimeEntry
    {
        return TimeEntry::query()
            ->with(['client', 'project'])
            ->whereNull('end_time')
            ->first();
    }
}
