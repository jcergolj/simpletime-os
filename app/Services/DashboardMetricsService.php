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
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->whereNotNull('end_time')
            ->get();

        $totalHours = $weeklyEntries->sum('duration') / 3600;

        $earnings = WeeklyEarningsCalculator::calculate($weeklyEntries);

        return new WeeklyMetrics(
            totalHours: $totalHours,
            totalAmount: $earnings['totalAmount'],
            weeklyEarnings: $earnings['weeklyEarnings']
        );
    }

    public function getRecentEntries(int $limit = 5)
    {
        return TimeEntry::query()
            ->with(['client', 'project'])
            ->latest('start_time')
            ->limit($limit)
            ->get();
    }

    public function getRunningTimer(): ?TimeEntry
    {
        return TimeEntry::whereNull('end_time')->first();
    }
}
