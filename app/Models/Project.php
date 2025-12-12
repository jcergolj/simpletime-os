<?php

namespace App\Models;

use App\ValueObjects\Duration;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property Client $client
 * @property Money|null $hourlyRate
 * @property Duration $formattedDuration
 */
class Project extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'client_id' => 'integer',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function countInheritedTimeEntries(): int
    {
        return $this->timeEntries()
            ->whereNull('hourly_rate')
            ->count();
    }

    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function (): Duration {
                $totalSeconds = $this->timeEntries->sum('duration');

                return Duration::fromSeconds($totalSeconds);
            }
        );
    }

    public function scopeSearchByName($query, ?string $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('client', fn ($q) => $q->where('name', 'like', '%'.$search.'%'));
        });
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
