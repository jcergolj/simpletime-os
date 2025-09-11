<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $name
 * @property string|null $description
 * @property Client $client
 */
class Project extends Model
{
    use HasFactory;

    protected $with = ['hourlyRate'];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'client_id' => 'integer',
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

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function countInheritedTimeEntries(): int
    {
        return $this->timeEntries()->whereDoesntHave('hourlyRate')->count();
    }

    public function scopeSearchByName($query, ?string $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('client', fn ($q) => $q->where('name', 'like', '%'.$search.'%'));
        });
    }
}
