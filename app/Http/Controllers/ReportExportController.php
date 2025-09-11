<?php

namespace App\Http\Controllers;

use App\Actions\Reports\GenerateReportDataAction;
use App\Services\CsvExportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportExportController extends Controller
{
    public function __construct(
        protected GenerateReportDataAction $generateReportData,
        protected CsvExportService $csvExport
    ) {}

    public function __invoke(Request $request): Response
    {
        $reportData = $this->generateReportData->execute($request);

        $csv = $this->csvExport->generateTimeEntryCsv(
            $reportData->timeEntries,
            $reportData->earningsByCurrency,
            $reportData->totalHours,
            $reportData->projectTotals
        );

        $filename = 'time_report_'.now()->format('Y_m_d_H_i_s').'.csv';

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
