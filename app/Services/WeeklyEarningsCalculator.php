<?php

namespace App\Services;

use App\ValueObjects\Money;
use Illuminate\Support\Collection;

class WeeklyEarningsCalculator
{
    public static function calculate(Collection $weeklyEntries): array
    {
        $earningsByCurrency = [];
        foreach ($weeklyEntries as $entry) {
            $earnings = $entry->calculateEarnings();
            if ($earnings) {
                $currencyCode = $earnings->currency->value;
                if (! isset($earningsByCurrency[$currencyCode])) {
                    $earningsByCurrency[$currencyCode] = [
                        'amount' => 0,
                        'currency' => $earnings->currency,
                    ];
                }
                $earningsByCurrency[$currencyCode]['amount'] += $earnings->amount;
            }
        }

        uasort($earningsByCurrency, fn ($a, $b) => $b['amount'] <=> $a['amount']);
        $topEarnings = array_slice($earningsByCurrency, 0, 5);

        $weeklyEarnings = array_map(
            fn ($earning) => new Money($earning['amount'], $earning['currency']),
            $topEarnings
        );

        $totalAmount = array_sum(array_column($earningsByCurrency, 'amount'));

        return [
            'weeklyEarnings' => $weeklyEarnings,
            'totalAmount' => $totalAmount,
        ];
    }
}
