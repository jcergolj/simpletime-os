<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property \App\ValueObjects\Money|null $hourly_rate
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hourly_rate',
    ];

    protected function casts(): array
    {
        return [
            'hourly_rate' => \App\Casts\AsMoney::class,
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }
}
