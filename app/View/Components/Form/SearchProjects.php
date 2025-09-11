<?php

namespace App\View\Components\Form;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;

class SearchProjects extends SearchComponent
{
    public string $uniqueId;

    public string $projectNameId;

    public string $projectIdId;

    public string $projectResultsId;

    public ?int $projectId;

    public ?string $projectName;

    public function __construct(
        public ?Project $project = null,
        ?string $searchId = null,
    ) {
        parent::__construct($searchId);
        $this->projectId = $project?->id;
        $this->projectName = $project?->name;
        $this->uniqueId = $searchId ?: 'main';
        $this->projectNameId = $this->uniqueId.'-project-name';
        $this->projectIdId = $this->uniqueId.'-project-id';
        $this->projectResultsId = $this->uniqueId.'-search-project-results';
    }

    public function render(): View|Closure|string
    {
        return view('components.form.search-projects');
    }
}
