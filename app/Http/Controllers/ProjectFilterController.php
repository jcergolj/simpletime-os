<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectFilterController extends Controller
{
    public function __invoke(Request $request): JsonResponse|View
    {
        $clientId = $request->input('client_id');
        $selectedProjectId = $request->input('selected_project_id');

        $projects = collect();

        if ($clientId) {
            $projects = Project::with('client')
                ->where('client_id', $clientId)
                ->orderBy('name')
                ->get();
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return new JsonResponse([
                'projects' => $projects->map(fn ($project) => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'client_name' => $project->client?->name,
                ]),
            ]);
        }

        $frameId = $request->header('Turbo-Frame', 'project-filter-desktop');

        return view('turbo::project-filter.index', [
            'projects' => $projects,
            'selectedProjectId' => $selectedProjectId,
            'clientId' => $clientId,
            'frameId' => $frameId,
        ]);
    }
}
