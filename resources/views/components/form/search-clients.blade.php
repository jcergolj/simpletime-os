
<div data-controller="search-clients" class="relative" data-search-id="{{ $uniqueId }}">

    <input type="text"
        name="client_name"
        id="{{ $clientNameId }}"
        autocomplete="off"
        placeholder="Search clients..."
        class="input input-bordered input-lg w-full text-lg"
        value="{{ $clientName }}"
        data-search-clients-target="input"
        data-action="input->search-clients#query keydown->search-clients#navigate">

    <input type="hidden" name="client_id" id="{{ $clientIdId }}" value="{{ $clientId }}">

    <div data-search-clients-target="results" id="{{ $clientResultsId }}" class="absolute z-50 w-full bg-base-100 rounded-lg mt-1 shadow-lg max-h-96 overflow-y-auto"></div>
</div>
