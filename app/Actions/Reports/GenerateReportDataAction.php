<?php

namespace App\Actions\Reports;

use App\Models\TimeEntry;
use App\Services\ReportAggregationService;
use App\ValueObjects\DateRangeFilter;
use App\ValueObjects\ReportData;
use Illuminate\Http\Request;

class GenerateReportDataAction
{
    public function __construct(
        protected ReportAggregationService $aggregationService
    ) {}

    public function execute(Request $request): ReportData
    {
        $dateFilter = DateRangeFilter::fromRequest(
            $request->date_range,
            $request->date_from,
            $request->date_to
        );

        $timeEntries = $this->buildQuery($request, $dateFilter)->get();

        $totalHours = $this->aggregationService->calculateTotalHours($timeEntries);
        $earningsByCurrency = $this->aggregationService->calculateEarningsByCurrency($timeEntries);
        $projectTotals = $this->aggregationService->calculateProjectTotals($timeEntries);

        return new ReportData(
            timeEntries: $timeEntries,
            totalHours: $totalHours,
            earningsByCurrency: $earningsByCurrency,
            projectTotals: $projectTotals,
            dateFilter: $dateFilter
        );
    }

    protected function buildQuery(Request $request, DateRangeFilter $dateFilter)
    {
        return TimeEntry::completed()
            ->with(['client', 'project'])
            ->forClient($request->client_id)
            ->forProject($request->project_id)
            ->betweenDates($dateFilter->startDate, $dateFilter->endDate)
            ->latestFirst();
    }
}
