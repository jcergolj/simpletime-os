<?php

namespace App\Models;

use App\Enums\DateFormat;
use App\Enums\TimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $with = ['hourlyRate'];

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

    public function hourlyRate(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(HourlyRate::class, 'rateable');
    }

    public function getPreferredDateFormat(): DateFormat
    {
        return DateFormat::from($this->date_format ?? DateFormat::default()->value);
    }

    public function getPreferredTimeFormat(): TimeFormat
    {
        return TimeFormat::from($this->time_format ?? TimeFormat::default()->value);
    }

    public function formatDate($date): string
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format($this->getPreferredDateFormat()->dateFormat());
    }

    public function formatTime($time): string
    {
        if (is_string($time)) {
            $time = \Carbon\Carbon::parse($time);
        }

        return $time->format($this->getPreferredTimeFormat()->timeFormat());
    }

    public function formatDatetime($datetime): string
    {
        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }

        $dateFormat = $this->getPreferredDateFormat();
        $timeFormat = $this->getPreferredTimeFormat();

        return $datetime->format($dateFormat->datetimeFormatWithTime($timeFormat));
    }

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
