<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeEntryController extends Controller
{
    public function create(): View
    {
        return view('turbo::time-entries.create');
    }

    public function edit(TimeEntry $timeEntry, Request $request)
    {
        if (! $timeEntry->end_time && $request->boolean('is_recent', false)) {
            return to_route('dashboard')
                ->with('error', 'Cannot edit a running time entry from recent list. Please edit it from the timer widget.');
        }

        return view('turbo::time-entries.edit', ['timeEntry' => $timeEntry, 'is_recent' => $request->boolean('is_recent', false)]);
    }
}
