<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query) || strlen((string) $query) < 2) {
            return response('', 200);
        }

        $clients = Client::query()
            ->searchByName($query)
            ->limit(10)
            ->get();

        return view('turbo::clients-search.index', [
            'clients' => $clients,
            'query' => $query,
            'defaultHourlyRate' => $request->user()->hourlyRate,
        ]);
    }
}
