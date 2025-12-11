<?php

namespace App\ValueObjects;

use Illuminate\Support\Collection;

readonly class ReportData
{
    public function __construct(
        public Collection $timeEntries,
        public float $totalHours,
        public Collection $earningsByCurrency,
        public Collection $projectTotals,
        public DateRangeFilter $dateFilter
    ) {}
}
