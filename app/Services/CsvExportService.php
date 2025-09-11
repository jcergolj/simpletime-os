<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CsvExportService
{
    public function generateTimeEntryCsv(
        Collection $timeEntries,
        Collection $earningsByCurrency,
        float $totalHours,
        Collection $projectTotals
    ): string {
        $csv = "Date,Start Time,End Time,Duration (Hours),Client,Project,Notes,Hourly Rate,Earnings\n";

        foreach ($timeEntries as $entry) {
            $earnings = $entry->calculateEarnings();
            $csv .= sprintf(
                "%s,%s,%s,%.2f,%s,%s,%s,%s,%s\n",
                $entry->start_time->format('Y-m-d'),
                $entry->start_time->format('H:i'),
                $entry->end_time?->format('H:i') ?? '',
                $entry->duration / 3600,
                $entry->client->name ?? '',
                $entry->project->name ?? '',
                $this->escapeCsvValue($entry->notes ?? ''),
                $entry->getEffectiveHourlyRate()?->formattedForCsv() ?? '',
                $earnings?->formattedForCsv() ?? ''
            );
        }

        $csv .= "\n";

        foreach ($earningsByCurrency as $currencyCode => $totalMoney) {
            $csv .= sprintf(
                "%s,%s,%s,%.2f,%s,%s,%s,%s,%s\n",
                '',
                '',
                '',
                $totalHours,
                '',
                '',
                '',
                "TOTAL ($currencyCode)",
                $totalMoney->formattedForCsv()
            );
        }

        if ($projectTotals->isNotEmpty()) {
            $csv .= "\n\nSUMMARY BY PROJECT\n";
            $csv .= "Project,Client,Entries,Hours,Earnings\n";

            foreach ($projectTotals as $projectTotal) {
                $earningsDisplay = $projectTotal['earningsByCurrency']
                    ->map(fn ($money) => $money->formattedForCsv())
                    ->implode(' + ');

                $csv .= sprintf(
                    "%s,%s,%d,%.2f,%s\n",
                    $projectTotal['project']->name ?? 'No Project',
                    $projectTotal['project']->client->name ?? 'No Client',
                    $projectTotal['entry_count'],
                    $projectTotal['hours'],
                    $earningsDisplay ?: '0'
                );
            }
        }

        return $csv;
    }

    protected function escapeCsvValue(string $value): string
    {
        return str_replace(['"', ','], ['""', ''], $value);
    }
}
