<?php

namespace App\ValueObjects;

use Illuminate\Support\Collection;

class ReportData
{
    public function __construct(
        public readonly Collection $timeEntries,
        public readonly float $totalHours,
        public readonly Collection $earningsByCurrency,
        public readonly Collection $projectTotals,
        public readonly DateRangeFilter $dateFilter
    ) {}
}
