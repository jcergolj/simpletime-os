<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function create(): View
    {
        return view('turbo::projects.create');
    }

    public function edit(Project $project): View
    {
        return view('turbo::projects.edit', [
            'project' => $project,
        ]);
    }
}
