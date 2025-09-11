<turbo-frame id="{{ $frameId }}">
<select name="project_id" class="input-field" style="width: 100%; font-size: 15px;" {{ !$clientId ? 'disabled' : '' }}>
    <option value="">{{ $clientId ? __('All Projects') : __('Select a client first') }}</option>
    @foreach($projects as $project)
        <option value="{{ $project->id }}" {{ $selectedProjectId == $project->id ? 'selected' : '' }}>
            {{ $project->name }}
        </option>
    @endforeach
</select>
</turbo-frame>
