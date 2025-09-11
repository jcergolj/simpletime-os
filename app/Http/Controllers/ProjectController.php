<?php

namespace App\Http\Controllers;

use App\Actions\SyncHourlyRateAction;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use App\ValueObjects\Money;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ProjectController extends Controller
{
    public function __construct(
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function index(Request $request): View
    {
        $projects = Project::with('client')
            ->searchByName($request->get('search'))
            ->paginate(10)
            ->withQueryString();

        redirect()->redirectIfLastPageEmpty($request, $projects);

        return view('projects.index', ['projects' => $projects]);
    }

    public function create(): View
    {
        $clients = Client::all();

        return view('turbo::projects.create', compact('clients'));
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = Project::create([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
        ]);

        $this->syncHourlyRate->execute($project, $validated);

        if ($request->wantsJson() || $request->ajax()) {
            return new JsonResponse([
                'success' => true,
                'project' => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'client_name' => $project->client->name,
                    'hourly_rate' => $project->hourlyRate?->formatted(),
                ],
                'message' => __('New project successfully created.'),
            ]);
        }

        return to_intended_route('projects.index');
    }

    public function edit(Project $project): View
    {
        $clients = Client::all();

        return view('turbo::projects.edit', compact('project', 'clients'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $originalHourlyRate = $project->hourlyRate;

        $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
        ]);

        $this->syncHourlyRate->execute($project, $validated);

        $newHourlyRate = $project->fresh()->hourlyRate;

        if ($request->boolean('update_existing_entries') && $this->hourlyRateChanged($originalHourlyRate, $newHourlyRate)) {
            $timeEntriesToUpdate = $project->timeEntries()->whereNull('hourly_rate')->get();

            foreach ($timeEntriesToUpdate as $timeEntry) {
                if ($newHourlyRate instanceof Money) {
                    $timeEntry->hourlyRate = $newHourlyRate;
                    $timeEntry->save();
                }
            }
        }

        return to_intended_route('projects.index');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $projectName = $project->name;
        $project->delete();

        InAppNotification::success(__('Project :name successfully deleted.', ['name' => $projectName]));

        return to_intended_route('projects.index');
    }

    private function hourlyRateChanged(?Money $original, ?Money $new): bool
    {
        if (! $original instanceof Money && ! $new instanceof Money) {
            return false;
        }

        if (! $original instanceof Money || ! $new instanceof Money) {
            return true;
        }

        return ! $original->equals($new);
    }
}
