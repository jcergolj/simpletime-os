<?php

namespace App\Models;

use App\ValueObjects\DateTimeFormatter;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property Money|null $hourlyRate
 * @property DateTimeFormatter $preferences
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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

    protected function preferences(): Attribute
    {
        return Attribute::make(
            get: fn (): DateTimeFormatter => DateTimeFormatter::from([
                'date_format' => $this->attributes['date_format'] ?? null,
                'time_format' => $this->attributes['time_format'] ?? null,
            ])
        );
    }
}
