<div data-controller="search-projects" class="relative" data-search-id="{{ $uniqueId }}">
    <input type="text"
        name="project_name"
        id="{{ $projectNameId }}"
        autocomplete="off"
        placeholder="{{ __('Search or create project...') }}"
        class="input-field"
        style="width: 100%; font-size: 15px;"
        value="{{ $projectName }}"
        data-search-projects-target="input"
        data-action="input->search-projects#query keydown->search-projects#navigate">

    <input type="hidden" name="project_id" id="{{ $projectIdId }}" value="{{ $projectId }}">

    <div data-search-projects-target="results" id="{{ $projectResultsId }}" class="absolute z-50 w-full bg-base-100 rounded-lg mt-1 shadow-lg max-h-[700px] overflow-y-auto"></div>
</div>
