<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;

class SearchProjects extends SearchComponent
{
    public string $uniqueId;

    public string $projectNameId;

    public string $projectIdId;

    public string $projectResultsId;

    public function __construct(
        public ?int $projectId = null,
        public ?string $projectName = null,
        ?string $searchId = null,
    ) {
        parent::__construct($searchId);

        $this->uniqueId = $searchId ? (string) $searchId : 'main';
        $this->projectNameId = $this->uniqueId.'-project-name';
        $this->projectIdId = $this->uniqueId.'-project-id';
        $this->projectResultsId = $this->uniqueId.'-search-project-results';
    }

    public function render(): View|Closure|string
    {
        return view('components.form.search-projects');
    }
}
