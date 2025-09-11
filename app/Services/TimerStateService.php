<?php

namespace App\Services;

use App\Models\TimeEntry;
use Illuminate\Support\Facades\DB;

class TimerStateService
{
    public function getRunningTimer(): ?TimeEntry
    {
        return TimeEntry::query()
            ->with(['client', 'project'])
            ->whereNull('end_time')
            ->first();
    }

    public function stopRunningTimer(): void
    {
        TimeEntry::whereNull('end_time')->update([
            'end_time' => now(),
            'duration' => DB::raw('strftime("%s", "now") - strftime("%s", start_time)'),
        ]);
    }

    public function stopRunningTimerAndReturn(): ?TimeEntry
    {
        $runningTimer = $this->getRunningTimer();

        if ($runningTimer) {
            $this->stopRunningTimer();
            $runningTimer->refresh();
        }

        return $runningTimer;
    }
}
