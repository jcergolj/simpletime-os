<?php

namespace App\Models;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon|null $end_time
 * @property int|null $duration
 * @property string|null $notes
 * @property int|null $client_id
 * @property int|null $project_id
 * @property Client|null $client
 * @property Project|null $project
 */
class TimeEntry extends Model
{
    use HasFactory;

    protected $with = ['hourlyRate'];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'duration' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'client_id' => 'integer',
            'project_id' => 'integer',
        ];
    }

    public function hourlyRate(): MorphOne
    {
        return $this->morphOne(HourlyRate::class, 'rateable');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('end_time');
    }

    public function scopeForClient($query, ?int $clientId)
    {
        return $query->when($clientId, fn ($q) => $q->where('client_id', $clientId));
    }

    public function scopeForProject($query, ?int $projectId)
    {
        return $query->when($projectId, fn ($q) => $q->where('project_id', $projectId));
    }

    public function scopeBetweenDates($query, $startDate = null, $endDate = null)
    {
        return $query->when($startDate, fn ($q) => $q->where('start_time', '>=', $startDate))
            ->when($endDate, fn ($q) => $q->where('start_time', '<=', $endDate->endOfDay()));
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('start_time');
    }

    public function getEffectiveHourlyRate(): ?Money
    {
        return $this->hourlyRate?->rate
            ?? $this->project->hourlyRate?->rate
            ?? $this->client?->hourlyRate?->rate
            ?? User::first()?->hourlyRate?->rate;
    }

    public function calculateEarnings(): ?Money
    {
        $rate = $this->getEffectiveHourlyRate();

        if (! $rate instanceof Money || ! $this->duration || $this->duration < 0) {
            return null;
        }

        $hours = $this->duration / 3600;

        return new Money(
            amount: (int) round($rate->amount * $hours),
            currency: $rate->currency
        );
    }

    public function getFormattedDuration(): string
    {
        if (! $this->duration || $this->duration < 0) {
            return '0m';
        }

        $hours = intval($this->duration / 3600);
        $minutes = intval(($this->duration % 3600) / 60);
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        }

        if ($hours > 0) {
            return "{$hours}h";
        }

        return "{$minutes}m";
    }
}
