<?php

namespace App\Http\Controllers\Turbo;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function create(): View
    {
        return view('turbo::clients.create');
    }

    public function edit(Client $client): View
    {
        $client->load('hourlyRate');

        return view('turbo::clients.edit', ['client' => $client]);
    }
}
