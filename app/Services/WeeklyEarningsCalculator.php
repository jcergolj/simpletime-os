<?php

namespace App\Services;

use App\ValueObjects\Money;
use App\ValueObjects\WeeklyMetrics;
use Illuminate\Support\Collection;

class WeeklyEarningsCalculator
{
    public static function calculate(Collection $weeklyEntries): WeeklyMetrics
    {
        $totalHours = $weeklyEntries->sum('duration') / 3600;

        $earningsByCurrency = $weeklyEntries
            ->map(fn ($entry) => $entry->calculateEarnings())
            ->filter()
            ->groupBy(fn ($money) => $money->currency->value)
            ->map(fn ($group) => [
                'amount' => $group->sum('amount'),
                'currency' => $group->first()->currency,
            ]);

        $totalAmount = (int) $earningsByCurrency->sum('amount');

        $weeklyEarnings = $earningsByCurrency
            ->sortByDesc('amount')
            ->take(5)
            ->map(fn ($earning) => new Money($earning['amount'], $earning['currency']))
            ->values()
            ->all();

        return new WeeklyMetrics(
            totalHours: $totalHours,
            totalAmount: $totalAmount,
            weeklyEarnings: $weeklyEarnings
        );
    }
}
