<?php

namespace App\ValueObjects;

use Carbon\Carbon;

class DateRangeFilter
{
    public function __construct(
        public readonly ?Carbon $startDate,
        public readonly ?Carbon $endDate
    ) {}

    public static function fromPeriod(string $period): self
    {
        [$startDate, $endDate] = self::getDateRangeFromPeriod($period);

        return new self($startDate, $endDate);
    }

    public static function fromCustomRange(?string $startDate, ?string $endDate): self
    {
        return new self(
            $startDate ? Carbon::parse($startDate) : null,
            $endDate ? Carbon::parse($endDate) : null
        );
    }

    public static function fromRequest(?string $period, ?string $startDate, ?string $endDate): self
    {
        if ($startDate && $endDate) {
            return self::fromCustomRange($startDate, $endDate);
        }

        if ($period) {
            return self::fromPeriod($period);
        }

        return new self(null, null);
    }

    protected static function getDateRangeFromPeriod(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'this_week' => [
                $now->copy()->startOfWeek(),
                $now->copy(),
            ],
            'last_week' => [
                $now->copy()->subWeek()->startOfWeek(),
                $now->copy()->subWeek()->endOfWeek(),
            ],
            'this_month' => [
                $now->copy()->startOfMonth(),
                $now->copy(),
            ],
            'last_month' => [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ],
            'this_year' => [
                $now->copy()->startOfYear(),
                $now->copy(),
            ],
            'last_year' => [
                $now->copy()->subYear()->startOfYear(),
                $now->copy()->subYear()->endOfYear(),
            ],
            default => [null, null],
        };
    }

    public function hasDateRange(): bool
    {
        return $this->startDate instanceof Carbon && $this->endDate instanceof Carbon;
    }
}
