<?php

namespace App\Http\Controllers;

use App\Actions\SyncHourlyRateAction;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ClientController extends Controller
{
    public function __construct(
        protected SyncHourlyRateAction $syncHourlyRate
    ) {}

    public function index(Request $request): View
    {
        $clients = Client::query()
            ->searchByName($request->get('search'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        redirect()->redirectIfLastPageEmpty($request, $clients);

        return view('clients.index', ['clients' => $clients]);
    }

    public function store(StoreClientRequest $request)
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

        return to_intended_route('clients.index');
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        $client->update([
            'name' => $validated['name'],
        ]);

        $this->syncHourlyRate->execute($client, $validated);

        return to_intended_route('clients.index');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        InAppNotification::success(__('Client :name successfully deleted.', ['name' => $client->name]));

        return to_intended_route('clients.index');
    }
}
