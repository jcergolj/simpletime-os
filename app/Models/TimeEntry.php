<?php

namespace App\Models;

use App\ValueObjects\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $start_time
 * @property Carbon|null $end_time
 * @property int|null $duration
 * @property string|null $notes
 * @property int|null $client_id
 * @property int|null $project_id
 * @property Client|null $client
 * @property Project|null $project
 * @property Money|null $hourlyRate
 * @property string $formattedDuration
 */
class TimeEntry extends Model
{
    use HasFactory;

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
        $user = User::first();

        // Attributes are loaded directly from JSON - no eager loading needed
        return $this->hourlyRate
            ?? $this->project->hourlyRate
            ?? $this->client->hourlyRate
            ?? $user?->hourlyRate;
    }

    public function calculateEarnings(): ?Money
    {
        $rate = $this->getEffectiveHourlyRate();

        if (! $rate instanceof Money || ! $this->duration || $this->duration < 0) {
            return null;
        }

        return $rate->earnings($this->duration);
    }

    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function (): string {
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
        );
    }

    protected function hourlyRate(): Attribute
    {
        return Attribute::make(
            get: function (): ?Money {
                if (isset($this->attributes['hourly_rate'])) {
                    return Money::from(json_decode((string) $this->attributes['hourly_rate'], true));
                }

                return null;
            },
            set: function (mixed $value): ?string {
                if ($value instanceof Money) {
                    return json_encode($value->toArray());
                }

                return null;
            }
        );
    }
}
