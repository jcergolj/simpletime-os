<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Models\TimeEntry;
use Illuminate\Support\Facades\Log;

class RunningTimerSessionController extends Controller
{
    public function edit()
    {
        $runningTimer = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if (! $runningTimer) {
            return $this->show();
        }

        return view('turbo::timer-sessions.edit', ['runningTimer' => $runningTimer]);
    }

    public function destroy()
    {
        $runningEntry = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->whereNull('end_time')
            ->first();

        if ($runningEntry) {
            $runningEntry->delete();

            Log::channel('time-entries')->info('timer-session-cancelled', $runningEntry->toArray());
        }

        return to_route('dashboard');
    }
}
