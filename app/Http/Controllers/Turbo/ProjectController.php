<?php

namespace App\Http\Controllers\Turbo;

use App\Actions\SyncHourlyRateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Turbo\StoreProjectRequest;
use App\Http\Requests\Turbo\UpdateProjectRequest;
use App\Models\Project;
use App\ValueObjects\Money;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function create()
    {
        return view('turbo::projects.create');
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
                    'hourly_rate' => $project->hourlyRate?->rate ? $project->hourlyRate->rate->formatted() : null,
                ],
                'message' => __('New project successfully created.'),
            ]);
        }

        $projects = Project::with('client')
            ->searchByName($request->get('search'))
            ->paginate(10)
            ->withQueryString();

        return turbo_stream_view('turbo::projects.store', [
            'projects' => $projects,
        ]);
    }

    public function edit(Project $project)
    {
        return view('turbo::projects.edit', [
            'project' => $project
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $originalHourlyRate = $project->hourlyRate?->rate;

        $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
        ]);

        $this->syncHourlyRate->execute($project, $validated);

        $newHourlyRate = $project->fresh(['hourlyRate'])->hourlyRate?->rate;

        if ($request->boolean('update_existing_entries') && $this->hourlyRateChanged($originalHourlyRate, $newHourlyRate)) {
            $timeEntriesToUpdate = $project->timeEntries()->whereDoesntHave('hourlyRate')->get();

            foreach ($timeEntriesToUpdate as $timeEntry) {
                if ($newHourlyRate instanceof \App\ValueObjects\Money) {
                    $timeEntry->hourlyRate()->create([
                        'rate' => $newHourlyRate,
                    ]);
                }
            }
        }

        $projects = Project::with('client')
            ->searchByName($request->get('search'))
            ->paginate(10)
            ->withQueryString();

        return turbo_stream_view('turbo::projects.update', [
            'project' => $project->fresh(['client']),
            'projects' => $projects,
        ]);
    }

    private function hourlyRateChanged(?Money $original, ?Money $new): bool
    {
        if (! $original instanceof \App\ValueObjects\Money && ! $new instanceof \App\ValueObjects\Money) {
            return false;
        }

        if (! $original instanceof \App\ValueObjects\Money || ! $new instanceof \App\ValueObjects\Money) {
            return true;
        }

        return ! $original->equals($new);
    }
}
