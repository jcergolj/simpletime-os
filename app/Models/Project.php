<?php

namespace App\Models;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string|null $description
 * @property Client $client
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

    public function getFormattedDuration(): array
    {
        $totalSeconds = $this->timeEntries->sum('duration');
        $totalHours = floor($totalSeconds / 3600);
        $totalMinutes = floor(($totalSeconds % 3600) / 60);

        return [
            'hours' => $totalHours,
            'minutes' => $totalMinutes,
        ];
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
            get: fn () => isset($this->attributes['hourly_rate'])
                ? Money::from(json_decode($this->attributes['hourly_rate'], true))
                : null,
            set: fn (?Money $value) => [
                'hourly_rate' => $value?->toArray(),
            ]
        );
    }
}
