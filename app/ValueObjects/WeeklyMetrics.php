<?php

namespace App\ValueObjects;

class WeeklyMetrics
{
    public function __construct(
        public readonly float $totalHours,
        public readonly int $totalAmount,
        public readonly array $weeklyEarnings
    ) {}
}
