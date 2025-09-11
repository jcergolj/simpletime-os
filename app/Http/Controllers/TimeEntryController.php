<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class TimeEntryController extends Controller
{
    public function index(Request $request): View
    {
        $timeEntries = TimeEntry::query()
            ->with(['client.hourlyRate', 'project.hourlyRate'])
            ->forClient($request->client_id)
            ->forProject($request->project_id)
            ->betweenDates(
                $request->filled('date_from') ? Carbon::parse($request->date_from) : null,
                $request->filled('date_to') ? Carbon::parse($request->date_to) : null
            )
            ->latestFirst()
            ->paginate(20);

        redirect()->redirectIfLastPageEmpty($request, $timeEntries);

        $clients = Client::all();
        $projects = Project::with('client')->get();

        return view('time-entries.index', ['timeEntries' => $timeEntries, 'clients' => $clients, 'projects' => $projects]);
    }

    public function destroy(Request $request, TimeEntry $timeEntry): RedirectResponse
    {
        $timeEntry->delete();

        InAppNotification::success(__('Time entry successfully deleted.'));

        if ($request->is_recent) {
            return to_route('dashboard');
        }

        return to_intended_route('time-entries.index');
    }
}
