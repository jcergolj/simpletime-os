<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $name
 */
class Client extends Model
{
    use HasFactory;

    protected $with = ['hourlyRate'];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function hourlyRate(): MorphOne
    {
        return $this->morphOne(HourlyRate::class, 'rateable');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function scopeSearchByName($query, ?string $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
