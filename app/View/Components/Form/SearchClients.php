<?php

namespace App\View\Components\Form;

use App\Models\Client;
use Closure;
use Illuminate\Contracts\View\View;

class SearchClients extends SearchComponent
{
    public string $uniqueId;

    public string $clientNameId;

    public string $clientIdId;

    public string $clientResultsId;

    public ?int $clientId;

    public ?string $clientName;

    public function __construct(
        public ?Client $client = null,
        ?string $searchId = null,
    ) {
        parent::__construct($searchId);
        $this->clientId = $client?->id;
        $this->clientName = $client?->name;
        $this->uniqueId = $searchId ?: 'main';
        $this->clientNameId = $this->uniqueId.'-client-name';
        $this->clientIdId = $this->uniqueId.'-client-id';
        $this->clientResultsId = $this->uniqueId.'-search-client-results';

    }

    public function render(): View|Closure|string
    {
        return view('components.form.search-clients');
    }
}
