<?php

namespace App\Services;

use App\ValueObjects\Money;
use Illuminate\Support\Collection;

class ReportAggregationService
{
    public function calculateEarningsByCurrency(Collection $timeEntries): Collection
    {
        return $timeEntries
            ->map(fn ($entry) => $entry->calculateEarnings())
            ->filter()
            ->groupBy(fn ($earnings) => $earnings->currency->value)
            ->map(function ($currencyEarnings) {
                $currency = $currencyEarnings->first()->currency;
                $totalAmount = $currencyEarnings->sum('amount');

                return new Money($totalAmount, $currency);
            });
    }

    public function calculateProjectTotals(Collection $timeEntries): Collection
    {
        return $timeEntries
            ->groupBy('project_id')
            ->map(function ($entries) {
                $firstEntry = $entries->first();
                $project = $firstEntry->project;

                if ($project && ! $project->relationLoaded('client')) {
                    $project->load('client');
                }

                $hours = $entries->sum('duration') / 3600;

                $projectEarningsByCurrency = $entries
                    ->map(fn ($entry) => $entry->calculateEarnings())
                    ->filter()
                    ->groupBy(fn ($earnings) => $earnings->currency->value)
                    ->map(function ($currencyEarnings) {
                        $currency = $currencyEarnings->first()->currency;
                        $totalAmount = $currencyEarnings->sum('amount');

                        return new Money($totalAmount, $currency);
                    });

                $earningsForSorting = $projectEarningsByCurrency->first()?->toDecimal() ?? 0;

                return [
                    'project' => $project,
                    'hours' => $hours,
                    'earningsByCurrency' => $projectEarningsByCurrency,
                    'earningsForSorting' => $earningsForSorting,
                    'entry_count' => $entries->count(),
                ];
            })
            ->sortByDesc('earningsForSorting')
            ->values();
    }

    public function calculateTotalHours(Collection $timeEntries): float
    {
        return $timeEntries->sum('duration') / 3600;
    }
}
