<?php

namespace App\Services;

use App\Models\TimeEntry;

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
        $timeEntry = TimeEntry::whereNull('end_time')->first();

        if ($timeEntry === null) {
            return;
        }

        $end = now();

        $timeEntry->update([
            'end_time' => $end,
            'duration' => $end->diffInSeconds($timeEntry->start_time),
        ]);
    }

    public function stopRunningTimerAndReturn(): ?TimeEntry
    {
        $runningTimer = $this->getRunningTimer();

        if ($runningTimer instanceof TimeEntry) {
            $this->stopRunningTimer();
            $runningTimer->refresh();
        }

        return $runningTimer;
    }
}
