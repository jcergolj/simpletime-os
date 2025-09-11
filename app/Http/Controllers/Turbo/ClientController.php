<?php

namespace App\Http\Controllers\Turbo;

use App\Actions\SyncHourlyRateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Turbo\StoreClientRequest;
use App\Http\Requests\Turbo\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function create(): View
    {
        return view('turbo::clients.create');
    }

    public function store(StoreClientRequest $request): JsonResponse|Response
    {
        $validated = $request->validated();

        $client = Client::create([
            'name' => $validated['name'],
        ]);

        $this->syncHourlyRate->execute($client, $validated);

        if ($request->wantsJson() || $request->ajax()) {
            return new JsonResponse([
                'success' => true,
                'client' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'hourly_rate' => $client->hourlyRate?->rate ? $client->hourlyRate->rate->formatted() : null,
                ],
            ]);
        }

        $clients = Client::query()
            ->searchByName($request->get('search'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return turbo_stream_view('turbo::clients.store', [
            'clients' => $clients,
        ]);
    }

    public function edit(Client $client): View
    {
        $client->load('hourlyRate');

        return view('turbo::clients.edit', ['client' => $client]);
    }

    public function update(UpdateClientRequest $request, Client $client): Response
    {
        $validated = $request->validated();

        $client->update([
            'name' => $validated['name'],
        ]);

        $this->syncHourlyRate->execute($client, $validated);

        $clients = Client::query()
            ->searchByName($request->get('search'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return turbo_stream_view('turbo::clients.update', [
            'client' => $client->fresh(),
            'clients' => $clients,
        ]);
    }
}
