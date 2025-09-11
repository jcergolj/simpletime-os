<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRunningTimerSessionRequest;
use App\Http\Requests\UpdateRunningTimerSessionRequest;
use App\Models\TimeEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RunningTimerSessionController extends Controller
{
    public function store(StoreRunningTimerSessionRequest $request)
    {
        if (TimeEntry::whereNull('end_time')->first() !== null) {
            return to_route('dashboard');
        }

        $timeEntry = TimeEntry::create([
            'start_time' => now(),
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
        ]);

        Log::channel('time-entries')->info('time-entry-auto-created', $timeEntry->toArray());

        return to_route('dashboard');
    }

    public function update(UpdateRunningTimerSessionRequest $request)
    {
        $runningEntry = TimeEntry::query()
            ->with(['client', 'project'])
            ->whereNull('end_time')
            ->first();

        if (! $runningEntry) {
            return to_route('dashboard');
        }

        $validated = $request->validated();

        $runningEntry->update([
            'client_id' => $validated['client_id'],
            'project_id' => $validated['project_id'],
            'start_time' => $validated['start_time'],
        ]);

        Log::channel('time-entries')->info('timer-session-updated', $runningEntry->toArray());

        return to_route('dashboard');
    }

    public function edit(): View|RedirectResponse
    {
        $runningTimer = TimeEntry::query()
            ->with(['client', 'project'])
            ->whereNull('end_time')
            ->first();

        if (! $runningTimer) {
            return redirect()->route('dashboard');
        }

        return view('turbo::timer-sessions.edit', ['runningTimer' => $runningTimer]);
    }

    public function destroy(): RedirectResponse
    {
        $runningEntry = TimeEntry::query()
            ->with(['client', 'project'])
            ->whereNull('end_time')
            ->first();

        if ($runningEntry) {
            $runningEntry->delete();

            Log::channel('time-entries')->info('timer-session-cancelled', $runningEntry->toArray());
        }

        return to_route('dashboard');
    }
}
