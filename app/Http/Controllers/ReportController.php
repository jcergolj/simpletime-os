<?php

namespace App\Http\Controllers;

use App\Actions\Reports\GenerateReportDataAction;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected GenerateReportDataAction $generateReportData
    ) {}

    public function index(Request $request): View
    {
        $reportData = $this->generateReportData->execute($request);

        return view('reports.index', [
            'reportData' => $reportData,
            'clients' => Client::all(),
        ]);
    }
}
