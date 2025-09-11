<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class ClientController extends Controller
{
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

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        InAppNotification::success(__('Client :name successfully deleted.', ['name' => $client->name]));

        return to_intended_route('clients.index');
    }
}
